<?php

namespace App\Http\Controllers;

use BeyondCode\Mailbox\Http\Controllers\MailgunController as BaseController;
use Illuminate\Http\Request;
use BeyondCode\Mailbox\Facades\Mailbox;
use BeyondCode\Mailbox\InboundEmail;
use Illuminate\Support\Facades\Log;
use App\Models\Email;



class MailboxController extends BaseController
{
    public function handle(Request $request)
    {
        $messageContent = $request->getContent();


        Log::info('Handling incoming email request');

        $email = InboundEmail::fromMessage($request->getContent());

        $subject = $email->subject();
        $sender = $email->from();
        // $date = $email->date() ? $email->date()->toDateTimeString() : null;
        // Проверка наличия даты и ее преобразование в строку
        // Проверка наличия даты и ее преобразование в строку
        // Пробуем получить дату из письма, иначе используем текущую дату
        $date = optional($email->date(), function () {
            return now();
        })->toDateTimeString();


        $body = $email->text();

        // Email::create([
        //     'subject' => $email->subject(),
        //     'sender' => $email->from(),
        //     'date' => $email->date(),
        //     'body' => $email->text(),
        // ]);

        Email::create([
            'subject' => $subject,
            'sender' => $sender,
            'date' => $date,
            'body' => $body,


        ]);


        Log::info('Email Subject: ' . $subject);
        Log::info('Email Sender: ' . $sender);

        Mailbox::callMailboxes($email);

        return response('', 200);
    }
}

