<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UsersChat;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(LeadTableSeeder::class);
        $this->call(ClientBaseTableSeeder::class);
//        $this->call(ClientContactTableSeeder::class);
        $this->call(ClientContactPersonDetailTableSeeder::class);

        $this->call(OrderTableSeeder::class);
        $this->call(DocumentsPathSeeder::class);
        $this->call(ApplicantTableSeeder::class);
        $this->call(MoverTableSeeder::class);
        $this->call(MessageTableSeeder::class);
        $this->call(IntervieweeTableSeeder::class);
        $this->call(ChatTableSeeder::class);
        $this->call(UsersChatTableSeeder::class);
        $this->call(ChatsActivityTableSeeder::class);
        $this->call(UserTaskTableSeeder::class);
        $this->call(KanbanTableSeeder::class);

    }
}
