<?php

namespace App\Services;

use App\Http\Requests\MailSendRequest;
use App\Http\Requests\SearchRequest;
use App\Mail\MailShipped;
use App\Models\Email;
use App\Models\SendEmail;
use Html2Text\Html2Text;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Webklex\PHPIMAP\ClientManager;
use Webklex\PHPIMAP\Exceptions\AuthFailedException;
use Webklex\PHPIMAP\Exceptions\ConnectionFailedException;
use Webklex\PHPIMAP\Exceptions\EventNotFoundException;
use Webklex\PHPIMAP\Exceptions\FolderFetchingException;
use Webklex\PHPIMAP\Exceptions\GetMessagesFailedException;
use Webklex\PHPIMAP\Exceptions\ImapBadRequestException;
use Webklex\PHPIMAP\Exceptions\ImapServerErrorException;
use Webklex\PHPIMAP\Exceptions\MaskNotFoundException;
use Webklex\PHPIMAP\Exceptions\MessageFlagException;
use Webklex\PHPIMAP\Exceptions\ResponseException;
use Webklex\PHPIMAP\Exceptions\RuntimeException;


class MailControllerService extends Controller
{
    protected RolesRoutingService $rolesRoutingService;

    private SendEmail $sendEmailModel;
    private Email $emailModel;

    private FilesActivityService $filesActivityModel;


    public function __construct(
        RolesRoutingService  $rolesRoutingService,
        SendEmail            $sendEmailModel,
        Email                $emailModel,
        FilesActivityService $filesActivityModel,

    )
    {
        $this->rolesRoutingService = $rolesRoutingService;
        $this->sendEmailModel = $sendEmailModel;
        $this->emailModel = $emailModel;
        $this->filesActivityModel = $filesActivityModel;
    }

    /**
     * @return void
     * @throws AuthFailedException
     * @throws ConnectionFailedException
     * @throws FolderFetchingException
     * @throws ImapBadRequestException
     * @throws ImapServerErrorException
     * @throws MaskNotFoundException
     * @throws ResponseException
     * @throws RuntimeException
     * @throws EventNotFoundException
     * @throws GetMessagesFailedException
     * @throws MessageFlagException
     */
    public function mailGetMails(): void
    {
        $cm = new ClientManager('config/imap.php');

        $client = $cm->make([
            'host' => 'imap.ukr.net',
            'port' => 993,
            'encryption' => 'ssl',
            'validate_cert' => false,
            'username' => 'bnfed@ukr.net',
            'password' => 'eRtxHnQ7d7k4SE8q',
            'protocol' => 'imap',
        ]);

        $client->connect();

        $folders = $client->getFolders();
        foreach ($folders as $folder) {
            $messages = $folder->messages()->unseen()->get();


            foreach ($messages as $message) {
                $message->setFlag(['SEEN']);
                $subject = mb_decode_mimeheader($message->getSubject());

                $body = $message->getHTMLBody();

                // Используйте HtmlDomParser для обработки HTML
                $textContent = new Html2Text($body);

                // Возвращаем обработанный HTML
                $bodyWithoutStyles = $textContent->getText();


                $attachmentPaths = null;

                $sender = $message->GetFrom()[0]->mail;

                $files = $message->getAttachments();
                if (count($files) > 0) {

                    $attachmentPaths = $this->filesActivityModel->multipleStoreFiles($message, "uploads/incoming_email_files/$sender");
//                    foreach ($message->getAttachments() as $attachment) {
//
//                        $filename = $attachment->getFilename();
//
//                        if (mb_strlen($filename) > 30) {
//                            $filename = uniqid() . '.' . $attachment->getExtension();
//                        } else {
//                            $filename = $attachment->getFilename();
//                        }
//
//                        $attachmentContent = $attachment->getContent();
//
//                        $directory = "uploads/incmailfiles/$sender";
//                        // Ensure the directory exists
//                        if (!file_exists($directory)) {
//                            mkdir($directory, 0755, true);
//                        }
//                        $attachmentPath = "$directory/$filename";
//                        file_put_contents(public_path($attachmentPath), $attachmentContent);
//
//
//                        $attachmentPaths[] = $attachmentPath;
//                    }
                }
                $this->emailModel->storeEmail($subject, $message->GetFrom()[0]->mail, $message->getDate(), $bodyWithoutStyles, $attachmentPaths);

//                $mailMessage = new Email([
//                    'subject' => $subject,
//                    'sender' => ,
//                    'date' => ,
//                    'body' => ,
//
//                ]);
//                $mailMessage->save();
//
//
//                if (!empty()) {
//                    $mailMessage->attachment_paths = json_encode($attachmentPaths);
//                }
//                $mailMessage->save();

            }
        }
        $client->disconnect();


    }

    public function mailSearch(SearchRequest $request): Application|Factory|View|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $searchType = $request->input('search_type');
        $mails = $this->sendSearch($request, $searchType)->paginate(10);
        $view = 'erp.parts.emails.index';

        if ($searchType === 'send_emails') {
            $view = 'erp.parts.emails.send_emails';
        } elseif ($searchType === 'trashed_emails') {
            $view = 'erp.parts.emails.removed_emails';
        }
        return $this->mailView($view, [], [], $mails);

    }

    private function sendSearch(Request $request, $searchType): Builder
    {
        $search = $request->input('search');
        if ($searchType === "send_emails") {
            return $this->sendEmailModel->searchQuery($search);
        } else if ($searchType === "inbox_emails") {
            return $this->emailModel->searchQuery($search);
        } else {
            return $this->emailModel->searchDeletedQuery($search);
        }
    }


    public function mailSendMail(MailSendRequest $request): RedirectResponse
    {
        $recipient = $request->input('recipient_email');
        $attachmentPaths = null;

        if ($request->hasFile('attachment')) {
            $attachmentPaths = $this->filesActivityModel->multipleAddFiles($request, 'attachment', "uploads/send_email_files/$recipient/");
        }

        $this->sendEmailModel->createEmail($request, $attachmentPaths);
        $this->MailShipped($request, $attachmentPaths);

        return $this->mailIndexRedirect();
    }

    private function MailShipped(MailSendRequest $request, $attachmentPaths): void
    {
        Mail::to($request->input('recipient_email'))->send(new MailShipped($request->all(), $attachmentPaths));
    }

    public function mailOpenEmail($id): Application|Factory|View|\Illuminate\Contracts\Foundation\Application
    {
        $email = $this->emailModel->makeReadEmail($id);

        $decodeAttachments = $this->getDecodeAttachments($email);
        $filesNames = $this->getFileNames($email, $decodeAttachments);

        return $this->mailView('erp.parts.emails.mail_view', $email, $filesNames, []);
    }

    public function mailOpenSendEmail($id): Application|Factory|View|\Illuminate\Contracts\Foundation\Application
    {
        $email = $this->sendEmailModel->findSendEmail($id);
        $decodeAttachments = $this->getDecodeAttachments($email);
        $filesNames = $this->getFileNames($email, $decodeAttachments);

        return $this->mailView('erp.parts.emails.sent_mail_view', $email, $filesNames, []);
    }

    private function getDecodeAttachments($email): mixed
    {
        $encodedAttachments = $email->attachment_paths;
        return json_decode($encodedAttachments, true);
    }

    private function getFileNames($email, $decodeAttachments): array
    {
        $filesNames = [];
        if (isset($email->attachment_paths)) {
            foreach ($decodeAttachments as $decodeAttachment) {
                $pathInfo = pathinfo($decodeAttachment);
                $fileName = $pathInfo['basename'];
                $filesNames[$fileName] = $decodeAttachment;
            }
        }
        return $filesNames;
    }

    public function deleteEmail(Request $request): RedirectResponse
    {
        $selectedEmails = $request->input('selected_emails');

        if (!empty($selectedEmails)) {

            $this->emailModel->deleteMail($selectedEmails);

        }

        return $this->mailIndexRedirect();
    }

    public function forceDeleteEmails(Request $request): RedirectResponse
    {
        $selectedEmails = $request->input('selected_emails');

        if (!empty($selectedEmails)) {
            $this->emailModel->forceDeleteMail($selectedEmails);
        }

        return redirect()->back();
    }

    public function mailRestore($id): RedirectResponse
    {
        $this->emailModel->restoreMail($id);

        return redirect()->back();
    }

    public function mailView($view, $email, $filesNames, $mails): View|Application|Factory|JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        $count = Email::where('read', false)->count();
        $deleteCount = Email::onlyTrashed()->where('read', false)->count();

        if(request()->expectsJson()){
            return response()->json(compact('mails'));
        }

        return view($view, compact('count', 'deleteCount', 'roleData', 'email', 'filesNames', 'mails'));
    }

    public function mailIndexRedirect(): RedirectResponse
    {
        $user = Auth::user();
        $roleData = $this->rolesRoutingService->getRoleData($user);
        return redirect()->route($roleData['roleData']['emails_index'])->with('success', 'Ваш лист вiдправлено!!');
    }
}

