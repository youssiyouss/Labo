@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/chercheurs">chercheurs</a></li>
    <li class="breadcrumb-item active" aria-current="page">Modifier</li>
  </ol>
</nav>




<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Modifier profil</h6>
        <form class="form-group" files=true action="{{ url('chercheurs/'.$chrch->id)}}" method="post" enctype="multipart/form-data">
          <input type="hidden" name="_method" value="PUT">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="card text-white">
              <input type="file" accept=".png,.jpg,.jpeg,.svg,.bmp" data-default-file="{{ asset('storage/'.$chrch->photo) }}"
               name="photo" class="form-group  @error('photo') is-invalid @enderror" id="myDropify" value="{{$chrch->photo}}" class="border" unique/>

              @error('photo')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
          </div>

          <div class="form-group">
            <label for="exampleInputText1">Nom</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputText1" placeholder="Veuillez saisir votre nom"
             name="nom" value="{{ $chrch->name }}"  required autocomplete="name" autofocus>
             @error('name')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
          </div>
          <div class="form-group">
            <label for="exampleInputText1">Prénom</label>
            <input type="text" class="form-control @error('prenom') is-invalid @enderror"  id="exampleInputText1" placeholder="Veuillez saisir votre prénom"
            name="prenom" value="{{ $chrch->prenom }}" required autocomplete="prenom">
            @error('prenom')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

          <div class="form-group">
            <label for="exampleInputEmail3">Email </label>
            <input type="email" class="form-control  @error('email') is-invalid @enderror" id="exampleInputEmail3" placeholder="Enter Email"
             name="email" value="{{  $chrch->email}}" required unique autocomplete="email">
             @error('email')
             <div class="invalid-feedback">
               {{ $message }}
             </div>
             @enderror
          </div>
          <div class="form-group">
            <label for="exampleInputNumber1">Numero de téléphne</label>
            <input type="tel" class="form-control @error('tel') is-invalid @enderror" id="exampleInputNumber1" placeholder="06********"
             name="tel" value="{{ $chrch->tel }}" required autocomplete="tel">
             @error('tel')
             <div class="invalid-feedback">
               {{ $message }}
             </div>
             @enderror
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect1">Grade</label>
            <select class="form-control  @error('grade') is-invalid @enderror"  name="grade" value="{{ $chrch->grade}}" required id="exampleFormControlSelect1">
              <option selected disabled>{{$chrch->grade}}</option>
              <option value="Directeur">Directeur</option>
              <option value="Chercheur">Chercheur</option>
              <option value="Enseignant-Chercheur">Enseignant-Chercheur</option>
              <option value="Chercheur post-doctorants">Chercheur post-doctorants</option>
              <option value="Doctorant">Doctorant</option>
              <option value="Stagiaire">Stagiaire</option>
              <option value="Membre externe">Membre externe</option>
            </select>
            @error('grade')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">À propos</label>
            <textarea class="form-control  @error('about') is-invalid @enderror" id="exampleFormControlTextarea1"  rows="5" name="about" placeholder="Parlez-nous brièvement de vous">{{$chrch->about}}</textarea>
            @error('about')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <button class="btn btn-primary" type="submit">{{ __('Modifier') }}<i data-feather="edit"></i></button>
          <a href="{{ url('chercheurs') }}" class="btn btn-danger"> Annuler <i data-feather="x-square"></i></a>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection
@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/dropzone/dropzone.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/dropzone.js') }}"></script>
  <script src="{{ asset('assets/js/dropify.js') }}"></script>

@endpush
