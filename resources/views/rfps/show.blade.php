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
    <li class="breadcrumb-item active" aria-current="page">Voir</li>
  </ol>
</nav>





 <div class="row">
   <div class="col-lg-12 grid-margin stretch-card">
     <div class="card">
       <div class="card-body">
           <h4 class="card-title text-warning" align="center"> <i> {{$rfp->id}} - {{$rfp->titre}}</i></h4>
                <ul class="list-group">
                          <li class="list-group-item"><h6 class="text-success">Type de l'RFP:</h6><p>{{$rfp->type}}</p></li>
                          <li class="list-group-item"><h6 class="text-success">Maitre d'ouvrage:</h6><p>{{$rfp->ets}}</p></li>
                          <li class="list-group-item"><h6 class="text-success">Source de l'appel:</h6><p>
                            <?php
                              $lien= $rfp->sourceAppel;
                             if (!filter_var($lien, FILTER_VALIDATE_URL) === false) {
                               echo " <a href='".$lien."' target=_blank>".$lien."</a>";
                              }
                              else {
                                echo "$lien";
                              }
                            ?>
                            </p>
                          </li>
                          <li class="list-group-item"><h6 class="text-success">Description de l'RFP:</h6><p>{{$rfp->resumer}}</p></li>
                          <li class="list-group-item"><h6 class="text-success">Date d'apparition de l'appel:</h6><p>{{$rfp->dateAppel}} {{$rfp->heureAppel}}</p></li>
                          <li class="list-group-item"><h6 class="text-success">Date d'échéacne de l'appel:</h6><p>{{$rfp->dateEcheance}} {{$rfp->heureEcheance}}</p></li>
                            @if ($rfp->fichier)
                            <div align="center">
                                <a href="{{url('rfps/dowlaodRfp/'.$rfp->id)}}" style=cursor:pointer; class='btn btn-light' type='button' data-toggle='tooltip' data-placement='bottom' title='Cliquez ici pour télécharger cet RFP!' >Télécharger RFP</a>
                                <a href="{{ url('rfps/voir/'.$rfp->id)}}" class='btn btn-primary' type='button' data-toggle='tooltip' data-placement='bottom' title='Voir le fichier original de l\'RFP!' >Voir explication</a>
                            </div>
                            @endif
                </ul>
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
