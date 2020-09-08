@extends('layout.master')

@section('content')

<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/clients">Maitres ouvrages</a></li>
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
  <div class="col-lg-12 stretch-card">
    <div class="card">
      <div class="card-body">
         <h4 class="card-title text-warning" align="center">
        <div align="right">
            <a href="{{ url('clients/create')}}" type="button" class="btn btn-outline-success"  data-toggle="tooltip" data-placement="bottom" title="Ajouter un nouveau RFP"><i data-feather="plus-circle"></i></a>
        </div>
         Liste des maitres d'ouvrages
       </h4>
         <div class="table-responsive pt-3">
          <table class="table table-striped table-hover table-bordered " style=" font-weight: bold;">
            <thead>
              <tr>
                <th>

                </th>
                <th>
                  Nom maitre ouvrage
                </th>
                <th>
                 Nombre d'appels
                </th>
                <th>
                Nombre de projets courants
                </th>

              </tr>
            </thead>
            <tbody>
              @foreach($client as $c)
              <tr>
                <td>
                    <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                            <form  action="{{ url('clients/'.$c->id)}}" method="post" onsubmit="return confirm('Etes vous sure de vouloir supprimer cet RFP définitivement?')">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                          <a class="dropdown-item d-flex align-items-center" href="#" title="Contacts" data-toggle="modal" data-target="#element-<?php echo $c->id;?>" title="Voir informations contact" name="button"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">View</span></a>
                          <a class="dropdown-item d-flex align-items-center" href="{{ url('clients/'.$c->id.'/edit')}}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                          <button class="dropdown-item d-flex align-items-center" type="submit"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></button>
                        </form>
                        </div>
                      </div>
                </td>
                <td>
                <h6>{{$c->id}}- {{$c->ets}}</h6>
                   <footer align="right" class="blockquote-footer"> rejoint le :<cite>{{$c->created_at}}</cite></footer>
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
          </div>
          </div>
      </div>
    </div>
  </div>
</div>

@endsection
