@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
  <div>
    <h4 class="mb-3 mb-md-0">Bienvenue dans LRIT !</h4>
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
              <h6 class="card-title mb-0 text-info">New RFPs  : </h6>

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
                    <span>For this month</span>
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
              <h6 class="card-title mb-0 text-info">New Submissions  : </h6>

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
                    @endphp</h3><span class="text-muted"> Projects</span>
                </div>
                <div class="d-flex align-items-baseline">
                  <p class="text-warning">
                    <span>For this month</span>
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
              <h6 class="card-title mb-0 text-info">Number of members :</h6>
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
                    <span >In LRIT</span>

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
          <h6 class="card-title mb-0">Active Projects</h6>
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
                <th class="pt-0">Project Name</th>
                <th class="pt-0">Start Date</th>
                <th class="pt-0">Due Date</th>
                <th class="pt-0">RFP</th>
                <th class="pt-0">Project Manager</th>
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
<div class="row">
  <div class="col-12 col-xl-12 grid-margin stretch-card">
    <div class="card overflow-hidden">
      <div class="card-body" >
        <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
          <h6 class="card-title mb-0">Revenue</h6>
          <div class="dropdown">
            <button class="btn p-0" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
            </div>
          </div>
        </div>
        <div class="row align-items-start mb-2">
          <div class="col-md-7">
            <p class="text-muted tx-13 mb-3 mb-md-0">Revenue is the income that a business has from its normal business activities, usually from the sale of goods and services to customers.</p>
          </div>
          <div class="col-md-5 d-flex justify-content-md-end">
            <div class="btn-group mb-3 mb-md-0" role="group" aria-label="Basic example">
              <button type="button" class="btn btn-outline-primary">Today</button>
              <button type="button" class="btn btn-outline-primary d-none d-md-block">Week</button>
              <button type="button" class="btn btn-primary">Month</button>
              <button type="button" class="btn btn-outline-primary">Year</button>
            </div>
          </div>
        </div>
        <div class="flot-wrapper">
          <div id="flotChart1" class="flot-chart"></div>
        </div>
      </div>
    </div>
  </div>
</div> <!-- row -->

<div class="row">
  <div class="col-lg-6 col-xl-5 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title mb-0"  id="members">Members response for the RFPs</h6>
          <div class="dropdown mb-2">
            <button class="btn p-0" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
            </div>
          </div>
        </div>
        <p class="text-muted mb-4">Number of members submissions for each RFP </p>
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
/*
            $sql2="SELECT ID_rfp,COUNT(ID_rfp) as count
                    FROM projets
                    where projets.reponse='Refusé'
                    GROUP BY ID_rfp";
            $result2 = mysqli_query($mysqli, $sql2);
            while ($value = mysqli_fetch_array($result2)) {
              $refused =$refused.$value['count'].',';
            }
            $sql3="SELECT ID_rfp,COUNT(ID_rfp) as count
                    FROM projets
                    where projets.reponse='Accepté avec reserve'
                    GROUP BY ID_rfp";
            $result3 = mysqli_query($mysqli, $sql3);
            while ($value = mysqli_fetch_array($result3)) {
              $reserve =$reserve.$value['count'].',';
            }*/

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
  <div class="col-lg-6 col-xl-7 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title mb-0">Clients and Partners</h6>
        </div>

           <canvas id="clients" width="533" height="266"></canvas>
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
        <div class="form-group" align="right">
            <div class="input-group date" id="datetimepicker10" data-target-input="nearest">
                <input name="year" type="text" class="form-control datetimepicker-input" data-target="#datetimepicker10" placeholder="Enter a year"/>
                <div class="input-group-append" data-target="#datetimepicker10" data-toggle="datetimepicker">
                    <div class="form-control input-group-text"> <i data-feather="calendar"></i></div>
                </div>

            </div>
        </div>
        </div>
      </form>

           <div class=" card-title text-center bg-dark">Members particpations rate per year </div>
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
       $sql="SELECT users.id ,COUNT(projets.chefDeGroupe) nbrProjet
                 FROM projets,users
                 WHERE projets.chefDeGroupe=users.id
                 AND YEAR(projets.created_at) = $year
                 group BY projets.chefDeGroupe";
        $result = mysqli_query($mysqli, $sql);
         while ($value = mysqli_fetch_array($result)) {
                $n =$n.$value['nbrProjet'].',';
                }
            $n = trim($n,",");
            /////////////////Nombre de projets en cours pour chaque chef de groupe
        $sql1 =  "SELECT users.id , COUNT(delivrables.id_respo) nbrProjet
                 FROM delivrables , users
                 WHERE delivrables.id_respo=users.id
                 AND YEAR(delivrables.created_at) = $year
                 group BY delivrables.id_respo";
        $result1 = mysqli_query($mysqli, $sql1);
        while ($value = mysqli_fetch_array($result1)) {
                $l =$l.$value['nbrProjet'].',';
                }
            $l = trim($l,",");
            ///////////////Nombre de participations dans le projets pour chaque chercheurs
        $users ="SELECT users.id ,users.name,users.prenom
                 FROM users
                 order by users.id";

        $result3 = mysqli_query($mysqli, $users);
           while ($value = mysqli_fetch_array($result3)) {
             $m =$m."'".$value['id']."_".$value['name']." ".$value['prenom']."',";
            }
            $m = trim($m,",");
        /////////////Tous les chercheurs du labo

?>

<script type="text/javascript">
var ctx = document.getElementById("Dailysales").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php echo $m; ?>],
        datasets:
        [
        {
            label: 'Active projects',
            data: [<?php echo $n; ?>],
            backgroundColor: 'rgba(153, 102, 255, 1)',
            borderColor: 'rgba(255,99,132,1)',
            borderWidth: 2
        },
        {
            label: 'Working in a groupe',
            data: [<?php echo $l; ?>],
            backgroundColor: 'rgba(75, 192, 192, 1)',
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 2
        },

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
                    labelString: 'Members'
                  }
                }],
                yAxes: [{

				  ticks: { beginAtZero: true,stepSize:1	 },
                  display: true,
                  scaleLabel: {
                    display: true,
                    labelString: 'Participation'
                  }
                }]
              }
            }
});

</script>



 <!--<div class="row">
  <div class="col-lg-5 col-xl-4 grid-margin grid-margin-xl-0 stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title mb-0">Inbox</h6>
          <div class="dropdown mb-2">
            <button class="btn p-0" type="button" id="dropdownMenuButton6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton6">
              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="printer" class="icon-sm mr-2"></i> <span class="">Print</span></a>
              <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
            </div>
          </div>
        </div>
       <div class="d-flex flex-column">
          <a href="#" class="d-flex align-items-center border-bottom pb-3">
            <div class="mr-3">
              <img src="{{ url('https://via.placeholder.com/35x35') }}" class="rounded-circle wd-35" alt="user">
            </div>
            <div class="w-100">
              <div class="d-flex justify-content-between">
                <h6 class="text-body mb-2">Leonardo Payne</h6>
                <p class="text-muted tx-12">12.30 PM</p>
              </div>
              <p class="text-muted tx-13">Hey! there I'm available...</p>
            </div>
          </a>
          <a href="#" class="d-flex align-items-center border-bottom py-3">
            <div class="mr-3">
              <img src="{{ url('https://via.placeholder.com/35x35') }}" class="rounded-circle wd-35" alt="user">
            </div>
            <div class="w-100">
              <div class="d-flex justify-content-between">
                <h6 class="text-body mb-2">Carl Henson</h6>
                <p class="text-muted tx-12">02.14 AM</p>
              </div>
              <p class="text-muted tx-13">I've finished it! See you so..</p>
            </div>
          </a>
          <a href="#" class="d-flex align-items-center border-bottom py-3">
            <div class="mr-3">
              <img src="{{ url('https://via.placeholder.com/35x35') }}" class="rounded-circle wd-35" alt="user">
            </div>
            <div class="w-100">
              <div class="d-flex justify-content-between">
                <h6 class="text-body mb-2">Jensen Combs</h6>
                <p class="text-muted tx-12">08.22 PM</p>
              </div>
              <p class="text-muted tx-13">This template is awesome!</p>
            </div>
          </a>
          <a href="#" class="d-flex align-items-center border-bottom py-3">
            <div class="mr-3">
              <img src="{{ url('https://via.placeholder.com/35x35') }}" class="rounded-circle wd-35" alt="user">
            </div>
            <div class="w-100">
              <div class="d-flex justify-content-between">
                <h6 class="text-body mb-2">Amiah Burton</h6>
                <p class="text-muted tx-12">05.49 AM</p>
              </div>
              <p class="text-muted tx-13">Nice to meet you</p>
            </div>
          </a>
          <a href="#" class="d-flex align-items-center border-bottom py-3">
            <div class="mr-3">
              <img src="{{ url('https://via.placeholder.com/35x35') }}" class="rounded-circle wd-35" alt="user">
            </div>
            <div class="w-100">
              <div class="d-flex justify-content-between">
                <h6 class="text-body mb-2">Yaretzi Mayo</h6>
                <p class="text-muted tx-12">01.19 AM</p>
              </div>
              <p class="text-muted tx-13">Hey! there I'm available...</p>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>-->


</div> <!-- row -->
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
@endpush
