<?php

namespace App\Http\Resources\Leads;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
//            'id' =>$this->id,
//            'title'=>$this->title,
//            'likes'=>$this->likes,

            "id"=>$this->id,
            "company"=>$this->company,
            "fullname"=>$this->fullname,
            "phone"=>$this->phone,
            "email"=>$this->email,
            "comment"=>$this->comment,
            "status"=>$this->status,


        ];
    }
}
