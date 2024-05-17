<?php

namespace App\Mailboxes;

use BeyondCode\Mailbox\Http\Controllers\MailCareController;
use BeyondCode\Mailbox\InboundEmail;

class IncomingMailbox extends MailCareController
{
    public function __invoke(InboundEmail|\BeyondCode\Mailbox\Http\Requests\MailCareRequest $email)
    {
        // Handle the incoming email
        // You can process the email, save it to the database, etc.
        // Access email properties like $email->subject, $email->from, etc.
    }
}
