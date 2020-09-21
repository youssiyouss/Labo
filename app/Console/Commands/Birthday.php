<?php

namespace App\Console\Commands;

use App\Notifications\InvoicePaid;
use Notification;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class Birthday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Detect Members birthdays';

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
        foreach ($user as $key => $u) {
                if(Carbon::parse(now())->format('d M')  === Carbon::parse($u->dateNaissance)->format('d M') )
                {       $alerte = collect([
                                    'type' => 'Birthday',
                                    'title' => "Joyeux anniversaire ".$u->prenom." ! que cette année soit pleine de succés et productivité pour vous :).",
                                    'par' => 'LRIT',
                                    'voir' => ''
                                ]);
                        Notification::send($u, new InvoicePaid($alerte));
                }
        }
    }
}
