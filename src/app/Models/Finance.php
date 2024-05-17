<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property mixed $transaction_date
 * @property mixed $amount
 * @property mixed $id
 * @method static where(string $string, mixed $param)
 * @method static create(array $array)
 */
class Finance extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_date',
        'amount',
        'company_balance',
    ];

    public function applyFinanceStartDateFilters($bankOperationQuery, $startDate, $endDate): void
    {
        if ($startDate && !$endDate) {
            $bankOperationQuery->where('transaction_date', '>=', $startDate);
        }
    }

    public function applyFinanceEndDateFilters($bankOperationQuery, $startDate, $endDate): void
    {
        if (!$startDate && $endDate) {
            $bankOperationQuery->where('transaction_date', '<=', $endDate);
        }
    }

    public function applyFinanceDateFilters($bankOperationQuery, $startDate, $endDate): void
    {
        if ($startDate && $endDate) {
            $bankOperationQuery->whereBetween('transaction_date', [$startDate, $endDate]);
        }
    }

    public function newFinance($order, $transactionDate): Finance
    {
        $newFinance = new Finance([
            'transaction_date' => $transactionDate,
            'amount' => $order->total_price,
        ]);
        $newFinance->save();

        return $newFinance;
    }

    public function companyBalanceUpdate($newFinanceItem, $fullCompanyBalance): void
    {
        $newFinanceItem->update([
            'company_balance' => $fullCompanyBalance,
        ]);
    }

    public function companyBalance($id)
    {
        return Finance::where('id', $id - 1)->value('company_balance');

    }

}
