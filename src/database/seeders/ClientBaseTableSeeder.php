<?php

namespace Database\Seeders;

use App\Models\ClientContact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClientBase;

class ClientBaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        ClientBase::factory(10)->create();

//        ClientBase::factory(10)->create()->each(function ($clientBase) {
//            $clientContact = ClientContact::factory()->create(['client_base_id' => $clientBase->id]);
//            $clientBase->clientContacts()->save($clientContact);
//        });

//        ClientBase::factory(10)->create()->each(function ($clientBase) {
//            $clientContact = ClientContact::factory()->create();
//            $clientBase->clientContacts()->save($clientContact);
//        });

        ClientBase::factory(10)->create();



    }
}
