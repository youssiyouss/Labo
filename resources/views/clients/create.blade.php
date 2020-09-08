@extends('layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/clients">Maitres ouvrages</a></li>
    <li class="breadcrumb-item active" aria-current="page">ajouter</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Nouveau maitre d'ouvrage</h6>
        <form method="POST" action="{{ url('clients')}}" enctype="multipart/form-data">
          {{ csrf_field()}}

          <div class="form-group">
            <label>Nom du maitre d'ouvrage*</label>
            <input type="text" class="form-control @error('ets') is-invalid @enderror" placeholder="Nom"
             name="ets" value="{{ old('ets') }}" required autocomplete="ets" autofocus>
             @error('ets')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
          </div>

          <div class="form-group">
            <label>Adresse email*</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email"
             name="email" value="{{ old('email') }}" required autocomplete="email">
             @error('email')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
          </div>
          <div class="form-group">
            <label>Numèro telephone</label>
            <input type="tel" class="form-control @error('tel') is-invalid @enderror" placeholder="(+231)-- -- -- --"
             name="tel" value="{{ old('tel') }}" autocomplete="tel">
             @error('tel')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
          </div>
          <div class="form-group">
            <label>Adresse</label>
            <input type="adresse" class="form-control @error('adresse') is-invalid @enderror" placeholder="adresse de l'etablissement"
             name="adresse" value="{{ old('adresse') }}" required autocomplete="adresse">
             @error('adresse')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
          </div>
          <div class="form-group">
            <label>Site web*</label>
            <input type="url" class="form-control @error('site') is-invalid @enderror" placeholder="https://"
             name="site" value="{{ old('site') }}" required autocomplete="site">
             @error('site')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
          </div>

          <button class="btn btn-primary" type="submit"> {{__('Enregistrer')}} <i data-feather="save"></i></button>
          <a href="{{ url('clients') }}" class="btn btn-danger"> Annuler <i data-feather="x-square"></i></a>
        </form>
      </div>
    </div>
  </div>

  @endsection
  @push('plugin-scripts')
    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/typeahead-js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
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
    @endpush
