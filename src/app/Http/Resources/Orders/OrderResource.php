<?php

namespace App\Http\Resources\Orders;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

        'id'=>$this->id,
        'client_id'=>$this->client_id,
        'execution_date'=>$this->execution_date,
        'review'=>$this->review,
        'order_source'=>$this->order_source,
        'payment_form'=>$this->payment_form,
        'number_of_workers'=>$this->number_of_workers,
        'city'=>$this->city,
        'street'=>$this->street,
        'house'=>$this->house,
        'service_type'=>$this->service_type,
        'task_description'=>$this->task_description,
        'straps'=>$this->straps,
        'tools'=>$this->tools,
        'respirators'=>$this->respirators,
        'transport'=>$this->transport,
        'order_hrs'=>$this->order_hrs,
        'price_to_customer'=>$this->price_to_customer,
        'price_to_workers'=>$this->price_to_workers,
        'min_order_amount'=>$this->min_order_amount,
        'min_order_hrs'=>$this->min_order_hrs,
        'total_price'=>$this->total_price,
        'payment_note'=>$this->payment_note,
        'user_manager_id'=>$this->user_manager_id,
        'user_logist_id'=>$this->user_logist_id,
        'user_brigadier_id'=>$this->user_brigadier_id,
        'status'=>$this->status,






        ];
    }
}
