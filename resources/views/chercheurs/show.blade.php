@extends('layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/chercheurs">chercheurs</a></li>
    <li class="breadcrumb-item active" aria-current="page">afficher mon profil</li>
</ol>
</nav>
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-12 col-xl-10 mx-auto">
      <div class="card">
        <div class="row">
          <div class="col-md-4 pr-md-0">
            <div class="auth-left-wrapper" >
<img src=" {{asset('storage/'.$chrch->photo)}}" height="200" width="260" alt="">
            </div>
          </div>

          <div class="col-md-8 pl-md-0">
            <div class="row justify-content-center">
              <img src="/assets/images/logo_dark.png" height="100" width="110" alt="">
            </div>
            <div class="auth-form-wrapper px-4 py-5">

              <h5 class="font-weight-normal mb-4 noble-ui-logo logo-light  bg-info d-block mb-2">{{ $chrch->name}} {{ $chrch->prenom}}</h5>
               <p class="text-muted"> {{$chrch->grade}}</p>
               <ul class="list-group list-group-flush">
                     <li class="list-group-item">id : <span class="pull-right">{{ $chrch->id}}</span></li>
                     <li class="list-group-item">Nom : <span class="pull-right">{{ $chrch->name}}</span></li>
                     <li class="list-group-item">Prénom : <span class="pull-right">{{ $chrch->prenom}}</span></li>
                     <li class="list-group-item">Numero de Téléphone : <span class="pull-right"> {{ $chrch->tel}}</span></li>
                     <li class="list-group-item">Adresse mail : <span class="pull-right">{{ $chrch->email}}</span></li>
                     <li class="list-group-item">Date d'inscription : <span class="pull-right">{{ $chrch->created_at}}</span></li>
                     <li class="list-group-item">About : <span class="pull-right">{{ $chrch->about}}</span></li>
               </ul>
               @if(Auth::user()->grade == 'Directeur')
                <div class="card-footer"> <a href="{{ url('/chercheurs') }}" class="btn btn-primary"><i class="fa fa-chevron-circle-left" aria-hidden="true"> Ok</i></a></li></div>
               @else
              <div class="card-footer"> <a href="{{ url('/home') }}" class="btn btn-primary"><i class="fa fa-chevron-circle-left" aria-hidden="true"> Ok</i></a></li></div>
               @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
