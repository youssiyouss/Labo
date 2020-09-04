@extends('layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/rfps">Taches</a></li>
    <li class="breadcrumb-item active" aria-current="page">ajouter</li>
  </ol>

</nav>
  @if(session()->has('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{session()->get('success')}} </strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
 @elseif(session()->has('error'))
 <div class="alert alert-success alert-dismissible fade show" role="alert">
   <strong>{{session()->get('error')}} </strong>
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
     <span aria-hidden="true">&times;</span>
   </button>
  </div>
 @endif

 <div class="row">
   <div class="col-md-12 grid-margin stretch-card">
     <div class="card">
       <div class="card-body">
         <h6 class="card-title text-warning">Ajouter une tache</h6>
         <form method="POST" action="{{ url('taches/'.$ID_projet)}}" enctype="multipart/form-data">
           {{ csrf_field()}}

           <div class="form-group">
             <label>Nom de la tache*</label>
             <input type="text" class="form-control @error('nom') is-invalid @enderror" name="titreTache" value="{{ old('titreTache') }}" required unique autocomplete="titreTache" autofocus>
              @error('titreTache')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
           </div>
           <div class="form-group">
             <label>Membre responssable*</label>
             <div class="input-group col-xs-12">
               <select class="form-control  @error('ID_chercheur') is-invalid @enderror js-example-basic-multiple w-100" multiple="multiple" name="ID_chercheur[]" required>
                 <option value="">---------Selectionner pour---------</option>
                 @foreach($ch as $user)
                 <option value="{{$user->id}}"  {{(old('ID_chercheur') ==$user->id) ? 'selected' : '' }}>{{ $user->id }}-{{ $user->name }} {{ $user->prenom }} </option>
                 @endforeach
               </select>
           </div>
             @error('ID_chercheur')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
           </div>
           <div class="form-group">
             <div class="input-group col-xs-12">
               <label>Priorité</label>
             </div>

             <div class="custom-control custom-radio custom-control-inline">
               <input type="radio" id="customRadioInline1" name="priorite" value="très élevé" value="{{ old('priorite') }}" class="form-check-input custom-control-input">
               <label class="custom-control-label" for="customRadioInline1">très élevé</label>
             </div>
             <div class="custom-control custom-radio custom-control-inline">
               <input type="radio" id="customRadioInline2" name="priorite" value="élevé" value="{{ old('priorite') }}" class="custom-control-input">
               <label class="custom-control-label" for="customRadioInline2">élevé</label>
             </div>
             <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="customRadioInline3" name="priorite" value="moyenne" value="{{ old('priorite') }}" class="custom-control-input">
              <label class="custom-control-label" for="customRadioInline3">moyenne</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="customRadioInline4" name="priorite" value="bas" value="{{ old('priorite') }}" class="custom-control-input">
              <label class="custom-control-label" for="customRadioInline4">bas</label>
            </div>

             @error('priorite')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
           </div>

           <div class="form-group">
             <span class="input-group-addon"></span>
             <label>Date debut de tache</label>
             <div class="input-group date datepicker" >
             <input type="date" name="dateDebut" value="{{old('dateDebut')}}" class="form-control @error('dateDebut') is-invalid @enderror" nullable>
             </div>
                @error('dateDebut')
                   <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                   </span>
               @enderror

           </div>
           <div class="form-group">
             <label>Date delivration de tache*</label>
             <div class="input-group date datepicker" >
             <input type="date" name="dateFin" value="{{old('dateFin')}}" class="form-control @error('dateFin') is-invalid @enderror" required>
             </div>
                @error('dateFin')
                   <span class="invalid-feedback" role="alert">
                       <strong>{{ $message }}</strong>
                   </span>
               @enderror

           </div>
           <div class="form-group">
             <label>Description*</label>
             <textarea name="description" class="form-control  @error('description') is-invalid @enderror" id="maxlength-textarea"  maxlength="800" rows="8" placeholder="Description de la tache .." required>{{old('description')}}</textarea>
             @error('description')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
           </div>
           <div class="form-group">
             <label>Plus de details:</label>
             <input name="fichierDetail" type="file" class="btn btn-outline-warning" id="myDropify" value="{{old('fichierDetail')}}" accept=".blade,.php,.jpg,.jpeg,.png,.doc,.docx,application/msword,application/pdf,text/plain,application/vnd.ms-powerpoint,text/*,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="form-group  @error('fichierDetail') is-invalid @enderror"/>
             @error('fichierDetail')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
           </div>


                      <button class="btn btn-primary" type="submit"> {{__('Ajouter')}} <i data-feather="save"></i></button>
                      <a href="{{ url('taches') }}" class="btn btn-danger"> Annuler <i data-feather="x-square"></i></a>

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
  <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
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
  <script src="{{ asset('assets/js/dropify.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
@endpush
