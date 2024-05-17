<?php

namespace App\Http\Resources\Clients;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'company'=>$this->company,
            'type'=>$this->type,
            'debt_ceiling'=>$this->debt_ceiling,
            'identification_number'=>$this->identification_number,
            'code_of_the_reason_for_registration'=>$this->code_of_the_reason_for_registration,
            'main_state_registration_number'=>$this->main_state_registration_number,
            'director_name'=>$this->director_name,
            'contact_person_position'=>$this->contact_person_position,
            'acting_on_the_basis_of'=>$this->acting_on_the_basis_of,
            'registered_address'=>$this->registered_address,
            'zip_code'=>$this->zip_code,
            'postal_address'=>$this->postal_address,
            'payment_account'=>$this->payment_account,
            'bank_name'=>$this->bank_name,
            'bank_identification_code'=>$this->bank_identification_code,
//            'client_contacts.0.client_base_id'=>$this->clientContactPersonDetails->client_base_id,
        ];
    }
}
