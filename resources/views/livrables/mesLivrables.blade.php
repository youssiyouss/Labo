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


<div class="card bg-dark">
    <div class="card-header">
        <ul class="nav nav-tabs">
        <li class="nav-item">
          <a href="{{ url('taches/MesTaches/'.$Projectid)}}" class="nav-link" aria-selected="true">Mes taches</a>
        </li>
        @if (Auth::user()->can('access',[App\Tache::class,$Projectid]))
        <li class="nav-item">
          <a href="{{ url('taches/'.$Projectid)}}" class="nav-link" aria-selected="false">Tous les taches</a>
        </li>
        @endcan
        <li class="nav-item">
          <a href="{{ url('livrables/MesLivrables/'.$Projectid)}}" class="nav-link active" aria-selected="false">Mes livrables</a>
        </li>
        @if (Auth::user()->can('access',[App\Tache::class,$Projectid]))
        <li class="nav-item">
          <a href="{{ url('livrables/'.$Projectid)}}" class="nav-link" aria-selected="false">Tous les livrables</a>
        </li>
        @endif
        <li class="nav-item">
            <a href="#" class="nav-link" aria-selected="false">À propos du projet</a>
        </li>
        @if (Auth::user()->can('access',[App\Tache::class,$Projectid]))
        <li class="nav-item">
            <a href="#" class="nav-link" aria-selected="false">Génerer le rapport final</a>
        </li>
        @endif
      </ul>
    </div>
    <div class="card-title" align="center">
        <a class="navbar-brand" href="/home"  data-toggle='tooltip' data-placement='bottom' title="home" style="align-content: right;">
                <img src="\assets\images\logo_dark.png" width="30" height="30" alt="">
        </a>{{$Projectname}}
    </div>
 <h4 class="card-title text-warning"> Mes livrable du projet</h4>

    @foreach($livrable as $l)
    <div class="row">
    <div class="col-12">
      <div class="card ">
          <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title bg-primary mb-0">{{$l->id_tache}}- {{$l->titreTache}}:</h6>
          <div class="dropdown mb-2">
            <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
             @if($l->contenu != Null)  <a class="dropdown-item d-flex align-items-center" href="{{ url('livrables/voir/'.$l->id_tache)}}"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>@endif
              <a class="dropdown-item d-flex align-items-center" href="{{url('livrables/'.$l->id_tache.'/edit/'.$Projectid)}}" ><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
            </div>
          </div>
        </div>
        <div class="card-body">
            <p class="card-text"><span class="text-muted">Type :</span>  {{$l->type}}</p>
            <p class="card-text"><span class="text-muted">Commmentaire sur l'avancement du travail:</span>  {{$l->commentaire}}</p>
            <p class="card-text"><span class="text-muted">Dernier modification :</span>  {{$l->updated_at}}</p>

        <footer class="text-muted" align="right"><h4>
            @if($l->avancement==='Terminée')
              <span class="badge badge-success">{{$l->avancement}} <i data-feather="check"></i></span>
            @elseif($l->avancement==='Bientôt disponible')
              <span class="badge badge-info-muted">{{$l->avancement}}<i data-feather="trending-up"></i></span>
            @elseif($l->avancement==="J'y travaille")
              <span class="badge badge-warning">{{$l->avancement}} <i data-feather="loader"></i></span>
            @elseif($l->avancement==="Non entamé")
              <span class="badge badge-danger">{{$l->avancement}} <i data-feather="alert-circle"></i></span>
            @endif</h4>

        </footer>
        </div>
      </div>
    </div>
    </div>
    <br>
      @endforeach

  </div>




@endsection
