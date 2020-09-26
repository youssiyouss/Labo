@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0">Bienvenue au LRIT !</h4>
  </div>
  <div class="d-flex align-items-center flex-wrap text-nowrap">
    <div class="input-group date datepicker dashboard-date mr-2 mb-2 mb-md-0 d-md-none d-xl-flex" id="dashboardDate">
      <span class="input-group-addon bg-transparent"><i data-feather="calendar" class=" text-primary"></i></span>
      <input type="text" class="form-control">
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12 col-xl-12 stretch-card">
    <div class="row flex-grow">
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline">
              <h6 class="card-title mb-0 text-info">Nouveaux RFPs  : </h6>

            </div>
            <div class="row">
              <div class="col-6 col-md-12 col-xl-5">
                <div class="d-flex align-items-baseline">
                 <h3 class="mb-2">
                    @php
                        $rfps=DB::table('rfps')
                            ->select(DB::raw('count(*) as count'))
                            ->whereMonth('created_at', Carbon\carbon::now()->month)
                            ->count();
                        echo $rfps;
                    @endphp
                </h3><span class="text-muted"> RFPs</span>
                </div>
                <div class="d-flex align-items-baseline">
                  <p class="text-warning">
                    <span>Pour ce mois</span>
                  </p>
                </div>
              </div>
              <div class="col-6 col-md-12 col-xl-7">
                <div id="apexChart1" class="mt-md-3 mt-xl-0"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline">
              <h6 class="card-title mb-0 text-info">Nouvelles sumissions  : </h6>

            </div>
            <div class="row">
              <div class="col-6 col-md-12 col-xl-5">
                <div class="d-flex align-items-baseline">
                    <h3 class="mb-2">
                    @php
                        $projets=DB::table('projets')
                            ->select(DB::raw('count(*) as count'))
                            ->whereMonth('created_at', Carbon\carbon::now()->month)
                            ->count();
                        echo $projets;
                    @endphp</h3><span class="text-muted"> Projets</span>
                </div>
                <div class="d-flex align-items-baseline">
                  <p class="text-warning">
                    <span>Pour ce mois</span>
                   </p>
                </div>
              </div>
              <div class="col-6 col-md-12 col-xl-7">
                <div id="apexChart2" class="mt-md-3 mt-xl-0"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline">
              <h6 class="card-title mb-0 text-info">Numéro de membres :</h6>
              <div class="dropdown mb-2">
                <button class="btn p-0" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                  <a class="dropdown-item d-flex align-items-center" href="#members"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                 </div>
              </div>
            </div>
            <div class="row">
              <div class="col-6 col-md-12 col-xl-5">
                <h3 class="mb-2">
                    @php
                       $membres=DB::table('users')
                            ->select(DB::raw('count(*)'))
                            ->count();
                            echo $membres;
                    @endphp
                </h3>
                <div class="d-flex align-items-baseline">
                  <p class="text-warning">
                    <span >Dans LRIT</span>

                  </p>
                </div>
              </div>
              <div class="col-6 col-md-12 col-xl-7">
                <div id="apexChart3" class="mt-md-3 mt-xl-0"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> <!-- row -->
<div class="row">
  <div class="col-12 col-xl-12 grid-margin stretch-card">
    <div class="card overflow-hidden">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title mb-0">Projets en cours de travails</h6>
          <div class="dropdown mb-2">
            <button class="btn p-0" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
              <a class="dropdown-item d-flex align-items-center" href="{{ url('projets') }}"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <thead>
              <tr>
                <th class="pt-0">#</th>
                <th class="pt-0">Nom Projet</th>
                <th class="pt-0">Date Debut</th>
                <th class="pt-0">Date Echeance</th>
                <th class="pt-0">L'RFP</th>
                <th class="pt-0">Chef De Projet</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($projet as $p)
                <tr>
                    <td>{{$p->id}}</td>
                    <td data-toggle="popover" title="{{$p->nom}}">{{Str::limit($p->nom, 35,'...')}}</td>
                    <td>{{$p->lancement}}</td>
                    <td><span class="badge badge-danger">{{$p->cloture}}</span></td>
                    <td data-toggle="popover" title="{{$p->titre}}">{{Str::limit($p->titre, 35,'...')}}</td>
                    <td>{{$p->name}} {{$p->prenom}}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    </div>
  </div>


<div class="row grid-margin stretch-card">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title mb-0">Appel a soumissions pour ce mois </h6>

        </div>
       <div class="d-flex flex-column">
       @php

        $rfps = DB::table('rfps')->select('rfps.*')
        ->where('dateEcheance','<=', carbon\Carbon::parse(now('Africa/Algiers')))
        ->orderBy('dateEcheance','desc')
        ->get();
        $n=0;
       @endphp
       @foreach($rfps as $r)
       @php $n=$n+1; @endphp
          <a href="{{url('rfps/'.$r->id)}}" class="d-flex align-items-center border-bottom pb-3">
            <div class="mr-3">
            #{{$n}}
            </div>
            <div class="w-100">
              <div class="d-flex justify-content-between">
              <h6 class="text-body mb-2">{{$r->titre}}</h6>
                <p class="text-muted tx-12">{{$r->dateEcheance}}</p>
              </div>
            <p class="text-muted tx-13">{{$r->type}}</p>
            </div>
          </a>
          @endforeach
        </div>
      </div>
    </div>
  </div>


</div> <!-- row -->
@can('Acces',Auth::user())
<div class="row">
  <div class="col-12 col-xl-12 grid-margin stretch-card">
    <div class="card overflow-hidden">
      <div class="card-body" >
        <div class="row align-items-start mb-2">
            <form method="GET">
                <div class="form-group" >
                    <div class="input-group date" id="datePickerExample" data-target-input="nearest">
                        <div class="input-group date datepicker" id="datePickerExample">
                            <input  name="year1" type="text" class="form-control atetimepicker-input" placeholder="année .."><span class="input-group-addon"><i data-feather="calendar"></i></span>
                        </div>
                    </div>
                </div>

            </form>
        </div>
        <div class="flot-wrapper">
            <div class=" card-title text-center bg-dark">Taux annuelle des projets actifs pour chaque membre </div>

          <canvas id="ActiveProjects"></canvas>
        </div>
      </div>
    </div>
  </div>
</div> <!-- row -->

<div class="row">
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title mb-0"  id="members"0>Taux de réponses aux appels d'offre</h6>
          <div class="dropdown mb-2">
            <button class="btn p-0" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
            </div>
          </div>
        </div>
        <p class="text-muted mb-4">Nombre des soumissions pour chaque appel d'offre</p>
        <div>
          <canvas id="rfpsChart"></canvas>

        </div>
      </div>
    </div>
  </div>
  <?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'labo';
$rfps='';
$accepted='';
$refused='';
$reserve='';

$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);


            $sql="SELECT ID_rfp,COUNT(ID_rfp) as count
                    FROM projets
                    GROUP BY ID_rfp";
            $result = mysqli_query($mysqli, $sql);
             while ($value = mysqli_fetch_array($result)) {
                $rfps =$rfps."'#".$value['ID_rfp']."',";
            }

            $sql1="SELECT ID_rfp,COUNT(ID_rfp) as count
                    FROM projets
                    GROUP BY ID_rfp";
            $result1= mysqli_query($mysqli, $sql1);
            while ($value = mysqli_fetch_array($result1)) {
              $accepted =$accepted.$value['count'].',';
            }

            $rfps = trim($rfps,",");
            $accepted = trim($accepted,",");

?>


<script type="text/javascript">
var ctx = document.getElementById("rfpsChart").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $rfps ?>],
        datasets:
       [ {
            label: 'Projects number',
            data: [<?php echo $accepted ?>],
            backgroundColor: '#727cf5',
            borderWidth: 1
        }]
        },

        options: {
              responsive: true,
              tooltips: {
                mode: 'index',
                intersect: false,
              },
              hover: {
                mode: 'nearest',
                intersect: true
              },
              scales: {
                xAxes: [{
                stacked: true,
                  display: true,
                  scaleLabel: {
                    display: true,
                    labelString: 'RFPs'
                  }
                }],
                yAxes: [{
                  stacked: true,
				  ticks: { beginAtZero: true,stepSize:1},
                  display: true,
                  scaleLabel: {
                    display: true,
                    labelString: 'Submissions'
                  }
                }]
              }
            }
});

</script>
  <div class="col-lg-6 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title mb-0">Clients et Partenairs</h6>
        </div>
           <canvas id="clients" width="533" height="266"></canvas>
           <div class="col-6">
            <div>
              <label class="d-flex align-items-center tx-10 text-uppercase font-weight-medium text-info">Nombre Totale des clients :</label>
              <h5 class="font-weight-bold mb-0">
                @php
                     $c=DB::table('clients')
                            ->select(DB::raw('count(*) as count'))
                            ->count();
                        echo $c;
                @endphp </h5>
            </div>
          </div>
       </div>
    </div>
  </div>

<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'labo';
$pays='';
$nums='';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);

       $sql="SELECT pays,COUNT(*) as count
                FROM clients
                GROUP BY pays";
        $result = mysqli_query($mysqli, $sql);
         while ($value = mysqli_fetch_array($result)) {
                $pays =$pays."'".$value['pays']."',";
                $nums =$nums."'".$value['count']."',";
            }
            $pays = trim($pays,",");
            $nums = trim($nums,",");

?>
<script type="text/javascript">
     var ctx = document.getElementById("clients").getContext('2d');
     var myChart = new Chart(ctx, {
     type: 'doughnut',
     data: {
     labels: [<?php echo $pays; ?>],
     datasets:[{
          label: 'Vente par mois',
          data: [<?php echo $nums; ?>],
          backgroundColor: ['rgba(191, 85, 236, 0.5)',
                            'rgba(207, 0, 15, 0.5)',
							'rgba(63, 195, 128, 0.5)',
                            'rgba(154, 18, 179, 0.5)',
                            'rgba(248, 148, 6, 0.5)',
                            'rgba(140, 20, 252, 0.5)',
                            'rgba(77, 5, 232, 0.5)',
                            'rgba(77, 5, 232, 0.5)',
       						'rgba(82, 179, 217, 0.5)',
							'rgba(254, 241, 96, 0.5)',
							'rgba(243, 156, 18, 0.5)',
							'rgba(46, 49, 49, 0.5)'],
         borderColor: ['rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(219, 10, 91, 0.5)',
                        'rgba(191, 85, 236, 0.5)',
						'rgba(82, 179, 217, 0.5)',
						'rgba(63, 195, 128, 0.5)',
						'rgba(254, 241, 96, 0.5)'
                    ],
           borderWidth: 2
           },
        ]},
     options: {
               responsive: true,
               tooltips: {
               mode: 'index',
               intersect: false,
            },
                hover: {
                        mode: 'nearest',
                        intersect: true
                    },
                animation: {animateScale: true,animateRotate: true}

                }
            });
</script>

</div> <!-- row -->
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form method="GET">
                <div class="col-sm-3">
                <div class="form-group" >
                    <div class="input-group date" id="datetimepicker10" data-target-input="nearest">
                        <input name="year" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker10" placeholder="année .."/>
                        <div class="input-group-append" data-target="#datetimepicker10" data-toggle="datetimepicker">
                            <div class="form-control input-group-text"> <i data-feather="calendar"></i></div>
                        </div>

                    </div>
                </div>
                </div>
            </form>

            <div class=" card-title text-center bg-dark">Taux de participation des members par an </div>
            <canvas id="Dailysales"></canvas>
      </div>
      </div>
  </div>
<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'labo';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);


                        $n = '';
                        $l = '';
                        $m = '';
                        $r = "";
                        $year = '';
if(isset($_GET['year']) && $_GET['year']<=date("Y")) {
    $year = $_GET['year'];
}
else{
 $year = date("Y");
}
 if(isset($_GET['year1']) && $_GET['year1']<=date("Y")) {
    $year1 = $_GET['year1'];
}
else{
 $year1 = date("Y");
}

      $sql="SELECT users.id,users.name,users.prenom,COUNT(projets.chefDeGroupe) nbrProjet
                 FROM projets,users
                 WHERE projets.chefDeGroupe=users.id
                 AND YEAR(projets.created_at) = $year1
                 group BY projets.chefDeGroupe";
        $result = mysqli_query($mysqli, $sql);
         while ($value = mysqli_fetch_array($result)) {
                $n =$n.$value['nbrProjet'].',';
                $r =$r."'".$value['id']."_".$value['name']." ".$value['prenom']."',";
               }
            $n = trim($n,",");
            $r = trim($r,",");
            /////////////////Nombre de projets en cours pour chaque chef de groupe
        $sql1 =  "SELECT users.id,users.name,users.prenom , COUNT(distinct(taches.ID_projet)) nbrProjet
                 FROM delivrables , users , taches
                 WHERE delivrables.id_respo=users.id
                 AND delivrables.id_tache=taches.id
                 AND YEAR(delivrables.created_at) = $year
                 group BY delivrables.id_respo";
        $result1 = mysqli_query($mysqli, $sql1);
        while ($value = mysqli_fetch_array($result1)) {
                $l =$l.$value['nbrProjet'].',';
                $m =$m."'".$value['id']."_".$value['name']." ".$value['prenom']."',";
                }
            $l = trim($l,",");
            $m = trim($m,",");
            ///////////////Nombre de participations dans le projets pour chaque chercheurs

?>

<script type="text/javascript">
var ctx = document.getElementById("Dailysales").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $m; ?>],
        datasets:
        [{
            label: 'Travail en cours',
            data: [<?php echo $l; ?>],
            backgroundColor: '#821752',
            borderColor: '#edc988',
            borderWidth: 2}
        ]

        },

        options: {
              responsive: true,
              tooltips: {
                mode: 'index',
                intersect: false,
              },
              hover: {
                mode: 'nearest',
                intersect: true
              },
              scales: {
                xAxes: [{
                    //stacked: true,
                  display: true,
                  scaleLabel: {
                    display: true,
                    labelString: 'Membre'
                  }
                }],
                yAxes: [{

				  ticks: { beginAtZero: true,stepSize:1	 },
                  display: true,
                  scaleLabel: {
                    display: true,
                    labelString: 'Nombre de projet'
                  }
                }]
              }
            }
});

var ctx = document.getElementById("ActiveProjects").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $r; ?>],
        datasets:
        [{
            label: 'Projets Actives',
            data: [<?php echo $n; ?>],
            backgroundColor: '#ffcbcb',
            borderColor: '#407088',
            borderWidth: 2}
        ]

        },

        options: {
              responsive: true,
              tooltips: {
                mode: 'index',
                intersect: false,
              },
              hover: {
                mode: 'nearest',
                intersect: true
              },
              scales: {
                xAxes: [{
                    //stacked: true,
                  display: true,
                  scaleLabel: {
                    display: true,
                    labelString: 'Membres'
                  }
                }],
                yAxes: [{

				  ticks: { beginAtZero: true,stepSize:1	 },
                  display: true,
                  scaleLabel: {
                    display: true,
                    labelString: 'Nombre de projets'
                  }
                }]
              }
            }
});

</script>


@endcan
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/progressbar-js/progressbar.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
  <script src="{{ asset('assets/js/chartjs.js') }}"></script>
@endpush

