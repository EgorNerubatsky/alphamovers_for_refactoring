<?php

namespace App\Models;

use App\Http\Requests\SearchRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @method static latest()
 * @method static whereIn(string $string, $emails)
 * @method static create(string[] $array)
 * @method static where(string $string, false $false)
 * @property false|mixed|string $attachment_paths
 */
class Email extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'subject',
        'sender',
        'date',
        'body',
        'attachment_paths',
        'read',
    ];

    public function makeReadEmail($id)
    {
        $email = Email::withTrashed()->find($id);
        $email->read = true;
        $email->save();

        return $email;
    }

    public function storeEmail($subject, $sender, $date, $body, $attachmentPaths): void
    {
        $mailMessage = new Email([
            'subject' => $subject,
            'sender' => $sender,
            'date' => $date,
            'body' => $body,
            'attachment_paths' => $attachmentPaths,
        ]);
        $mailMessage->save();
    }

    /**
     * @param $emails
     * @return void
     */
    public function deleteMail($emails): void
    {
        Email::whereIn('id', $emails)->delete();

    }

    public function forceDeleteMail($emails): void
    {
        Email::whereIn('id', $emails)->forceDelete();

    }

    public function restoreMail($id): void
    {
        Email::onlyTrashed()->find($id)->restore();
    }

    public function searchQuery($search)
    {
        return Email::where('subject', 'like', "%$search%")
            ->orWhere('sender', 'like', "%$search%")
            ->orWhere('body', 'like', "%$search%");
    }

    public function searchDeletedQuery($search)
    {
        return SendEmail::where('recipient_name', 'like', "%$search%")
            ->orWhere('message', 'like', "%$search%")
            ->orWhere('recipient_email', 'like', "%$search%")
            ->orWhere('sender_name', 'like', "%$search%")
            ->orWhere('subject', 'like', "%$search%");
    }
    public function newEmails()
    {
        return Email::where('read', false)->latest()->get();
    }



}
