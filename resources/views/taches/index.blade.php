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
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a href="{{ url('taches/MesTaches/'.$Projectid)}}" class="nav-link" aria-selected="true">Mes taches</a>
        </li>

        <li class="nav-item">
            <a href="{{ url('taches/'.$Projectid)}}" class="nav-link active" aria-selected="false">Tous les taches</a>
        </li>

        <li class="nav-item">
           <a href="{{ url('livrables')}}" class="nav-link" aria-selected="false">Mes livrables</a>
        </li>
        <li class="nav-item">
            <a href="#disabled" class="nav-link" aria-selected="false">Tous les livrables</a>
        </li>

        <li class="nav-item">
              <a href="#" class="nav-link" aria-selected="false">About</a>
        </li>
        <li class="nav-item">
              <a href="#" class="nav-link" aria-selected="false">Génerer le rapport final</a>
        </li>
    </ul>

</div>
<div class="col stretch-card">
  <div class="card">
    <div class="card-header">
        <span align="right">
            <a class="navbar-brand" href="/home" style="align-content: right;">
                <img src="\assets\images\logo_dark.png" width="30" height="30" alt="">
            </a>
            Tous les taches du projet
        </span>
    </div>
    <div class="card-body">
            <h4 class="card-title text-warning" align="center">
           <div align="right">
                <a href="{{ url('taches/create/'.$Projectid)}}" type="button" class="btn btn-outline-success"  data-toggle="tooltip" data-placement="bottom" title="Ajouter une nouvelle tache"><i data-feather="plus-circle"></i></a>
            </div>
            {{$Projectname}}
          </h4>
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
                        <form  action="{{ url('taches/'.$t->id)}}" method="post" onsubmit="return confirm('Etes vous sure de vouloir supprimer cette tache définitivement?')">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                          <a class="dropdown-item d-flex align-items-center" href="#" data-toggle="modal" data-target="#element-<?php echo $t->id;?>"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="{{ url('taches/'.$t->id.'/edit')}}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                          <button class="dropdown-item d-flex align-items-center" type="submit"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></button>
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
              <td></td> <i><!--"{{Str::limit($t->description, 30,'..."')}}   </i>-->

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
                  </div>
                  @endif
                    <div class="modal-footer">
                      <a href="{{ url('livrables/create/'.$Projectid)}}" class="btn btn-primary" type='button'  data-toggle='tooltip' data-placement='bottom' title="soumettre pour cette tâche">Délivrer</a>
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
