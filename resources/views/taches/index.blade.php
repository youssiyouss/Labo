@extends('layout.master')
@push('plugin-styles')
<link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush
@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/rfps">Taches</a></li>
    <li class="breadcrumb-item active" aria-current="page">liste</li>
  </ol>
</nav>
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
    <ul class="nav nav-tabs">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle active" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Taches</a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="#">Mes taches</a>
              <a class="dropdown-item active" href="{{ url('taches')}}">Tous les taches</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Separated link</a>
            </div>
          </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Délivrables</a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="#">Mes délivrables</a>
             <a class="dropdown-item" href="{{ url('delivrables')}}">Tous les délirvrables</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Separated link</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Génerer le rapport final</a>
          </li>
      </ul>
</div>
<div class="col stretch-card">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-baseline mb-2">
        <h6 class="card-title mb-0 text-warning">Tous les taches</h6>
        <div align="right">
            <a href="{{ url('taches/create')}}" type="button" class="btn btn-outline-success"  data-toggle="tooltip" data-placement="bottom" title="Ajouter une nouvelle tache"><i data-feather="plus-circle"></i></a>
        </div>

      </div>
      <div class="card-header">

      </div>
      <div class="card-body table-responsive">
        <table class="table table-hover mb-0">
          <thead>
            <tr>
              <th class="pt-0"></th>
              <th class="pt-0">Responsable</th>
              <th class="pt-0">Nom Tache</th>
              <th class="pt-0">priorite</th>
              <th class="pt-0">date Debut</th>
              <th class="pt-0">Date Fin</th>
              <th class="pt-0">details</th>


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
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                        </div>
                      </div>

              </td>
              <td class="py-1">
                <img type="button" data-toggle='popover' title='{{$t->name}} {{ $t->prenom}}' src="{{ asset('storage/'.$t->photo) }}" alt="image">
                <br> <span class="text-muted">{{$t->name}} {{ $t->prenom}}</span>
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
              <td>{{$t->dateFin}}</td>
              <td> <i>"{{Str::limit($t->description, 30,'..."')}}   </i> <a href="#" data-toggle="modal" data-target="#element-<?php echo $t->id;?>"> (Voir plus)     </a></td>

              <div class="modal fade" id="element-<?php echo $t->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
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
                       <a href="taches/downloadTache/{{$t->id}}" style=cursor:pointer; class='btn btn-outline-light' type='button' data-toggle='tooltip' data-placement='bottom' title='Télécharger ce fichier pour plus de detail!' >Télécharger</a>
                  </div>
                  @endif
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
