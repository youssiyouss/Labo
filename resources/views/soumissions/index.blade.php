@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/projets">Projets</a></li>
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
             <a href="{{ url('projets/create')}}" type="button" class="btn btn-outline-success"  data-toggle="tooltip" data-placement="bottom" title="Ajouter une nouvelle soumission"><i data-feather="plus-circle"></i></a>
          </div>Liste des soumissions
        </h4>


         <div class="table-responsive">
           <table class="table table-striped table-bordered">
             <thead>
               <tr>
                 <th></th>
                 <th>Chef de projet</th>
                 <th>Titre du projet</th>
                 <th>RFP du projet</th>
                 <th>Endroit de soumission</th>
                 <th>Fichier de presentation</th>
               </tr>
             </thead>
             <tbody>
               @foreach($soumission as $s)
               <tr>
                <td>
                    <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                            <form  action="{{ url('projets/'.$s->id)}}" method="post" onsubmit="return confirm('Etes vous sure de vouloir supprimer ce projet définitivement?')">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                          <a class="dropdown-item d-flex align-items-center" href="{{ url('projets/'.$s->id.'/edit')}}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                          <button type="submit" class="dropdown-item d-flex align-items-center" href="#"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></button>
                            </form>
                        </div>
                    </div>
                </td>
                 <td class="py-1">
                    <img type="button" data-toggle='popover' title='{{$s->name}} {{ $s->prenom}}' src="{{ asset('storage/'.$s->photo) }}" alt="image">
                </td>
                 <td>
                     <b>{{$s->id}}</b>_{{$s->nom}}
                     <div class="text-muted" align="right"> <br>{{$s->created_at}}</div>
                </td>
                 <td>#<a href="{{ url('rfps/'.$s->ID_rfp)}}" data-toggle="popover" title="Voir l'appel d'offre de cette soumission" target="_blank">{{$s->ID_rfp}}</a></td>
                 <td>
                   <?php $lien= $s->plateForme;
                    if (!filter_var($lien, FILTER_VALIDATE_URL) === false) {
                      echo " <a href='".$lien."' target=_blank>$lien</a>";

                   }else {
                    echo "$lien";
                   }
                   ?>

                 </td>
                 <td>
                    <?php
                         $lien=$s->id;
                      if ($s->fichierDoffre!=null) {
                        $name=substr($s->fichierDoffre, 5);
                       echo "<a href='projets/dowlaodProjet/".$lien."' style=cursor:pointer; data-toggle='popover' title='Télécharger fichier!'>".$name."</a>";
                     }else {
                       echo "Aucun fichier";
                     }
                     ?>
                 </td>


               </tr>
               @endforeach
             </tbody>
           </table>
         </div>
       </div>
     </div>
   </div>
 </div>

 @endsection

 @push('plugin-scripts')
   <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
   <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
   <script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
   <script src="{{ asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
  @endpush

 @push('custom-scripts')
  <script src="{{ asset('assets/js/dropify.js') }}"></script>
  <script src="{{ asset('assets/js/datepicker.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
 @endpush
