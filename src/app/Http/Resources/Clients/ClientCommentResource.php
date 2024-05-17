<?php

namespace App\Http\Resources\Clients;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'client_id'=>$this->client_id,
            'new_value'=>$this->new_value,
            'user_id'=>$this->user_id,
            'reason'=>$this->reason,
        ];
    }
}
