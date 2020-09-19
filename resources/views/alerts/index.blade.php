@extends('layout.master')

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
                @if(auth()->user()->notifications->count()!=0)

                            <form  action="{{ url('alert/')}}" method="post" onsubmit="return confirm('Etes vous sure de vouloir supprimer tous les notifications définitivement?')">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <a href="{{ url('clearAll')}}" class="btn btn-success" type="button">Tout lu <i data-feather="check-square"></i></a>
                            <button type="submit"  class="btn btn-danger">Tout effacer  <i data-feather="delete"></i></button>
                            </form>

                @endif

        </div> Tout les notifications</h4>

        <div class="table-responsive">
                      @if(auth()->user()->notifications->count()==0)
                            <div class="text-center">
                                <h5 class="alert alert-warning">Pas de notifications</h5>
                            </div>
                     @endif
                     <table class="table">
                       <tbody>
                        @foreach(auth()->user()->notifications as $notification)
    {{--Notifications Non Lu--}}

              <a style=" color: #fff;" href="@if($notification->data['alert']['voir'] ){{ url($notification->data['alert']['voir'])}} @endif" name="button">
                    <tr >
                        @if($notification->read_at === NULL)
                            <div class="alert alert-fill-primary alert-dismissible fade show" role="alert">
                                @if ($notification->data['alert']['type'] ==="Modifier RFP")
                                <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i class="mdi mdi-table-edit"></i></span>
                                    <strong>L'RFP "{{$notification->data['alert']['nom']}}" a été modifier! allez voir il y a quoi de nouveau</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif($notification->data['alert']['type'] ==='Nouveau RFP')
                                <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i class="mdi mdi-gift"></i></span>
                                    <strong>L'RFP "{{$notification->data['alert']['nom']}}" a été ajouter, allez le découvrir !</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif ($notification->data['alert']['type'] ==="Supprimer RFP")
                                <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i data-feather="alert-triangle"></i></span>
                                    <strong>L'RFP "{{$notification->data['alert']['nom']}}" Va été supprimer vu l'expiration de l'appel d'offre !</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif($notification->data['alert']['type'] ==='echeance')
                                <div class="content" data-toggle="tooltip" title="Notifié par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i data-feather="alert-circle"></i></span>
                                    <strong>L'RFP "{{$notification->data['alert']['nom']}}" Va bientot expiré !</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif($notification->data['alert']['type'] ==='weekend')
                                <div class="content">
                                    <span class="icon"> <i class="mdi mdi-emoticon-cool"></i></span>
                                        <strong>LRIT vous souhaite un bon week-end!</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>

                                @elseif($notification->data['alert']['type'] ==='Nouveau membre')
                                <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i class="mdi mdi-account-plus"></i></span>
                                    <strong>{{ $notification->data['alert']['nom'] }} A rejoint LRIT !</strong>
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                  </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @endif
                                </div>
    {{--Notifications Lu--}}

                        @elseif($notification->read_at <> NULL)
                            <div class="alert alert-fill-dark alert-dismissible fade show" role="alert">
                               @if ($notification->data['alert']['type'] ==="Modifier RFP")
                                    <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i class="mdi mdi-table-edit"></i></span>
                                    <strong>L'RFP "{{$notification->data['alert']['nom']}}" a été modifier! allez voir il y a quoi de nouveau</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                       <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif($notification->data['alert']['type'] ==='Nouveau RFP')
                                    <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i class="mdi mdi-gift"></i></span>
                                    <strong>L'RFP "{{$notification->data['alert']['nom']}}" a été ajouter, allez le découvrir !</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                 <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                                 <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif ($notification->data['alert']['type'] ==="Supprimer RFP")
                                    <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i data-feather="alert-triangle"></i></span>
                                    <strong>L'RFP "{{$notification->data['alert']['nom']}}" Va été supprimer vu l'expiration de l'appel d'offre !</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif($notification->data['alert']['type'] ==='echeance')
                                    <div class="content" data-toggle="tooltip" title="Notifié par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i data-feather="alert-circle"></i></span>
                                    <strong>L'RFP "{{$notification->data['alert']['nom']}}" Va bientot expiré !</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif($notification->data['alert']['type'] ==='weekend')
                                    <div class="content">
                                    <span class="icon"> <i class="mdi mdi-emoticon-cool"></i></span>
                                        <strong>LRIT vous souhaite un bon week-end!</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                               <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                               <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>

                                @elseif($notification->data['alert']['type'] ==='Nouveau membre')
                                    <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i class="mdi mdi-account-plus"></i></span>
                                    <strong>{{ $notification->data['alert']['nom'] }} A rejoint LRIT !</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @endif
                            </div>

                        @endif
                    </tr>
                </a>
{{--Model
                <div class="modal fade" id="element-<?php echo $notification->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title text-info" id="exampleModalLabel">{{$notification->data['alert']['title'] }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ul class="list-group">
                                <li class="list-group-item"><h6 class="text-success"> Par:</h6>{{$notification->data['alert']['par'] }}</li>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button class='btn btn-primary' data-dismiss='modal' aria-label='Close' type='button'  data-toggle='tooltip' data-placement='bottom' title='Retour'>OK</button>
                             @if (url($notification->data['alert']['voir']) <> NULL)
                                 <a href="{{ url($notification->data['alert']['voir'])}}" class='btn btn-secondary' type='button'  data-toggle='tooltip' data-placement='bottom' title="Allez vers le lien de l'RFP">Voir</a>
                            @endif
                        </div>
                    </div>
                    </div>
                </div>
                --}}
            @endforeach
            </tbody>
        </table>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection
