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
          <a href="{{ url('livrables/MesLivrables/'.$Projectid)}}" class="nav-link" aria-selected="false">Mes livrables</a>
        </li>
        @if (Auth::user()->can('access',[App\Tache::class,$Projectid]))
        <li class="nav-item">
          <a href="{{ url('livrables/'.$Projectid)}}" class="nav-link active" aria-selected="false">Tous les livrables</a>
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
        <a class="navbar-brand" data-toggle='tooltip' data-placement='bottom' title="home" href="/home">
                <img src="\assets\images\logo_dark.png" width="30" height="30" alt="">
        </a>
        {{$Projectname}}
    </div>
        <div class="card-title text-warning"> Tous les livrable du projet
            <p align="right">
                <a href="{{ url('livrables/create/'.$Projectid)}}" type="button" class="btn btn-outline-success"  data-toggle="tooltip" data-placement="bottom" title="Ajouter une nouvelle tache"><i data-feather="plus-circle"></i></a>
           </p>
        </div>
    @foreach($livrable as $l)
    <div class="row">
    <div class="col-12">
      <div class="card ">
          <div class="d-flex justify-content-between align-items-baseline mb-2">
          <h6 class="card-title text-primary">{{$l->id_tache}}- {{$l->titreTache}}
        @if ($l->avancement=='Terminée')
            <div class="spinner-grow text-success" role="status">
                    <span class="sr-only"></span>
            </div>
        @endif
        </h6>
          <div class="dropdown mb-2">
            <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
              @if($l->contenu != Null)
              <a class="dropdown-item d-flex align-items-center" href="{{ url('livrables/voir/'.$l->id_tache)}}"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
              <a class="dropdown-item d-flex align-items-center" href="{{ url('livrables/downloadLivrables/'.$l->id_tache)}}"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
            @endif
             <form  action="{{ url('livrables/'.$l->id_tache)}}" method="post" onsubmit="return confirm('Etes vous sure de vouloir supprimer ce livrable définitivement?')">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
              <button class="dropdown-item d-flex align-items-center" type="submit"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></button>
            </div>
          </div>
        </div>
        <div class="card-body">

            <p class="card-text"><span class="text-muted">Type :</span>  {{$l->type}}</p>
            <p class="card-text"><span class="text-muted">Commmentaire :</span>  {{$l->commentaire}}</p>
            <p class="card-text" data-toggle='tooltip' data-placement='bottom' title="{{$l->updated_at}}"><span class="text-muted">Dernier modification :</span>  {{(new Carbon\Carbon($l->updated_at))->locale('fr')->diffForHumans()}}</p>
            <p class="card-text"><span class="text-muted">Responsable(s)</span> :
                @foreach ($liv as $livrable)
                    @if ($livrable->id_tache == $l->id_tache )
                       @foreach ($respo as $user)
                            @if ($livrable->id_respo === $user->id)
                                <ul>{{$user->id}}-{{$user->name}}  {{$user->prenom}} </ul>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </p>
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
