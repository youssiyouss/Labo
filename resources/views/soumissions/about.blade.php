@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/owl-carousel/assets/owl.carousel.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/owl-carousel/assets/owl.theme.default.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/animate-css/animate.min.css') }}" rel="stylesheet" />
@endpush

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
    <div class="card-header">
        <ul class="nav nav-tabs">
        <li class="nav-item">
          <a href="{{ url('taches/MesTaches/'.$Projectid->id)}}" class="nav-link" aria-selected="true">Mes taches</a>
        </li>
        @if (Auth::user()->can('access',[App\Tache::class,$Projectid->id]))
        <li class="nav-item">
          <a href="{{ url('taches/'.$Projectid->id)}}" class="nav-link " aria-selected="false">Tous les taches</a>
        </li>
        @endif
        <li class="nav-item">
          <a href="{{ url('livrables/MesLivrables/'.$Projectid->id)}}" class="nav-link" aria-selected="false">Mes livrables</a>
        </li>
        @if (Auth::user()->can('access',[App\Tache::class,$Projectid->id]))
        <li class="nav-item">
          <a href="{{ url('livrables/'.$Projectid->id)}}" class="nav-link" aria-selected="false">Tous les livrables</a>
        </li>
        @endif
        <li class="nav-item">
        <a href="{{ url('projets/about/'.$Projectid->id)}}" class="nav-link active" aria-selected="false">À propos du projet</a>
        </li>
        @if (Auth::user()->can('access',[App\Tache::class,$Projectid->id]))
        <li class="nav-item">
            <a href="#" class="nav-link" aria-selected="false">Génerer le rapport final</a>
        </li>
        @endif
      </ul>
    </div>
    <div class="card-title" align="center">
        <a class="navbar-brand" href="/home"  data-toggle='tooltip' data-placement='bottom' title="home" style="align-content: right;">
                <img src="\assets\images\logo_dark.png" width="30" height="30" alt="">
        </a>
        {{$Projectid->nom}}
    </div>
    <div class="card-body">

        <div class="col-md-12">
            <div class="card">
            <div class="card-body">
                <h6 class="card-title text-success">Date de fin du projet:</h6>
                <div class="media d-block d-sm-flex">
                    <div class="media-body">
                        <p class="bg-info"><b>{{$Projectid->cloture}}</b></p>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
            <div class="card-body">
                <h6 class="card-title e text-success">Context:</h6>
                <div class="media d-block d-sm-flex">
                    <div class="media-body">
                        {{$Projectid->descriptionProjet}}
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
            <div class="card-body">
                <h6 class="card-title text-success">Chef de projet:</h6>
                <div class="media d-block d-sm-flex">
                    <img src="{{ asset('storage/'.$chefDeGroupe->photo) }}" class="align-self-center wd-100p wd-sm-150 mb-3 mb-sm-0 mr-3" alt="...">
                    <div class="media-body">
                        <h3 class="block-38-heading h4">{{ $chefDeGroupe->name}} {{ $chefDeGroupe->prenom}}</h3>
                        <p class="text-secondary">{{ $chefDeGroupe->about}}</p>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
            <div class="card-body">
                <h6 class="card-title text-success">Membres de l'équipe:</h6>
                <div class="owl-carousel owl-theme owl-basic" style="items:2">
                @foreach($membres as $ch)
                        @if($ch->name != $chefDeGroupe->name &&  $ch->prenom != $chefDeGroupe->prenom)
                        <div class="item"  data-merge='{{$ch->photo}}'>
                        <img src="{{ asset('storage/'.$ch->photo) }}" alt="item-image">
                        <h3 class="block-38-heading h4">{{ $ch->name}} {{ $ch->prenom}}</h3>
                        </div>
                        @endif
                @endforeach
                </div>
            </div>
            </div>
        </div>
</div>

@endsection
@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
  <script src="{{ asset('assets/plugins/owl-carousel/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
 @endpush

@push('custom-scripts')
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
   <script src="{{ asset('assets/js/carousel.js') }}"></script>

@endpush
