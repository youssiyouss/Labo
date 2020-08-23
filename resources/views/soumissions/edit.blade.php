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

        <form class="form-group" files=true action="{{ url('projets/'.$soumission->id)}}" method="post" enctype="multipart/form-data">
          <input type="hidden" name="_method" value="PUT">
          {{ csrf_field() }}
          <div align="right">
            <button  type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#element1" >Completer le formulaire <i data-feather="chevrons-right"></i></button>
          </div>

          <div class="form-group">
            <label>Titre du projet</label>
            <input type="text" class="form-control @error('nom') is-invalid @enderror" placeholder="Veuillez indiquer le nom de votre projet"
             name="nom" value="{{old('nom', $soumission->nom)}}" required unique autocomplete="nom" required unique autofocus>
             @error('nom')
                 <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                 </span>
             @enderror
          </div>
          <div class="form-group">
            <label>RFP concerné</label>
            <div class="input-group col-xs-12">
              <select class="form-control  @error('ID_rfp') is-invalid @enderror"  value="{{old('ID_rfp', $soumission->ID_rfp)}}" name="ID_rfp" required>
                @foreach($rfps as $l)
                @if (old('ID_rfp')==$l->id)
                      <option value={{$l->id}} selected>{{$l->id}}-{{ $l->nom }}</option>
                  @else
                      <option value={{$l->id}} >{{$l->id}}-{{ $l->titre }}</option>
                  @endif
                @endforeach
              </select>
              <span class="input-group-append">
                <a href="{{ url('rfps/create')}}" class="btn btn-outline-info" target="_blank" onsubmit="return confirm('Voulez-vous ajouter un nouveau RFP dans la plate-forme!')"> Ajouter</a>
              </span>
              @error('ID_rfp')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div>
          </div>
          <div class="form-group">
            <label>Endroit de soumission</label>
            <div class="input-group">
              <input type="text" value="{{old('plateForme', $soumission->plateForme)}}" name="plateForme" class="form-control @error('plateForme') is-invalid @enderror" placeholder="Veuillez entrez le lien de la plateforme /l'adresse.. du maitre d'ouvrage" name="plateForme" autocomplete="plateForme" required/>
            </div>
            @error('plateForme')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="form-group">
            <span class="input-group-addon"><i data-feather="file"></i></span>
            <label> Veuillez télécharger le fichier de votre présentation</label>
            <div class="input-group">
              <input type="file" accept=".doc,.docx,application/msword,application/pdf,text/plain,application/vnd.ms-powerpoint,text/*,application/vnd.openxmlformats-officedocument.wordprocessingml.document" name="fichierDoffre" class="form-group  @error('fichierDoffre') is-invalid @enderror" id="myDropify"  value="{{old('fichierDoffre', $soumission->fichierDoffre)}}" class="border" unique/>
            </div>
            @error('fichierDoffre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

                     <button class="btn btn-primary" type="submit"> {{__('Modifier')}} <i data-feather="save"></i></button>
                     <a href="{{ url('projets') }}" class="btn btn-danger"> Annuler <i data-feather="x-square"></i></a>

                     <div class="modal fade" id="element1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                       <div class="modal-dialog modal-lg" role="document">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <h5 class="modal-title text-info" id="exampleModalLabel">Compléter les information pour ce projet</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                   <span aria-hidden="true">&times;</span>
                                 </button>
                             </div>
                             <div class="modal-body">
                                         <div class="form-group">
                                           <label for="recipient-name" class="col-form-label text-success">éponse du maitre d'ouvrage:</label>
                                           <select class="form-control  @error('reponse') is-invalid @enderror"  name="reponse" value="{{old('reponse', $soumission->reponse)}}" required>
                                               <option value="Accepté"  {{ old('reponse') == 'Accepté' ? 'selected' : '' }}>Accepté</option>
                                               <option value="Refusé" {{ old('reponse') == 'Refusé' ? 'selected' : '' }}>Refusé</option>
                                               <option value="Accepté avec reserve"  {{ old('reponse') == 'Accepté avec reserve' ? 'selected' : '' }}>Accepté avec reserve</option>
                                            </select>
                                            <span class="input-group-append">
                                               <input name="lettreReponse" type="file" accept=".jpg,.png,.jpeg,.doc,.docx,application/msword,application/pdf,text/plain,application/vnd.ms-powerpoint,text/*,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="btn btn-outline-warning form-group  @error('lettreReponse') is-invalid @enderror" value="{{old('lettreReponse', $soumission->lettreReponse)}}" required />  -Veuillez Joinder la lettre de reponse
                                             </span>
                                             @error('lettreReponse')
                                                 <span class="invalid-feedback" role="alert">
                                                     <strong>{{ $message }}</strong>
                                                 </span>
                                             @enderror
                                         </div>

                                              <div class="form-group ">
                                                <label class="col-form-label">Nombre de participants dans le groupe</label>
                                                <input type="number" class="form-control  @error('nmbrParticipants') is-invalid @enderror" id="exampleInputMobile" placeholder="1" name="nmbrParticipants" autocomplete="nmbrParticipants" value="{{old('nmbrParticipants', $soumission->nmbrParticipants)}}">
                                                @error('nmbrParticipants')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                              </div>
                                              <div class="form-group ">
                                                <label class="col-form-label">Date du lancement du projet</label>
                                                <div class="input-group date datepicker" id="datePickerExample">
                                                  <input type="text" class="form-control @error('lancement') is-invalid @enderror" name="lancement" value="{{old('lancement', $soumission->lancement)}}" required><span class="input-group-addon"><i data-feather="calendar"></i></span>
                                                </div>
                                                @error('lancement')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                              </div>
                                              <div class="form-group ">
                                                <label class="col-form-label">Date du fin du projet</label>
                                                <div class="input-group date datepicker" id="datePickerExample1">
                                                  <input type="text" class="form-control @error('cloture') is-invalid @enderror" name="cloture" value="{{old('cloture', $soumission->cloture)}}" required><span class="input-group-addon"><i data-feather="calendar"></i></span>
                                                </div>
                                                @error('cloture')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                              </div>
                                              <div class="form-group ">
                                                <label class="col-form-label">Rapport final</label>
                                                <div class="input-group date datepicker" id="datePickerExample1">
                                                  <input name="rapportFinal" type="file" class="btn btn-outline-warning" id="myDropify" value="{{old('rapportFinal')}}" accept=".doc,.docx,application/msword,application/pdf,text/plain,application/vnd.ms-powerpoint,text/*,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="form-group  @error('rapportFinal') is-invalid @enderror"/>
                                                </div>
                                                @error('rapportFinal')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                              </div>

                             </div>
                             <div class="modal-footer" align="center">
                               <button class='btn btn-light' data-dismiss='modal' aria-label='Close' type='button'  data-toggle='tooltip' data-placement='bottom' title='Retour'>Fermer</a>
                               <button class="btn btn-primary" type="submit"> {{__('Soumettre')}}</button>
                             </div>
                         </div>
                       </div>
                     </div>

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
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/form-validation.js') }}"></script>
  <script src="{{ asset('assets/js/dropify.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
  <script src="{{ asset('assets/js/timepicker.js') }}"></script>
@endpush
