<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @method static findOrFail(int $id)
 * @method static whereIn(string $string, array $array)
 * @method static get()
 * @method static where(string $string, $id)
 * @method static create(array $array)
 */
class DocumentsPath extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'client_id',
        'path',
        'description',
        'status',
        'scan_recieved_date',
        'scan_sent_date',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(ClientBase::class, 'client_id');
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }

    public function updateDocumentsPath($lead, $order): void
    {
        $documentsPaths = DocumentsPath::where('lead_id', $lead->id)->get();
        foreach ($documentsPaths as $documentsPath) {
            $documentsPath->update([
                'order_id' => $order->id,
            ]);

        }
    }

    public function createDocumentsPath($orderId, $clientId, $path, $description, $status): DocumentsPath
    {
        $orderDocumentPath = new DocumentsPath([
            'order_id' => $orderId,
            'client_id' => $clientId,
            'path' => $path,
            'description' => $description,
            'status' => $status,
        ]);
        $orderDocumentPath->save();

        return $orderDocumentPath;
    }

    public function createLeadDocumentsPath(Lead $lead, $path): void
    {
        $orderDocumentPath = new DocumentsPath([

            'lead_id' => $lead->id,
            'path' => $path,
            'description' => 'Документ вiд замовника',
            'status' => 'Завантажено',
        ]);
        $orderDocumentPath->save();
    }

    public function updateStatus($invoiceDocument): void
    {
        $invoiceDocument->update([
            'status' => 'Рахунок сплачено',
        ]);
    }

    public function deleteDocumentsPath($deletedDocument, $clientDocument): void
    {
        $documentPath = public_path($deletedDocument);
        if (is_file($documentPath)) {
            unlink($documentPath);
        }
        $clientDocument->delete();

        $folderPath = dirname($documentPath);

        if (is_dir($folderPath) && count(glob($folderPath . '/*')) === 0) {
            rmdir($folderPath);
        }
    }

}
