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
    <li class="breadcrumb-item"><a href="{{ url('livrables/MesLivrables/'.$projectId)}}">livrable</a></li>
    <li class="breadcrumb-item active" aria-current="page">Modifier livrable</li>
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
         <div class="card-header text-primary" align="center"> <i>{{$name}}</i></div>
       <div class="card-body">
         <h6 class="card-title text-warning">Livrable de la tâche : <span class="text-muted">{{$tache->titreTache}}</span></h6>
         @foreach($l as $l)
         <form class="form-group" files=true action="{{ url('livrables/'.$l->id_tache)}}" method="post" enctype="multipart/form-data">
          <input type="hidden" name="_method" value="PUT">
          {{ csrf_field() }}
           @endforeach

           <div class="form-group">
           <div class="form-group">
           <label>Type </label>
            <div class="input-group col-xs-12">
               <input type="string" name="type" class="form-control @error('type') is-invalid @enderror" placeholder="Ex: MCD/ Diagramme de classe/ Diagrame de séquence ..." name="type" value="{{old('type', $l->type)}}" autocomplete="type" required/>
            </div>
           </div>
             <div class="input-group col-xs-12">
               <label>Progrès</label>
             </div>

             <div class="custom-control custom-radio custom-control-inline">
               <input type="radio" id="customRadioInline1" name="avancement" value="Non entamé" @if($l->avancement=='Non entamé') checked @endif class="form-check-input custom-control-input">
               <label class="custom-control-label" for="customRadioInline1">Non entamé </label>
             </div>
             <div class="custom-control custom-radio custom-control-inline">
               <input type="radio" id="customRadioInline2" name="avancement" value="J'y travaille" @if($l->avancement=="J'y travaille") checked @endif class="custom-control-input">
               <label class="custom-control-label" for="customRadioInline2">J'y travaille</label>
             </div>
             <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="customRadioInline3" name="avancement" value="Bientôt disponible" @if($l->avancement=='Bientôt disponible') checked @endif class="custom-control-input">
              <label class="custom-control-label" for="customRadioInline3">Bientôt disponible</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input type="radio" id="customRadioInline4" name="avancement" value="Terminée"  @if($l->avancement=='Terminée') checked @endif class="custom-control-input">
              <label class="custom-control-label" for="customRadioInline4">Terminée</label>
            </div>

             @error('avancement')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
           </div>

           <div class="form-group">
             <label>Commentaire</label>
             <textarea name="commentaire" class="form-control  @error('commentaire') is-invalid @enderror" id="maxlength-textarea"  maxlength="600" rows="8" placeholder="Remarque ou bien indication sur le travail ..">{{old('commentaire', $l->commentaire)}}</textarea>
             @error('commentaire')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
           </div>
           <div class="form-group">
             <label>Délivrable</label>
             <input name="contenu" type="file" class="btn btn-outline-warning" id="myDropify"  value="{{old('contenu', $l->contenu)}}"  class="form-group  @error('contenu') is-invalid @enderror"/>
             @error('contenu')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
           </div>

                      <button class="btn btn-primary" type="submit"> {{__('Modifier')}} <i data-feather="save"></i></button>
                      <a href="{{ url('livrables/MesLivrables/'.$projectId)}}" class="btn btn-danger"> Annuler <i data-feather="x-square"></i></a>

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
