<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClientBase;
use App\Models\ClientContact;

class ClientContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        ClientBase::all()->each(function($clientBase){
//            $clientContact = ClientContact::factory()->create();
//            $clientBase->clientContacts()->save($clientContact);
//        });


        ClientBase::all()->each(function ($clientBase) {
            $clientContact = ClientContact::factory()->create();
            $clientBase->clientContacts()->save($clientContact);
        });


    }


//    public function run(): void
//    {
//        $clientBases = ClientBase::factory(10)->create();
//
//        $clientBases->each(function ($clientBase) {
//            $clientContact = ClientContact::factory()->create(['client_base_id' => $clientBase->id]);
//            $clientBase->clientContacts()->save($clientContact);
//        });
//    }
}
