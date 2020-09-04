@extends('layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/rfps">Appels d'offres</a></li>
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
              <a href="{{ url('rfps/create')}}" type="button" class="btn btn-outline-success"  data-toggle="tooltip" data-placement="bottom" title="Ajouter un nouveau RFP"><i data-feather="plus-circle"></i></a>
           </div>
            Liste des RFPs
          </h4>

          <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
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
                @foreach($appeldoffre as $rfp)
                <tr>
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
                          <a class="dropdown-item d-flex align-items-center" href="{{ url('rfps/'.$rfp->id.'/edit')}}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                          <button class="dropdown-item d-flex align-items-center" type="submit"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></button>
                        </form>
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
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
