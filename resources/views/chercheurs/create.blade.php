@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/chercheurs">chercheurs</a></li>
    <li class="breadcrumb-item active" aria-current="page">ajouter</li>
  </ol>
</nav>


<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Nouveau Membre</h6>
        <form method="POST" action="{{ url('chercheurs')}}" enctype="multipart/form-data">
          {{ csrf_field()}}

          <div class="form-group">
            <label for="exampleInputText1">Nom</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputText1" placeholder="Veuillez saisir votre nom"
             name="nom" value="{{ old('name') }}" required autocomplete="name" autofocus>
             @error('name')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
          </div>
          <div class="form-group">
            <label for="exampleInputText1">Prénom</label>
            <input type="text" class="form-control @error('prenom') is-invalid @enderror"  id="exampleInputText1" placeholder="Veuillez saisir votre prénom"
            name="prenom" value="{{ old('prenom') }}" required autocomplete="prenom">
            @error('prenom')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

          <div class="form-group">
            <label for="exampleInputEmail3">Email </label>
            <input type="email" class="form-control  @error('email') is-invalid @enderror" id="exampleInputEmail3" value="amiahburton@gmail.com" placeholder="Enter Email"
             name="email" value="{{ old('email') }}" required unique autocomplete="email">
             @error('email')
             <div class="invalid-feedback">
               {{ $message }}
             </div>
             @enderror
          </div>
          <div class="form-group">
            <label for="exampleInputNumber1">Numero de téléphne</label>
            <input type="tel" class="form-control @error('tel') is-invalid @enderror" id="exampleInputNumber1" placeholder="06********"
             name="tel" value="{{ old('tel') }}" required autocomplete="tel">
             @error('tel')
             <div class="invalid-feedback">
               {{ $message }}
             </div>
             @enderror
          </div>
          <div class="form-group">
            <label for="exampleInputPassword3">Mot de passe</label>
            <input type="password" class="form-control  @error('password') is-invalid @enderror" id="password"
             name="password" required placeholder="********">
            @error('password')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="exampleInputPassword3">Confirmer mot de passe</label>
            <input type="password" class="form-control  @error('password') is-invalid @enderror"  placeholder="********"
            id="confirm_password" name="confirm_password" required>
             <div class="col-md-12">
               <input type="checkbox" onchange="ShowPsw(this);"  style="cursor:pointer;">
               <span id="checkbox">Afficher le mot de passe</span>
             </div>
            @error('confirm_password')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect1">Grade</label>
            <select class="form-control  @error('grade') is-invalid @enderror"  name="grade" required id="exampleFormControlSelect1">
              <option selected disabled value="{{old('grade')}}">{{old('grade')}}</option>
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
            <textarea class="form-control  @error('about') is-invalid @enderror" id="exampleFormControlTextarea1"  rows="5" name="about" placeholder="Parlez-nous brièvement de vous">{{old('about')}}</textarea>
            @error('about')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
            <label>Photo de profile</label>
           <div class="input-group col-xs-12">
               <input type="file" accept=".png,.jpg,.jpeg,.svg,.bmp" data-default-file="{{old('photo')}}"
                name="photo" class="form-group  @error('photo') is-invalid @enderror" id="myDropify" value="{{old('photo')}}" class="border" unique/>
            </div>
            @error('photo')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <button class="btn btn-primary" type="submit">{{ __('Enregistrer') }}<i data-feather="save"></i></button>
          <a href="{{ url('chercheurs') }}" class="btn btn-danger"> Annuler <i data-feather="x-square"></i></a>
        </form>

        <script type="text/javascript">
        function ShowPsw(x){
          var y=x.checked;
          if(y){
            document.getElementById("password").type="text";
            document.getElementById("confirm_password").type="text";
            document.getElementById("checkbox").textContent="Masquer le mot de passe";
           }
           else{
             document.getElementById("password").type="password";
             document.getElementById("confirm_password").type="password";
             document.getElementById("checkbox").textContent="Afficher le mot de passe";
           }
         }
        </script>
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
