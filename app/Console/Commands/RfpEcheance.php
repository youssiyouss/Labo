<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Notifications\InvoicePaid;
use Notification;
use App\User;
use App\RFP;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class RfpEcheance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'RFP:echeance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manages expired RFPs';

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
         $listeM = DB::table('rfps')
            ->join('clients', 'clients.id', '=', 'rfps.maitreOuvrage')
            ->select('rfps.*', 'clients.ets')
            ->orderBy('rfps.created_at', 'desc')
            ->get();

            $user =User::all();
            $today = Carbon::parse(now('Africa/Algiers'));
            //$today = Carbon::parse(now()->timestamp);

            foreach ($listeM as $rfp) {
                $dateEnd = Carbon::parse($rfp->dateEcheance, 'Africa/Algiers');
                //Quand la date d'écheance arrive
                if ($dateEnd->diffInDays($today) == 0 && $today->diffInMinutes($rfp->heureEcheance) == 60) {
                    $alerte = collect([
                        'type' => 'Supprimer RFP',
                        'title' => "L'RFP : '" . $rfp->titre . "' est supprimer définitivement !",
                        'id' => $rfp->id,
                        'nom' => $rfp->titre,
                        'par' => 'LRIT',
                        'voir' => ''
                    ]);
                    Notification::send($user, new InvoicePaid($alerte));
                    RFP::find($rfp->id)->delete();
                }
                //Quand il reste 2h avant la date d'écheance
                else if ($dateEnd->diffInDays($today) == 0 && $today->diffInHours($rfp->heureEcheance) == 2) {
                    $alerte = collect([
                        'type' => 'echeance',
                        'title' => "Il reste 2h avant que l'RFP : '" . $rfp->titre . "' va etre supprimer définitivement !",
                        'id' => $rfp->id,
                        'nom' => $rfp->titre,
                        'par' => 'LRIT',
                        'voir' => 'rfps/' . $rfp->id
                    ]);
                    Notification::send($user, new InvoicePaid($alerte));
                }
                //Quand il reste 1 jour avant la date d'écheance
                else if ($dateEnd->diffInDays($today) == 1) {
                    $alerte = collect([
                        'type' => 'echeance',
                        'title' => "Il reste 1 jour avant que l'RFP : '" . $rfp->titre . "' va etre supprimer définitivement !",
                        'id' => $rfp->id,
                        'nom' => $rfp->titre,
                        'par' => 'LRIT',
                        'voir' => 'rfps/' . $rfp->id
                    ]);
                    Notification::send($user, new InvoicePaid($alerte));
                }
                //Quand il reste 7 jours avant la date d'écheance
                else if ($dateEnd->diffInDays($today) == 6) {
                    $alerte = collect([
                        'type' => 'echeance',
                        'title' => "Il reste 1 semaine avant que l'RFP : '" . $rfp->titre . "' va etre supprimer définitivement !",
                        'id' => $rfp->id,
                        'nom' => $rfp->titre,
                        'par' => 'LRIT',
                        'voir' => 'rfps/' . $rfp->id
                    ]);
                    Notification::send($user, new InvoicePaid($alerte));
                }
            }
    }
}
