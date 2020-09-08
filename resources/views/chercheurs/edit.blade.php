@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
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

        <form class="form-group"  files=true action="{{ url('chercheurs/'.$chrch->id)}}" method="post" enctype="multipart/form-data">
          <input type="hidden" name="_method" value="PUT">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="form-group">
              <input type="file" accept=".png,.jpg,.jpeg,.svg,.bmp" data-default-file="{{ asset('storage/'.$chrch->photo) }}"
               name="photo" class="form-group  @error('photo') is-invalid @enderror" id="myDropify" value="{{old('Photo', $chrch->photo)}}" class="border" unique/>

              @error('photo')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
              @enderror
          </div>

          <div class="form-group">
            <label for="exampleInputText1">Nom*</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Veuillez saisir votre nom"
             name="name" value="{{old('name', $chrch->name)}}"  required autocomplete="name" autofocus maxlength="100">
             @error('name')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
          </div>
          <div class="form-group">
            <label for="exampleInputText1">Prénom*</label>
            <input type="text" class="form-control @error('prenom') is-invalid @enderror"  id="exampleInputText1" placeholder="Veuillez saisir votre prénom"
            name="prenom" value="{{old('prenom', $chrch->prenom)}}" required autocomplete="prenom" maxlength="100" >
            @error('prenom')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

          <div class="form-group">
            <label for="exampleInputEmail3">Email* </label>
            <input type="email" class="form-control  @error('email') is-invalid @enderror" id="email" placeholder="Enter Email"
             name="email" value="{{old('email', $chrch->email)}}" required unique autocomplete="email" maxlength="150">
             @error('email')
             <div class="invalid-feedback">
               {{ $message }}
             </div>
             @enderror
          </div>
          <div class="form-group">
            <label for="password">Mot de passe*</label>
            <input type="password" class="form-control  @error('password') is-invalid @enderror" id="password"
             name="password"  required autocomplete="new-password" value="{{old('password', $chrch->password)}}" placeholder="--------">
            @error('password')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="password-confirm">Confirmer mot de passe*</label>
            <input type="password" class="form-control" value="{{old('password', $chrch->password)}}" placeholder="--------" id="password-confirm" name="password_confirmation" autocomplete="new-password" required confirmed>
             <div class="col-md-12">
               <input type="checkbox" onchange="ShowPsw(this);"  style="cursor:pointer;">
               <span id="checkbox">Afficher le mot de passe</span>
             </div>
          </div>
          <div class="form-group">
            <label for="exampleInputNumber1">Numero de téléphne*</label>
            <input type="tel" class="form-control @error('tel') is-invalid @enderror" id="exampleInputNumber1" placeholder="06********"
             name="tel" value="{{old('tel', $chrch->tel)}}" required autocomplete="tel">
             @error('tel')
             <div class="invalid-feedback">
               {{ $message }}
             </div>
             @enderror
          </div>
          <div class="form-group">
            <label for="exampleFormControlSelect1">Grade*</label>
            <select class="form-control  @error('grade') is-invalid @enderror"  name="grade" value="{{old('grade', $chrch->grade)}}" required>
              @if (old('grade')==$chrch->grade)
                  <option value="$chrch->grade" selected>{{$chrch->grade}}</option>
              @else
              <option value="Directeur">Directeur</option>
              <option value="Chercheur">Chercheur</option>
              <option value="Enseignant-Chercheur">Enseignant-Chercheur</option>
              <option value="Chercheur post-doctorants">Chercheur post-doctorants</option>
              <option value="Doctorant">Doctorant</option>
              <option value="Stagiaire">Stagiaire</option>
              <option value="Membre externe">Membre externe</option>
              <option value="Autre">Autre</option>

              @endif
            </select>

            @error('grade')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">À propos</label>
            <textarea class="form-control  @error('about') is-invalid @enderror"  rows="5" name="about" placeholder="Parlez-nous brièvement de vous" id="maxlength-textarea"  maxlength="600" rows="7">{{old('about', $chrch->about)}}</textarea>
            @error('about')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <button class="btn btn-primary" type="submit">{{ __('Modifier') }}<i data-feather="edit"></i></button>
          <a href="{{ url('chercheurs') }}" class="btn btn-danger"> Annuler <i data-feather="x-square"></i></a>
        </form>

                <script type="text/javascript">
                function ShowPsw(x){
                  var y=x.checked;
                  if(y){
                    document.getElementById("password").type="text";
                    document.getElementById("password-confirm").type="text";
                    document.getElementById("checkbox").textContent="Masquer le mot de passe";
                   }
                   else{
                     document.getElementById("password").type="password";
                     document.getElementById("password-confirm").type="password";
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
  <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/typeahead-js/typeahead.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropzone/dropzone.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/form-validation.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap-maxlength.js') }}"></script>
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script src="{{ asset('assets/js/typeahead.js') }}"></script>
  <script src="{{ asset('assets/js/tags-input.js') }}"></script>
  <script src="{{ asset('assets/js/dropzone.js') }}"></script>
  <script src="{{ asset('assets/js/dropify.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap-colorpicker.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
  <script src="{{ asset('assets/js/timepicker.js') }}"></script>
@endpush
