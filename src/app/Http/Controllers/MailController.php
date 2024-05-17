<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailSendRequest;
use App\Http\Requests\SearchRequest;
use App\Services\MailControllerService;
use Exception;
use Html2Text\Html2Text;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Email;
use App\Models\SendEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Webklex\PHPIMAP\ClientManager;

//use BeyondCode\Mailbox\Http\Controllers\MailboxController as BaseController;

class MailController extends Controller
{
    private MailControllerService $mailControllerService;

    public function __construct(MailControllerService $mailControllerService)
    {
        $this->mailControllerService = $mailControllerService;
    }

    public function index(): View|Factory|\Illuminate\Foundation\Application|JsonResponse|Application
    {
        $mails = Email::latest()->paginate(10);
        return $this->mailControllerService->mailView('erp.parts.emails.index', [], [], $mails);
    }

    public function search(SearchRequest $request): Factory|View|\Illuminate\Foundation\Application|JsonResponse|Application|RedirectResponse
    {
        try {

            return $this->mailControllerService->mailSearch($request);
        } catch (Exception $e) {
            return back()->withErrors(['error' => "Произошла ошибка: " . $e->getMessage()]);
        }
    }

    public function newMail(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return $this->mailControllerService->mailView('erp.parts.emails.new_email', [], [], []);
    }

    public function sendMail(MailSendRequest $request): RedirectResponse
    {
        return $this->mailControllerService->mailSendMail($request);
    }

    public function getMails(): JsonResponse|RedirectResponse
//    {
//        try {
//            return $this->mailControllerService->mailGetMails();
//        } catch (Exception $e) {
//            Log::error('IMAP Connection Error: ' . $e->getMessage());
//            return response()->json(['error' => $e->getMessage()], 500);
//        }
//    }

    {
        try {
            $this->mailControllerService->mailGetMails();
//            $cm = new ClientManager('config/imap.php');
//
//            $client = $cm->make([
//                'host' => 'imap.ukr.net',
//                'port' => 993,
//                'encryption' => 'ssl',
//                'validate_cert' => false,
//                'username' => 'bnfed@ukr.net',
//                'password' => 'eRtxHnQ7d7k4SE8q',
//                'protocol' => 'imap',
//            ]);
//
//            $client->connect();
//
//            $folders = $client->getFolders();
//            foreach ($folders as $folder) {
//                $messages = $folder->messages()->unseen()->get();
//
//
//                foreach ($messages as $message) {
//                    $message->setFlag(['SEEN']);
//                    $subject = mb_decode_mimeheader($message->getSubject());
//
//                    $body = $message->getHTMLBody();
//
//                    // Используйте HtmlDomParser для обработки HTML
//                    $textContent = new Html2Text($body);
//
//                    // Возвращаем обработанный HTML
//                    $bodyWithoutStyles = $textContent->getText();
//
//                    $mailMessage = new Email([
//                        'subject' => $subject,
//                        'sender' => $message->GetFrom()[0]->mail,
//                        'date' => $message->getDate(),
//                        'body' => $bodyWithoutStyles,
//
//                    ]);
//                    $mailMessage->save();
//                    $attachmentPaths = [];
//
//                    $sender = $message->GetFrom()[0]->mail;
//
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
//                        $directory = "uploads/incmailfiles/{$sender}";
//                        // Ensure the directory exists
//                        if (!file_exists($directory)) {
//                            mkdir($directory, 0755, true);
//                        }
//                        $attachmentPath = "{$directory}/{$filename}";
//                        file_put_contents(public_path($attachmentPath), $attachmentContent);
//
//
//                        $attachmentPaths[] = $attachmentPath;
//                    }
//                    if (!empty($attachmentPaths)) {
//                        $mailMessage->attachment_paths = json_encode($attachmentPaths);
//                    };
//                    $mailMessage->save();
//                }
//            }
//            $client->disconnect();
            return redirect()->back()->with('reload', true);


        } catch (\Exception $e) {
            // Log the exception for further analysis
            Log::error('IMAP Connection Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function openEmail($id): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return $this->mailControllerService->mailOpenEmail($id);
    }

    public function deleteEmail(Request $request): RedirectResponse
    {
        return $this->mailControllerService->deleteEmail($request);
    }

    public function deletedEmails(): View|Factory|\Illuminate\Foundation\Application|Application
    {
        $mails = Email::onlyTrashed()->paginate(10);

        return $this->mailControllerService->mailView('erp.parts.emails.removed_emails', [], [], $mails);
    }

    public function forceDeleteEmails(Request $request): RedirectResponse
    {
        return $this->mailControllerService->forceDeleteEmails($request);
    }

    public function restoreEmail($id): RedirectResponse
    {
        return $this->mailControllerService->mailRestore($id);
    }

    public function sendEmails(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $mails = SendEmail::latest()->paginate(10);

        return $this->mailControllerService->mailView('erp.parts.emails.send_emails', [], [], $mails);
    }

    public function openSendEmail($id): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return $this->mailControllerService->mailOpenSendEmail($id);

    }

}
