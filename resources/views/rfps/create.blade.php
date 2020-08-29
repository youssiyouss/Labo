@extends('layout.master')


@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

@endpush


@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/rfps">Appels d'offres</a></li>
    <li class="breadcrumb-item active" aria-current="page">ajouter</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h6 class="card-title">Nouvel appel d'offres</h6>
        <form method="POST" action="{{ url('rfps')}}" enctype="multipart/form-data">
          {{ csrf_field()}}

          <div class="form-group">
            <label>Maitre d'ouvrage*</label>
            <div class="input-group col-xs-12">
              <select class="form-control  @error('maitreOuvrage') is-invalid @enderror"  name="maitreOuvrage" required>
                <option value="">---------Selectionner le maitre d'ouvrage---------</option>
                @foreach($mo as $l)
                <option value="{{$l->id}}"  {{(old('maitreOuvrage') ==$l->id) ? 'selected' : '' }}> {{ $l->ets }}</option>
                @endforeach

              </select>
              <span class="input-group-append">
                <a href="{{ url('clients/create')}}" class="btn btn-outline-info" target="_blank" onsubmit="return confirm('Voulez-vous ajouter un nouveau maitre d'ouvrage dans le laboratoire!')"> Ajouter </a>
              </span>
              @error('maitreOuvrage')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>

          </div>
          <div class="form-group">
            <label>Titre de projet*</label>
            <input type="text" maxlength="150" id="defaultconfig-2" class="form-control @error('titre') is-invalid @enderror" placeholder="le titre de l'RFP"
            name="titre" value="{{ old('titre') }}" required unique autocomplete="titre">
             @error('titre')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
          </div>
          <div class="form-group">
            <label>Nature de projet*</label>
            <select class="form-control  @error('type') is-invalid @enderror"  name="type" value="{{old('type')}}" required>
              <option value="">---------Selectionner le nature du projet---------</option>
              <option value="PRFU"  {{ old('type') == 'PRFU' ? 'selected' : '' }}>Projet de Recherches pour la Formation Universitaire</option>
              <option value="PNR" {{ old('type') == 'PNR' ? 'selected' : '' }}>Projet National de Recherche</option>
              <option value="Projets de coopérations"  {{ old('type') == 'Projets de coopérations' ? 'selected' : '' }}>Projets de coopérations</option>
            </select>
            @error('type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
            <label>À propos*</label>
            <textarea class="form-control  @error('resumer') is-invalid @enderror" id="maxlength-textarea"  maxlength="600" rows="7" name="resumer" placeholder="Description du projet .." unique required>{{old('resumer')}}</textarea>
            @error('resumer')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>


        <div class="form-group row">
              <div class="col">
                <label>Date l'apparition de l'appel*</label>
                <div class="input-group date datepicker" >
                <input type="date" name="dateAppel" value="{{old('dateAppel')}}" class="form-control @error('dateAppel') is-invalid @enderror" required>
                </div>
                @error('dateAppel')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                    </span>
                @enderror

              </div>

              <div class="col-md-6">
                <label>Heure de l'apparition de l'appel</label>
                <div class="input-group date timepicker" data-target-input="nearest">
                  <input type="time" name="heureAppel" value="{{old('heureAppel')}}" class="form-control @error('dateAppel') is-invalid @enderror">
                </div>
                @error('heureAppel')
                    <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
       </div>
       <div class="form-group row">
             <div class="col">
               <label>Date de l'écheance*</label>
               <div class="input-group date datepicker" >
               <input type="date" name="dateEcheance" value="{{old('dateEcheance')}}" class="form-control @error('dateEcheance') is-invalid @enderror" required>
               </div>
               @error('dateAppel')
                   <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                   </span>
               @enderror
             </div>

             <div class="col-md-6">
               <label>Heure de l'écheance*</label>
               <div class="input-group date timepicker" data-target-input="nearest">
                 <input type="time" name="heureEcheance" value="{{old('heureEcheance')}}" class="form-control @error('dateEcheance') is-invalid @enderror" required>
               </div>
               @error('heureAppel')
                   <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                   </span>
               @enderror
           </div>
      </div>
        <div class="form-group">
          <label>Source de l'appel d'offre*</label>
          <div class="input-group">
            <input type="string" name="sourceAppel" class="form-control @error('sourceAppel') is-invalid @enderror" placeholder="Veuillez entrez le lien/source.. vers l'appel d'offre" name="sourceAppel" value="{{old('sourceAppel')}}" autocomplete="sourceAppel" required/>
            <div class="input-group-append">
              <div class="input-group-text"><i data-feather="link"></i></div>
            </div>
            @error('sourceAppel')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
      </div>

      <div class="form-group">
        <label> Veuillez télécharger le fichier du rfp</label>
        <div class="input-group">
          <input type="file" accept=".jpg,.png,.jpeg,.doc,.docx,application/msword,application/pdf,text/plain,application/vnd.ms-powerpoint,text/*,application/vnd.openxmlformats-officedocument.wordprocessingml.document" name="fichier" class="form-group  @error('fichier') is-invalid @enderror" id="myDropify"  value="{{old('fichier')}}" class="border" unique/>
          @error('fichier')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
      </div>
        <button class="btn btn-primary" type="submit"> {{__('Enregistrer')}} <i data-feather="save"></i></button>
        <a href="{{ url('rfps') }}" class="btn btn-danger"> Annuler <i data-feather="x-square"></i></a>
    </form>
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
