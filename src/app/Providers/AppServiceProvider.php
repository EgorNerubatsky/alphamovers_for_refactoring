<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use BeyondCode\Mailbox\InboundEmail;
use BeyondCode\Mailbox\Facades\Mailbox;
use App\Models\Email;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Mailbox::from('bnfed@ukr.net', function (InboundEmail $email) {
            
        });
    }


    // Handle the incoming email
    // $subject = $email->subject();
    // $sender = $email->from();
    // $date = $email->date();
    // $body = $email->text();


    // Email::create([
    //     'subject' => $subject,
    //     'sender' => $sender,
    //     'date' => $date,
    //     'body' => $body,

    // ]);
}
// class MyMailbox
// {
//     public function handle(InboundEmail $email)
//     {
//         $data = ['subject' => $email->subject()];

//         Email::create($data);

//     }


// }

