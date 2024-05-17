<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Gmail;
use Google_Service_Gmail_Message;
use League\OAuth2\Client\Provider\Google;
use Laravel\Socialite\Facades\Socialite;


class GmailController extends Controller
{

    public function index()
    {
        $token = session('gmail_token');
        dump($token);

        // Initialize Google Client
        $client = new Google_Client();
        $client->setAuthConfig(base_path('config/gmailconf.json'));
        $client->setAccessToken($token);



        // Create Gmail service
        $service = new Google_Service_Gmail($client);


        // Get list of messages
        $messages = $service->users_messages->listUsersMessages('me');

        foreach($messages->getMessages() as $message){
            $message = $service->users_messages->get('me', $message->getId());
            $messageData = $message->toSimpleObject();
            dump($messageData);


        }
            return view('erp.parts.mail.index', ['messages'=>$messages]);



    }
    public function redirectToGoogle()
    {

        return Socialite::driver('google')->redirect();

    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        // Initialize Google Client
        $client = new Google_Client();
        $client->setAuthConfig(base_path('src/config/gmailconf.json'));
        $client->setAccessToken($user->token);

        // Store Gmail API token in the session
        session(['gmail_token' => $user->token]);

        return redirect()->route('gmail.index');

    }


}
