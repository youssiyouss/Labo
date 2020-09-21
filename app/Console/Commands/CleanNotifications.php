<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class CleanNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Notification:cleanDB';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete notifications that are older than one month';

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

        $today = Carbon::parse(now('Africa/Algiers'));
        $notif = DB::table('notifications')
                ->get();

        foreach ($notif as $key => $n) {
            if($today->month() > Carbon::parse($n->created_at)->format('M') && $today->year() == Carbon::parse($n->created_at)->format('Y')){

                $n->delete();
            }
        }


    }
}
