<?php

namespace App\Models;

use App\Http\Requests\MailSendRequest;
use App\Http\Requests\SearchRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @method static latest()
 * @method static where(string $string, string $string1, string $string2)
 */
class SendEmail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'recipient_name',
        'message',
        'sender_name',
        'recipient_email',
        'subject',
        'attachment_paths',
    ];

    public function createEmail(MailSendRequest $request, $path): void
    {
        $sendEmail = new SendEmail([
            'recipient_name' => $request->input('recipient_name'),
            'message' => $request->input('message'),
            'sender_name' => $request->input('sender_name'),
            'recipient_email' => $request->input('recipient_email'),
            'subject' => $request->input('subject'),
            'attachment_paths' => json_encode($path),
            // Store paths as JSON
        ]);
        $sendEmail->save();
    }

    public function findSendEmail($id)
    {
        return SendEmail::withTrashed()->find($id);
    }

    public function searchQuery($search){
        return SendEmail::where('recipient_name', 'like', "%$search%")
            ->orWhere('message', 'like', "%$search%")
            ->orWhere('recipient_email', 'like', "%$search%")
            ->orWhere('sender_name', 'like', "%$search%")
            ->orWhere('subject', 'like', "%$search%");
    }

}
