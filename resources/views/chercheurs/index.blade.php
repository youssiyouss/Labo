@extends('layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/chercheurs">chercheurs</a></li>
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
           <a href="{{ url('chercheurs/create')}}" type="button" class="btn btn-outline-success"  data-toggle="tooltip" data-placement="bottom" title="Ajouter un nouveau RFP"><i data-feather="plus-circle"></i></a>
       </div>Membres du laboratoire
        </h4>

        <div class="table-responsive">
          <table class="table table-striped table-hover table-bordered">
            <thead>
              <tr>
                <th>

                </th>
                <th>
                  Membre
                </th>
                <th>
                  grade
                </th>
                <th>
                  Contacts
                </th>
                <th>
                 About
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach($chrchr as $ch)
              <tr>
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
        </div>
      </div>
    </div>
  </div>
</div>





@endsection
