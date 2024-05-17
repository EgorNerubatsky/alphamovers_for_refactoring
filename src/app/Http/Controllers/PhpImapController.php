<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Webklex\PHPIMAP\ClientManager;
use App\Models\Email;
use Webklex\PHPIMAP\Client;

// use Webklex\IMAP\Facades\Client;


// use Webklex\IMAP\Facades\Client;

class PhpImapController extends Controller
{

    public function index(Request $request)
    {

        $oClient = new Client();
        $oClient->connect();

        $oFolder = $oClient->getFolder('INBOX');
        $aMessages = $oFolder->query()->get();

        foreach ($aMessages as $oMessage) {
            $mailMessage = new Email();
            $mailMessage->subject = $oMessage->getSubject();
            $mailMessage->sender = $oMessage->GetFrom()[0]->mail;
            $mailMessage->date = $oMessage->getDate();
            $mailMessage->body = $oMessage->getHTMLBody();
        }

        $oClient->disconnect();


        // $cm = new ClientManager('config/imap.php');

        // $oClient = $cm->make([
        //     'host' => 'imap.ukr.net',
        //     'port' => 993,
        //     'encryption' => 'ssl',
        //     'validate_cert' => false,
        //     'username' => 'bnfed@ukr.net',
        //     'password' => 'eRtxHnQ7d7k4SE8q',
        //     'protocol' => 'imap',
        // ]);

        // $aFolders = $oClient->getFolders();
        // dd($aFolders);

        // $allMessages = [];

        // foreach ($aFolders as $oFolder) {
        //     $aMessage = $oFolder->messages()->all()->get();
        //     $allMessages = array_merge($allMessages, $aMessage->all());
        // }
        // dd($allMessages);


        // $paginator = collect($allMessages)->paginate($per_page = 5, $page = null, $page_name = 'imap_page');

        return view('erp.parts.emails.index', compact('paginator'));
    }




}









//     public function index(Request $request)
//     {


//         $cm = new ClientManager('config/imap.php');

//         // or use an array of options instead
// // $cm = new ClientManager($options = []);

//         /** @var \Webklex\PHPIMAP\Client $client */
//         // $client = $cm->account('account_identifier');

//         // or create a new instance manually
//         $client = $cm->make([
//             'host' => 'imap.ukr.net',
//             'port' => 993,
//             'encryption' => 'ssl',
//             'validate_cert' => false,
//             'username' => 'bnfed@ukr.net',
//             'password' => 'eRtxHnQ7d7k4SE8q',
//         ]);

//         //Connect to the IMAP Server
//         $client->connect();

//         //Get all Mailboxes
//         /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
//         $folders = $client->getFolders();
//         $allMessages = [];

//         //Loop through every Mailbox
//         /** @var \Webklex\PHPIMAP\Folder $folder */
//         foreach ($folders as $folder) {

//             //Get all Messages of the current Mailbox $folder
//             /** @var \Webklex\PHPIMAP\Support\MessageCollection $messages */
//             $messages = $folder->messages()->all()->get();

//             /** @var \Webklex\PHPIMAP\Message $message */
//             $allMessages = array_merge($allMessages, $messages->all());


//             // foreach ($messages as $message) {
//             //     echo 'Subject: ' . $message->getSubject() . '<br />';
//             //     echo 'Attachments: ' . $message->getAttachments()->count() . '<br />';
//             //     echo $message->getHTMLBody();

//             //     // Move the current Message to 'INBOX.read'
//             //     // if ($message->move('INBOX.read') == true) {
//             //     //     echo 'Message has ben moved';
//             //     // } else {
//             //     //     echo 'Message could not be moved';
//             //     // }
//             // }


//         }
//         // };
//         $paginator = $messages->paginate($per_page = 5, $page = null, $page_name = 'imap_page');
//         $paginator = collect($allMessages)->paginate($per_page = 5, $page = null, $page_name = 'imap_page');

//         return view('erp.modules.emails.index', compact('folders', 'paginator'));
//     }


// public function index(Request $request)
// {
//     $cm = new ClientManager('config/imap.php');


//     $client = $cm->make([
//         'host' => 'imap.ukr.net',
//         'port' => 993,
//         'encryption' => 'ssl',
//         'validate_cert' => false,
//         'username' => 'bnfed@ukr.net',
//         'password' => 'eRtxHnQ7d7k4SE8q',
//     ]);

//     try {
//         $client->connect();

//     } catch (\Webklex\PHPIMAP\Exceptions\ConnectionFailedException $e) {
//         echo 'IMAP connection failed: ' . $e->getMessage();
//         return;
//     } catch (\Exception $e) {
//         echo 'Error connecting to the IMAP server: ' . $e->getMessage();
//         return;
//     }

//     $per_page = 5;
//     $folders = $client->getFolders();
//     $allMessages = collect();

//     foreach ($folders as $folder) {

//         $messages = $folder->messages()->all()->get();
//         $chunkedMessages = $messages->chunk($per_page);
//         foreach ($chunkedMessages as $message) {
//             echo $message->subject . '<br />';
//             echo 'Attachments: ' . $message->getAttachments()->count() . '<br />';
//             echo $message->getHTMLBody();



//             //Move the current Message to 'INBOX.read'
//             // if ($message->move('INBOX.read') == true) {
//             //     echo 'Message has ben moved';
//             // } else {
//             //     echo 'Message could not be moved';
//             // }
//         }
//         foreach ($chunkedMessages as $chunk) {
//             $allMessages = $allMessages->merge($chunk);
//         }
//     }
//     $paginator = $allMessages->paginate($per_page, $page = null, $page_name = 'imap_page');


//     return view('erp.modules.emails.index', compact('folders', 'paginator'));
// }

// }
