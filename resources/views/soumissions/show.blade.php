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
    <li class="breadcrumb-item"><a href="/projets">Projets</a></li>
    <li class="breadcrumb-item active" aria-current="page">Voir</li>
  </ol>
</nav>





 <div class="row">
   <div class="col-lg-12 grid-margin stretch-card">
     <div class="card">
       <div class="card-body">
           <h4 class="card-title text-warning" align="center"> <i> {{$projet->id}} - {{$projet->nom}}</i></h4>
                <ul class="list-group">
                          <li class="list-group-item"><h6 class="text-success">Postulé pour l'RFP:</h6><p>{{$projet->ID_rfp}} - {{$projet->titre}}</p></li>
                          <li class="list-group-item"><h6 class="text-success">Maitre d'ouvrage:</h6><p>{{$projet->ets}}</p></li>
                          <li class="list-group-item"><h6 class="text-success">Chef de projet:</h6><p>{{$projet->name}} {{$projet->prenom}}</p></li>
                          <li class="list-group-item"><h6 class="text-success">Endroit de soumission:</h6><p>
                            <?php
                              $lien= $projet->plateForme;
                             if (!filter_var($lien, FILTER_VALIDATE_URL) === false) {
                               echo " <a href='".$lien."' target=_blank>".$lien."</a>";
                              }
                              else {
                                echo "$lien";
                              }
                            ?>
                            </p>
                          </li>
                          <li class="list-group-item"><h6 class="text-success">Fichier de l'offre:</h6>
                           @if ($projet->fichierDoffre)
                           <div align="right">
                                <a href="{{url('projets/voir1/'.$projet->id)}}" target=_blank class='btn btn-outline-light' type='button'>Voir l'offre</a>
                                <a href="{{url('projets/dowlaodProjet/'.$projet->id)}}" class='btn btn-outline-primary' type='button'>Télécharger l'offre</a>
                            </div>
                            @else
                            <div class="text-muted">Pas encore soumis</div>
                            @endif
                            </li>
                </ul>
                <br>
                <span> <h5> Post selléction</h5></span>
                <ul class="list-group">
                    <li class="list-group-item"><h6 class="text-success">Statut:</h6><p>{{$projet->reponse}} </p>
                    @if ($projet->lettreReponse)
                           <div align="right">
                                <a href="{{url('projets/voir2/'.$projet->id)}}" target=_blank class='btn btn-outline-info' type='button' data-toggle='tooltip' data-placement='bottom' title='Voir lettre de reposne' >Voir la lettre de reponse</a>
                            </div>
                    @else
                            <div class="text-muted">Pas encore de réponse</div>
                   @endif
                    </li>
                    <li class="list-group-item"><h6 class="text-success">Nombre de membre de'équipe:</h6><p>{{$projet->nmbrParticipants}}</p></li>
                    <li class="list-group-item"><h6 class="text-success">Date début de projet:</h6><p>{{$projet->lancement}}</p></li>
                    <li class="list-group-item"><h6 class="text-success">Date fin de projet:</h6><p>{{$projet->cloture}}</p></li>
            @if($projet->rapportFinal)
                 <li class="list-group-item"><h6 class="text-success">
                     <div align="right">
                           <a href="{{url('projets/voir3/'.$projet->id)}}" target=_blank class='btn btn-outline-light' type='button' data-toggle='tooltip' data-placement='bottom' title='Voir lettre de reposne' >Voir le travail final</a>
                           <a href="{{url('projets/dowlaodProjet1/'.$projet->id)}}" style=cursor:pointer; class='btn btn-outline-success' type='button' data-toggle='tooltip' data-placement='bottom' title='Cliquez ici pour télécharger cette proposition!' >Télécharger le rapport </a>

                     </div></li>
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
