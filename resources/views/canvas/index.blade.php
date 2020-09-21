@extends('layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/dropzone/dropzone.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/alerte">Notifications</a></li>
    <li class="breadcrumb-item active" aria-current="page">liste</li>
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
<div class="alert alert-danger alert-dismissible fade show" role="alert">
 <strong>{{session()->get('error')}} </strong>
 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
   <span aria-hidden="true">&times;</span>
 </button>
</div>
@endif

<div class="row">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title text-warning" align="center">
        <div align="right">
            <a href="#" class="btn btn-outline-success" data-toggle="modal" data-target="#element" title="Ajouter un nouveau canevas"><i data-feather="plus-circle"></i></a>
        </div> Liste des canevas standard</h4>
         <h6 class="card-subtitle mb-2 text-muted">Voici l'ensemble des canevas standard a suivre lors de la redaction de vos projets et presentations</h6>
            <div class="modal fade" id="element" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-info" id="exampleModalLabel">Créer canevas</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ url('canvas')}}" enctype="multipart/form-data">
                                    {{ csrf_field()}}
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Pour:</label>
                                        <input type="text" class="form-control @error('pour') is-invalid @enderror" name="pour" value="{{ old('pour') }}" required unique autocomplete="pour" autofocus>
                                            @error('pour')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Fichier:</label>
                                        <input type="file" accept=".png,.jpg,.jpeg,.doc,.docx,application/msword,application/pdf,text/plain,application/vnd.ms-powerpoint,text/*,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                        name="canvas" class="form-group  @error('canvas') is-invalid @enderror" id="myDropify" data-errors-position="outside" value="{{old('canvas')}}" class="border" required unique/>
                                        @error('canvas')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button class='btn btn-primary' type='submit'  data-toggle='tooltip' data-placement='bottom' title='Submit'>Enregistrer</a>
                                </div>
                                </form>
                            </div>
                            </div>
                            </div>
        <div class="col-md-12 card text-white">
            <img src="\assets\images\logo_dark.png" class="card-img" alt="logo" style="opacity: 40%">
            <div class="card-img-overlay">

                    <div class="wrapper"  style=" display: grid; grid-template-columns: repeat(4, 1fr); grid-gap: 10px; grid-auto-rows: minmax(100px, auto); grid-row-gap: 20px;">
                        @foreach($canvas as $c)
                            <div class="card">
                                <div class="dropdown mb-2" align="right">
                                    <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                                        <form  action="{{ url('canvas/'.$c->id)}}" method="post" onsubmit="return confirm('Etes vous sure de vouloir supprimer cet canevas définitivement?')">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <a class="dropdown-item d-flex align-items-center" href="#" title="Modifier canvas" data-toggle="modal" data-target="#element-<?php echo $c->id;?>"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                                            <button class="dropdown-item d-flex align-items-center" type="submit"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-header text-info"><h3> {{$c->pour}} </h3></div>
                                <div class="card-body" align="center">
                                <a href="{{ url('canvas/dowlaodCanvas/'.$c->id) }}" class="btn btn-light">Télécharger</a>
                                </div>
                            </div>
                            <div class="modal fade" id="element-<?php echo $c->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-info" id="exampleModalLabel">Modifier canevas N°{{$c->id}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form  action="{{ url('canvas/'.$c->id)}}" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="_method" value="PUT">
                                        {{ csrf_field() }}<div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Pour:</label>
                                        <input type="text" class="form-control @error('pour') is-invalid @enderror" name="pour" value="{{ $c->pour }}" required autocomplete="pour"  required unique autofocus>
                                            @error('pour')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                    </div>
                                    <div class="form-group">
                                        <label for="message-text" class="col-form-label">Fichier:</label>
                                        <form action="/file-upload" class="dropzone " id="exampleDropzone" class="border" unique required ></form>
                                          <form action="/file-upload"  value="{{$c->canvas}}"  data-errors-position="outside"  class="dropzone border form-group  @error('canvas') is-invalid @enderror" id="exampleDropzone" unique required></form>

                                        @error('canvas')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button class='btn btn-primary' type='submit'  data-toggle='tooltip' data-placement='bottom' title='Submit'>Modifier</a>
                                </div>
                                </form>
                            </div>
                            </div>
                            </div>
                        @endforeach
                    </div>
            </div>

        </div>
        </div>
     </div>
   </div>
 </div>

 @endsection
@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/typeahead-js/typeahead.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/dropzone/dropzone.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js') }}"></script>
@endpush

@push('custom-scripts')

  <script src="{{ asset('assets/js/dropzone.js') }}"></script>
  <script src="{{ asset('assets/js/form-validation.js') }}"></script>
  <script src="{{ asset('assets/js/inputmask.js') }}"></script>
  <script src="{{ asset('assets/js/typeahead.js') }}"></script>
  <script src="{{ asset('assets/js/tags-input.js') }}"></script>
  <script src="{{ asset('assets/js/dropzone.js') }}"></script>
  <script src="{{ asset('assets/js/dropify.js') }}"></script>
@endpush
