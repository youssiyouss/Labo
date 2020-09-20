<?php

namespace App\Console\Commands;

use App\Notifications\InvoicePaid;
use Notification;
use App\User;
use Illuminate\Console\Command;

class NewYear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:newYear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Wishing members a happy new year';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $user = User::all();
        $alerte = collect([
            'type' => 'weekend',
            'title' => "LRIT vous souhaite une bonne année !",
            'voir' => ''
        ]);
        Notification::send($user, new InvoicePaid($alerte));

    }
}
