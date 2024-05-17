<?php

namespace App\Models;

use App\Http\Requests\SearchRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property mixed $order_id
 * @property mixed|string $beneficiary
 * @property mixed $payer
 * @property mixed $payment_purpose
 * @property mixed|string $document_number
 * @property mixed $amount
 * @property mixed $created_at
 * @property mixed $transaction_date
 * @method static distinct()
 * @method static where(string $string, string $string1, string $string2)
 * @method static create(array $array)
 */
class BankOperation extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'transaction_date',
        'amount',
        'payer',
        'beneficiary',
        'document_number',
        'order_execution_date',
        'payment_purpose',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function search(SearchRequest $request)
    {
        $search = $request->input('search');
        return BankOperation::where('payer', 'like', "%$search%")
            ->orWhere('beneficiary', 'like', "%$search%")
            ->orWhere('amount', 'like', "%$search%")
            ->orWhere('document_number', 'like', "%$search%")
            ->orWhere('payment_purpose', 'like', "%$search%");
    }

    public function applyBankOperationStartDateFilters($bankOperationQuery, $startDate, $endDate): void
    {
        if ($startDate && !$endDate) {
            $bankOperationQuery->where('created_at', '>=', $startDate);
        }
    }

    public function applyBankOperationEndDateFilters($bankOperationQuery, $startDate, $endDate): void
    {
        if (!$startDate && $endDate) {
            $bankOperationQuery->where('created_at', '<=', $endDate);
        }
    }

    public function applyBankOperationDateFilters($bankOperationQuery, $startDate, $endDate): void
    {
        if ($startDate && $endDate) {
            $bankOperationQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
    }

    public function applyBankOperationPayerFilters($bankOperationQuery, $payer): void
    {
        if ($payer) {
            $bankOperationQuery->where('payer', $payer);
        }
    }

    public function applyBankOperationBeneficiaryFilters($bankOperationQuery, $beneficiary): void
    {
        if ($beneficiary) {
            $bankOperationQuery->where('beneficiary', $beneficiary);
        }
    }

    public function applyBankOperationAmountFromFilters($bankOperationQuery, $amountFrom, $amountTo): void
    {
        if ($amountFrom && !$amountTo) {
            $bankOperationQuery->where('amount', '>=', $amountFrom);
        }
    }

    public function applyBankOperationAmountToFilters($bankOperationQuery, $amountFrom, $amountTo): void
    {
        if (!$amountFrom && $amountTo) {
            $bankOperationQuery->where('amount', '<=', $amountTo);
        }
    }

    public function applyBankOperationAmountToAndFromFilters($bankOperationQuery, $amountFrom, $amountTo): void
    {
        if ($amountFrom && $amountTo) {
            $bankOperationQuery->whereBetween('amount', [$amountFrom, $amountTo]);
        }
    }

    public function newBankOperation($invoiceDocument, $client, $order): BankOperation
    {
        $bankOperation = new BankOperation([
            'order_id' => $order->id,
            'amount' => $order->total_price,
            'beneficiary' => "АТ 'Alphamovers'",
            'payer' => $client->company,
            'payment_purpose' => $order->service_type,
            'document_number' => $invoiceDocument->id . '/' . date('Y/m'),
            'transaction_date' => now(),
        ]);
        $bankOperation->save();

        return $bankOperation;
    }
}
