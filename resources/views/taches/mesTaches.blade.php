@extends('layout.master')

@section('content')
  @if(session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{session()->get('success')}} </strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
 @elseif(session()->has('error'))
 <div class="alert alert-danger alert-dismissible fade show" role="alert">
   <strong>{{session()->get('error')}} </strong>
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
     <span aria-hidden="true">&times;</span>
   </button>
  </div>
 @endif

<div class="col stretch-card">
  <div class="card">
  <div class="card-header"><ul class="nav nav-tabs">
        <li class="nav-item">
          <a href="{{ url('taches/MesTaches/'.$Projectid)}}" class="nav-link active" aria-selected="true">Mes taches</a>
        </li>
        @if (Auth::user()->can('access',[App\Tache::class,$Projectid]))
        <li class="nav-item">
          <a href="{{ url('taches/'.$Projectid)}}" class="nav-link" aria-selected="false">Tous les taches</a>
        </li>
        @endcan
        <li class="nav-item">
          <a href="{{ url('livrables/MesLivrables/'.$Projectid)}}" class="nav-link" aria-selected="false">Mes livrables</a>
        </li>
        @if (Auth::user()->can('access',[App\Tache::class,$Projectid]))
        <li class="nav-item">
          <a href="{{ url('livrables/'.$Projectid)}}" class="nav-link" aria-selected="false">Tous les livrables</a>
        </li>
        @endif
        <li class="nav-item">
            <a href="{{ url('projets/about/'.$Projectid)}}" class="nav-link" aria-selected="false">À propos du projet</a>
        </li>

      </ul>
    </div>
  <div class="card-title" align="center">
            <a class="navbar-brand" href="/home"  data-toggle='tooltip' data-placement='bottom' title="home" style="align-content: right;">
                <img src="\assets\images\logo_dark.png" width="30" height="30" alt="">
            </a>
        {{$Projectname}}
    </div>
    <div class="card-body">
        <div class="card-title text-warning"> Mes taches pour le projet
        </div>
      <div class="card-body table-responsive">
        <table class="table table-hover mb-0">
          <thead>
            <tr>
              <th class="pt-0"></th>
              <th class="pt-0">Nom Tache</th>
              <th class="pt-0">priorite</th>
              <th class="pt-0">date Debut</th>
              <th class="pt-0">Date Fin</th>
              <th class="pt-0">Progrès</th>


            </tr>
          </thead>
          <tbody>
             @foreach($taches as $t)
            <tr>
                <td>

                    <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                          <a class="dropdown-item d-flex align-items-center" data-toggle="modal" data-target="#element-<?php echo $t->id;?>"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                        <!--  <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                        -->
                        </div>
                    </div>

              </td>

              <td>{{$t->titreTache}}</td>
              <td>
                  @if($t->priorite == 'très élevé')
                  <span class="badge badge-danger">Tres Elevé</span>
                  @elseif($t->priorite =='élevé' )
                  <span class="badge badge-warning">Elevé</span>
                  @elseif($t->priorite =='moyenne' )
                  <span class="badge badge-success">Moyenne</span>
                  @elseif($t->priorite == 'bas')
                  <span class="badge badge-primary">Bas</span>
                  @endif
                </td>
              <td>{{$t->dateDebut}}</td>
              <td class="text-danger">{{$t->dateFin}}</td>
              <td>
                @if($t->avancement==='Terminée')
              <span class="badge badge-success">{{$t->avancement}} <i data-feather="check"></i></span></h5>
            @elseif($t->avancement==='Bientôt disponible')
              <span class="badge badge-info-muted">{{$t->avancement}}<i data-feather="trending-up"></i></span></h5>
            @elseif($t->avancement==="J'y travaille")
              <span class="badge badge-warning">{{$t->avancement}} <i data-feather="loader"></i></span></h5>
            @elseif($t->avancement==="Non entamé")
              <span class="badge badge-danger">{{$t->avancement}} <i data-feather="alert-circle"></i></span></h5>
            @endif
              </td> <!-- <i>"Str::limit($t->description, 30,'..."')}}   </i> -->

              <div class="modal fade bd-example-modal-lg" id="element-<?php echo $t->id;?>" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Description de la tache</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>{{$t->description}} </p>
                  </div>
                  @if( $t->fichierDetail )
                  <div align="center">
                      <a href="{{ url('taches/downloadTache/'.$t->id)}}" style=cursor:pointer; class='btn btn-outline-light' type='button' data-toggle='tooltip' data-placement='bottom' title='Télécharger ce fichier pour plus de detail!' >Télécharger</a>
                      <a href="{{ url('taches/voir/'.$t->id)}}" target=_blank style=cursor:pointer; class='btn btn-outline-info' type='button' data-toggle='tooltip' data-placement='bottom' title='Voir le fichier attaché!' >Voir</a>
                  </div>
                  @endif
                    <div class="modal-footer">
                        <a href="{{ url('livrables/'.$t->id.'/edit/'.$Projectid)}}" class="btn btn-primary" type='button'  data-toggle='tooltip' data-placement='bottom' title="soumettre pour cette tâche">Délivrer</a>
                        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
                    </div>
                  </div>
                </div>
              </div>

            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

@endsection
@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
 @endpush

@push('custom-scripts')
 <script src="{{ asset('assets/js/dropify.js') }}"></script>
 <script src="{{ asset('assets/js/datepicker.js') }}"></script>
 <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endpush
