<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use App\Http\Controllers\MailController;

class CheckEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        app()->make(MailController::class)->getMails(new Request());
        $this->info('Emails checked successfully!');
    }
}
