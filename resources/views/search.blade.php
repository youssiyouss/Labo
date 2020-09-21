@extends('layout.master')

@push('plugin-styles')
  <!-- Plugin css import here -->
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">home</a></li>
    <li class="breadcrumb-item active" aria-current="page">Search</li>
</ol>
</nav>


 <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">
                                 <h4 class="card-title text-warning"  align="center">Résultat de la recherche</h4>
                                         <div class="table-responsive">

  @can('Acces',Auth::user())
      @if(count($users) > 0)
    @if (isset($users))
     <br><h5 class="text-success" >Résultat trouvé pour les chercheurs :</h5><br>
                                            <table class="table table-striped table-secondary">
                                               <thead>
                                                   <tr>
                                                    <th></th>
                                                    <th>Membre</th>
                                                    <th>grade</th>
                                                    <th>Contacts</th>
                                                    <th>About</th>
                                                </tr>
                                               </thead>
                                               <tbody>
                                                  @foreach($users as $ch)
                                                   <tr class="col-md-2">
                                                    <td>
                                                        <div class="dropdown mb-2">
                                                            <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                                                                <form  action="{{ url('chercheurs/'.$ch->id)}}" method="post" onsubmit="return confirm('Etes vous sure de vouloir supprimer cet utilisateur?')">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                            <a class="dropdown-item d-flex align-items-center" href="{{ url('chercheurs/'.$ch->id)}}"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                                                            @if($ch->grade === 'Directeur') <a class="dropdown-item d-flex align-items-center" href="{{ url('chercheurs/'.$ch->id.'/edit')}}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>  @endif
                                                            <button class="dropdown-item d-flex align-items-center" type="submit"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></button>
                                                            </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-1">
                                                    <img src="{{ asset('storage/'.$ch->photo) }}" style=cursor:help; alt="image" data-toggle="tooltip" data-placement="bottom" title="{{$ch->about}}">
                                                    {{ $ch->name}} {{ $ch->prenom}}
                                                    <p  class=" text-muted" style="font-size:10px">membre {{$ch->created_at->locale('fr')->diffForHumans()}}</p>

                                                    </td>
                                                    <td>
                                                    {{$ch->grade}}
                                                    </td>
                                                    <td>
                                                    <p>{{ $ch->email}}</p> <p>{{ $ch->tel}}</p>
                                                    </td>
                                                    <td>
                                                    {{ $ch->about}}
                                                    </td>
                                                </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
       @endif
    @endif
  @endcan
  @if(count($clients) > 0)
    @if (isset($clients))
    <br><h5 class="text-success" >Résultat trouvé pour les clients :</h5><br>
                                                <table class="table table-striped table-warning">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Nom maitre ouvrage</th>
                                                            <th>Emplacement</th>
                                                            <th>Nombre d'appels</th>
                                                            <th>Nombre de projets courants</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       @foreach($clients as $c)
                                                        <tr class="col-md-2">
                                                            <td>
                                                                <div class="dropdown mb-2">
                                                                    <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                                                                        <form  action="{{ url('clients/'.$c->id)}}" method="post" onsubmit="return confirm('Etes vous sure de vouloir supprimer cet RFP définitivement?')">
                                                                            {{ csrf_field() }}
                                                                            {{ method_field('DELETE') }}
                                                                    <a class="dropdown-item d-flex align-items-center" href="#" title="Contacts" data-toggle="modal" data-target="#element-<?php echo $c->id;?>" title="Voir informations contact" name="button"><i data-feather="phone" class="icon-sm mr-2"></i> <span class="">Contact</span></a>
                                                                    @if(Auth::user()->grade === 'Directeur')
                                                                    <a class="dropdown-item d-flex align-items-center" href="{{ url('clients/'.$c->id.'/edit')}}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                                                                    <button class="dropdown-item d-flex align-items-center" type="submit"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></button>
                                                                    @endif
                                                                    </form>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                            <h6>{{$c->id}}- {{$c->ets}}</h6>
                                                            <footer align="right" class="blockquote-footer"> rejoint le :<cite>{{$c->created_at}}</cite></footer>
                                                            </td>
                                                            <td>
                                                                {{$c->ville}}/{{$c->pays}}
                                                            </td>
                                                            <td style="font-weight:italic;">
                                                            {{$c->NmbrContrat}}
                                                            </td>
                                                            <td>
                                                            {{$c->NmbrContratActives}}
                                                            </td>

                                                        </tr>

                                                        <div class="modal fade" id="element-<?php echo $c->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-info" id="exampleModalLabel">Contacts</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <ul class="list-group">
                                                                    <li class="list-group-item"><h6 class="text-primary">Adresse email :</h6>   {{$c->email}}</li>
                                                                    <li class="list-group-item"><h6 class="text-primary">Numéro de téléphone :</h6>   {{$c->tel}}</li>
                                                                    <li class="list-group-item"><h6 class="text-primary">Site web :</h6> {{$c->site}}</li>
                                                                    <li class="list-group-item"><h6 class="text-primary">Adresse d'etablissemnet :</h6> {{$c->adresse}}</li>
                                                                    </ul>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class='btn btn-primary' data-dismiss='modal' aria-label='Close' type='button'  data-toggle='tooltip' data-placement='bottom' title='Retour'>OK</a>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>

                                                        @endforeach
                                                    </tbody>
                                                    </table>

          @endif
      @endif
      @if(count($rfps) > 0)
        @if (isset($rfps))
        <br><h5 class="text-success" >Résultat trouvé pour les appels d'offres (RFPs) :</h5><br>
                                                    <table class="table table-striped table-info">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Titre d'RFP</th>
                                                            <th>Nature d'RFP</th>
                                                            <th>maitre d'ouvrage</th>
                                                            <th>Date d'écheance</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($rfps as $rfp)
                                                        <tr class="col-md-2">
                                                        <td>
                                                            <div class="dropdown mb-2">
                                                                <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                                                                    <form  action="{{ url('rfps/'.$rfp->id)}}" method="post" onsubmit="return confirm('Etes vous sure de vouloir supprimer cet RFP?')">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('DELETE') }}
                                                                <a class="dropdown-item d-flex align-items-center" href="#" title="Voir plus de details" data-toggle="modal" data-target="#element-<?php echo $rfp->id;?>" name="button"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                                                                @if(Auth::user()->grade === 'Directeur')
                                                                <a class="dropdown-item d-flex align-items-center" href="{{ url('rfps/'.$rfp->id.'/edit')}}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                                                                <button class="dropdown-item d-flex align-items-center" type="submit"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></button>
                                                                @endif
                                                                </form>
                                                                <a class="dropdown-item d-flex align-items-center" href="{{ url('rfps/dowlaodCanvas/'.$rfp->type)}}"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Canvas</span></a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{$rfp->id}}- {{$rfp->titre}}<div class="text-muted" align="right">{{$rfp->dateAppel}} a {{$rfp->heureAppel}}</div> </td>
                                                        <td>{{$rfp->type}}</td>
                                                        <td>{{$rfp->ets}}</td>
                                                        <td><span class="bg-danger">{{$rfp->dateEcheance}} a {{$rfp->heureEcheance}}</span></td>

                                                        </tr>
                                                        <div class="modal fade" id="element-<?php echo $rfp->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title text-info" id="exampleModalLabel">Télécharger l'RFP</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                <ul class="list-group">
                                                                <li class="list-group-item"><h6 class="text-success">Description de l'RFP:</h6><p>{{$rfp->resumer}}</p></li>
                                                                <li class="list-group-item"><h6 class="text-success">Source de l'appel:</h6>
                                                                    <p>
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
                                                                </ul>
                                                                </div>
                                                                <div class="modal-footer" align="center">
                                                                <?php
                                                                    $lien=$rfp->id;
                                                                if ($rfp->fichier!=null) {
                                                                    echo " <a href='rfps/dowlaodRfp/".$lien."' style=cursor:pointer; class='btn btn-outline-primary' type='button' data-toggle='tooltip' data-placement='bottom' title='Cliquez ici pour télécharger cet RFP!' >Télécharger RFP</a>";
                                                                    echo " <a href='rfps/voir/".$lien."' style=cursor:pointer; class='btn btn-outline-info' type='button' data-toggle='tooltip' data-placement='bottom' title='Voir le fichier attaché!' >Voir</a>";
                                                                }else{
                                                                    echo "<button class='btn btn-primary' data-dismiss='modal' aria-label='Close' type='button'  data-toggle='tooltip' data-placement='bottom' title='Aucun fichier a télécharger!'>OK</a>";
                                                                }
                                                                ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>

                                                        @endforeach
                                                    </tbody>
                                                    </table>

        @endif
      @endif
      @if(count($projets) > 0)
        @if (isset($projets))
        <br><h5 class="text-success">Résultat trouvé pour les projets soumis :</h5><br>
                                                    <table class="table table-striped table-danger">
                                                    <thead>

                                                      <tr>
                                                        <th></th>
                                                        <th>Chef de projet</th>
                                                        <th>Titre du projet</th>
                                                        <th>RFP du projet</th>
                                                        <th>Réponse</th>
                                                        <th>Présentation</th>
                                                      </tr>
                                                    </thead>
                                                   <tbody>
                                                       @foreach($projets as $s)

                                                     <tr class="col-md-2">
                                                       <td>
                                                            <div class="dropdown mb-2">
                                                                <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">

                                                                <a class="dropdown-item d-flex align-items-center" href="{{ url('projets/'.$s->id)}}"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                                                                    @if (Auth::user()->can('voir',[App\Projet::class,$s->chefDeGroupe]))
                                                                    <form  action="{{ url('projets/'.$s->id)}}" method="post" onsubmit="return confirm('Etes vous sure de vouloir supprimer ce projet définitivement?')">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('DELETE') }}
                                                                        <a class="dropdown-item d-flex align-items-center" href="{{ url('projets/'.$s->id.'/edit')}}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                                                                        <button type="submit" class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></button>
                                                                    </form>
                                                                @endif

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="py-1">
                                                            <img type="button" data-toggle='popover' title='{{$s->name}} {{ $s->prenom}}' src="{{ asset('storage/'.$s->photo) }}" alt="image">
                                                        </td>
                                                        <td data-toggle='popover' title="{{$s->created_at}}">
                                                            <b>{{$s->id}}</b>_{{$s->nom}}
                                                            <div class="text-muted" align="right"> <br>{{(new Carbon\Carbon($s->created_at))->locale('fr')->diffForHumans()}}</div>
                                                        </td>
                                                        <td>#<a href="{{ url('rfps/'.$s->ID_rfp)}}" data-toggle="popover" title="Voir l'appel d'offre de cette soumission" target="_blank">{{$s->ID_rfp}}</a></td>
                                                        <td>
                                                        @if($s->reponse) {{$s->reponse}} @else <p class="text-muted">Aucune réponse</p>  @endif
                                                        </td>
                                                        <td>
                                                            <?php
                                                                $lien=$s->id;
                                                            if ($s->fichierDoffre!=null) {
                                                                $name=substr($s->fichierDoffre, 5);

                                                            echo "<a href='projets/dowlaodProjet/".$lien."' style=cursor:pointer; data-toggle='popover' title='Télécharger fichier!'>".Str::limit($name, 20,'..."')."</a>";
                                                            }else {
                                                            echo "Aucun fichier";
                                                            }
                                                            ?>
                                                        </td>

                                                     </tr>
                                                    @endforeach
                                                  </tbody>
                                                  </table>
        @endif
      @endif

                                            </div>
     @if(count($canvas) > 0)
        @if (isset($canvas))
        <br><h5 class="text-success" >Résultat trouvé pour les canvas standard :</h5><br>

                <div class="col-md-12 card text-white">
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
                                <div class="card-body" >
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
                                        <input type="file" accept=".png,.jpg,.jpeg,.doc,.docx,application/msword,application/pdf,text/plain,application/vnd.ms-powerpoint,text/*,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                                        name="canvas" class="form-group  @error('canvas') is-invalid @enderror" id="myDropify" data-errors-position="outside" value="{{$c->canvas}}" class="border" unique required />
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
        @endif
      @endif

                                        </div>
                                    </div>
                                </div>
                            </div>

       </div>
     </div>
   </div>


@endsection

@push('plugin-scripts')
  <!-- Plugin js import here -->
@endpush

@push('custom-scripts')
  <!-- Custom js here -->
@endpush
