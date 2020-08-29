@extends('layout.master')


@push('plugin-styles')
  <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush


@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/projets">Soumissions</a></li>
    <li class="breadcrumb-item active" aria-current="page">ajouter</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title text-warning">Soumission d'un nouveau projet</h6>
        <form method="POST" action="{{ url('projets')}}" enctype="multipart/form-data">
          {{ csrf_field()}}

          <div class="form-group">
            <label>Titre du projet*</label>
            <input type="text" class="form-control @error('nom') is-invalid @enderror" placeholder="Veuillez indiquer le nom de votre projet"
             name="nom" value="{{ old('nom') }}" required unique autocomplete="nom" autofocus>
             @error('maitreOuvrage')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
          </div>
          <div class="form-group">
            <label>RFP concerné*</label>
            <div class="input-group col-xs-12">
              <select class="form-control  @error('ID_rfp') is-invalid @enderror"  name="ID_rfp" required>
                <option value="">---------Selectionner l'RFP pour ce projet---------</option>
                @foreach($rfps as $l)
                <option value="{{$l->id}}"  {{(old('ID_rfp') ==$l->id) ? 'selected' : '' }}> {{ $l->titre }}      ({{ $l->type }}) </option>
                @endforeach
              </select>
              <span class="input-group-append">
                <a href="{{ url('rfps/create')}}" class="btn btn-outline-info" target="_blank" onsubmit="return confirm('Voulez-vous ajouter un nouveau RFP dans la plate-forme!')"> Ajouter</a>
              </span>
            </div>
          </div>
          <div class="form-group">
            <label>Endroit de soumission*</label>
            <div class="input-group">
              <input type="string" name="plateForme" class="form-control @error('plateForme') is-invalid @enderror" placeholder="Veuillez entrez le lien de la plateforme /l'adresse.. du maitre d'ouvrage" name="plateForme" value="{{old('plateForme')}}" autocomplete="plateForme" required/>
              @error('plateForme')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
          </div>
          <div class="form-group">
            <span class="input-group-addon"><i data-feather="file"></i></span>
            <label> Veuillez télécharger le fichier de votre présentation*</label>
            <div class="input-group">
              <input type="file" accept=".doc,.docx,application/msword,application/pdf,text/plain,application/vnd.ms-powerpoint,text/*,application/vnd.openxmlformats-officedocument.wordprocessingml.document" name="fichierDoffre" class="form-group  @error('fichierDoffre') is-invalid @enderror" id="myDropify"  value="{{old('fichierDoffre')}}" required class="border" unique/>
              @error('fichierDoffre')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
          </div>

                     <button class="btn btn-primary" type="submit"> {{__('Enregistrer')}} <i data-feather="save"></i></button>
                     <a href="{{ url('projets') }}" class="btn btn-danger"> Annuler <i data-feather="x-square"></i></a>

        </form>
      </div>
    </div>
  </div>
</div>

@endsection
@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/form-validation.js') }}"></script>
  <script src="{{ asset('assets/js/dropify.js') }}"></script>
  <script src="{{ asset('assets/js/timepicker.js') }}"></script>
@endpush
