<?php

namespace Database\Seeders;

use App\Models\ClientBase;
use Illuminate\Database\Seeder;
use App\Models\ClientContactPersonDetail;

class ClientContactPersonDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        ClientContact::all()->each(function($clientContact){
//            $clientContactPersonDetail = ClientContactPersonDetail::factory()->count(2)->create(['client_contact_id'=>$clientContact->id]);
//            // $clientContact->clientContactPersonDetails()->saveMany($clientContactPersonDetail);
//        });


        ClientBase::all()->each(function ($clientContact) {
            ClientContactPersonDetail::factory()->count(2)->create(['client_base_id' => $clientContact->id]);
        });

    }
}
