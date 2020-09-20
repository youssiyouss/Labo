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

                            <form  action="{{ url('alerte/')}}" method="post" onsubmit="return confirm('Etes vous sure de vouloir supprimer tous les notifications définitivement?')">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <a href="{{ url('alerte/clearAll')}}" class="btn btn-success" type="button">Tout lu <i data-feather="check-square"></i></a>
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
                        <form  action="{{ url('alerte/'.$notification->id)}}" method="post" onsubmit="return confirm('Etes vous sure de vouloir supprimer cette notifications définitivement?')">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
 {{--Notifications Non Lu--}}

 <tr>
                @if($notification->read_at === NULL)
                    <div class="alert alert-icon-primary alert-dismissible fade show" role="alert">
                        <a href="{{ url("readNotification/".$notification->id)}}" style=" color: #a37eba ;" >
                                {{--RFPS--}}
                                @if ($notification->data['alert']['type'] ==="Modifier RFP")
                                <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <i data-feather="check" style="color: orange;" title="Marquer comme lu"></i>
                                    <span class="icon"> <i class="mdi mdi-table-edit"></i></span>
                                    <strong>L'RFP "{{$notification->data['alert']['nom']}}" a été modifier! allez voir il y a quoi de nouveau</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif($notification->data['alert']['type'] ==='Nouveau RFP')
                                <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <i data-feather="check" style="color: orange;" title="Marquer comme lu"></i>
                                    <span class="icon"> <i class="mdi mdi-gift"></i></span>
                                    <strong>L'RFP "{{$notification->data['alert']['nom']}}" a été ajouter, allez le découvrir !</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif ($notification->data['alert']['type'] ==="Supprimer RFP")
                                <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <i data-feather="check" style="color: orange;" title="Marquer comme lu"></i>
                                    <span class="icon"> <i data-feather="alert-triangle"></i></span>
                                    <strong>L'RFP "{{$notification->data['alert']['nom']}}" Va été supprimer vu l'expiration de l'appel d'offre !</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                {{--RFP expiré--}}
                                @elseif($notification->data['alert']['type'] ==='echeance')
                                <div class="content" data-toggle="tooltip" title="Notifié par : {{ $notification->data['alert']['par'] }}">
                                    <i data-feather="check" style="color: orange;" title="Marquer comme lu"></i>
                                    <span class="icon"> <i data-feather="alert-circle"></i></span>
                                    <strong>{{$notification->data['alert']['title']}}"</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                {{--Festive--}}
                                @elseif($notification->data['alert']['type'] ==='weekend')
                                <div class="content">
                                    <i data-feather="check" style="color: orange;" title="Marquer comme lu"></i>
                                    <span class="icon"> <i class="mdi mdi-emoticon-cool"></i></span>
                                        <strong>LRIT vous souhaite un bon week-end!</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                               <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                </div>
                                @elseif($notification->data['alert']['type'] ==='Welcome')
                                    <div class="content">
                                    <i data-feather="check" style="color: orange;" title="Marquer comme lu"></i>
                                    <span class="icon"> <i class="mdi mdi-emoticon-happy"></i></span>
                                        <strong>{{$notification->data['alert']['title']}} </strong>
                                    <button type="submit" class="close" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                {{--Members--}}
                                @elseif($notification->data['alert']['type'] ==='Nouveau membre')
                                <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <i data-feather="check" style="color: orange;" title="Marquer comme lu"></i>
                                    <span class="icon"> <i class="mdi mdi-account-plus"></i></span>
                                    <strong>{{ $notification->data['alert']['nom'] }} A rejoint LRIT !</strong>
                                  <button type="submit" class="close"  aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                  </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                </div>
                                {{--Taches--}}
                                @elseif($notification->data['alert']['type'] ==='Nouvelle tache')
                                    <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <i data-feather="check" style="color: orange;" title="Marquer comme lu"></i>
                                    <span class="icon"> <i class="mdi mdi-text-shadow"></i></span>
                                    <strong> {{ $notification->data['alert']['title'] }}   (projet : {{ $notification->data['alert']['id'] }}_{{ $notification->data['alert']['nom'] }})</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                    </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif($notification->data['alert']['type'] ==='Modifier tache')
                                    <div class="content" data-toggle="tooltip" title="Modifier par : {{ $notification->data['alert']['par'] }}">
                                    <i data-feather="check" style="color: orange;" title="Marquer comme lu"></i>
                                    <span class="icon"> <i class="mdi mdi-text-shadow"></i></span>
                                    <strong> {{ $notification->data['alert']['title'] }}   (projet : {{ $notification->data['alert']['id'] }}_{{ $notification->data['alert']['nom'] }})</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif($notification->data['alert']['type'] ==='Supprimer tache')
                                    <div class="content" data-toggle="tooltip" title="Supprimer par : {{ $notification->data['alert']['par'] }}">
                                    <i data-feather="check" style="color: orange;" title="Marquer comme lu"></i>
                                    <span class="icon"> <i class="mdi mdi-text-shadow"></i></span>
                                    <strong> {{ $notification->data['alert']['title'] }}   (projet : {{ $notification->data['alert']['id'] }}_{{ $notification->data['alert']['nom'] }})</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                {{--Livrables--}}
                                @elseif($notification->data['alert']['type'] ==='Nouveau livrable')
                                    <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <i data-feather="check" style="color: orange;" title="Marquer comme lu"></i>
                                    <span class="icon"> <i class="mdi mdi-trello"></i></span>
                                    <strong> {{ $notification->data['alert']['title'] }}   (projet : #{{ $notification->data['alert']['id'] }})</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                    </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif($notification->data['alert']['type'] ==='Modifier livrable')
                                <div class="content" data-toggle="tooltip" title="MAJ par : {{ $notification->data['alert']['par'] }}">
                                    <i data-feather="check" style="color: orange;" title="Marquer comme lu"></i>
                                    <span class="icon"> <i class="mdi mdi-trello"></i></span>
                                    <strong> {{ $notification->data['alert']['title'] }}   (projet : #{{ $notification->data['alert']['id'] }})</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif($notification->data['alert']['type'] ==='Supprimer livrable')
                                    <div class="content" data-toggle="tooltip" title="Supprimer par : {{ $notification->data['alert']['par'] }}">
                                    <i data-feather="check" style="color: orange;" title="Marquer comme lu"></i>
                                    <span class="icon"> <i class="mdi mdi-trello"></i></span>
                                    <strong> {{ $notification->data['alert']['title'] }}   (projet : {#{{ $notification->data['alert']['id'] }})</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                    {{--Alerts Tache par le chef d'equipe--}}
                                @elseif($notification->data['alert']['type'] ==='Poke')
                                <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <i data-feather="check" style="color: orange;" title="Marquer comme lu"></i>
                                    <span class="icon"> <i class="mdi mdi-cursor-pointer"></i></span>
                                    <strong>{{ $notification->data['alert']['title'] }} !  (projet :{{ $notification->data['alert']['nom'] }})</strong>
                                  <button type="submit" class="close"  aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                  </button>
                                  <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                </div>


                            </a>
                        @endif
                    </div>


    {{--Notifications Lu--}}

                @elseif($notification->read_at <> NULL)
                            <div class="alert alert-fill-dark alert-dismissible fade show" role="alert">
                               <a style=" color: #fff;" href="@if($notification->data['alert']['voir'] ){{ url($notification->data['alert']['voir'])}} @endif" name="button">
                                {{--RFPS--}}
                                @if ($notification->data['alert']['type'] ==="Modifier RFP")
                                    <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i class="mdi mdi-table-edit"></i></span>
                                    <strong>L'RFP "{{$notification->data['alert']['nom']}}" a été modifier! allez voir il y a quoi de nouveau</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                                <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                       <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                </div>
                                @elseif($notification->data['alert']['type'] ==='Nouveau RFP')
                                    <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i class="mdi mdi-gift"></i></span>
                                    <strong>L'RFP "{{$notification->data['alert']['nom']}}" a été ajouter, allez le découvrir !</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                                 <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                                 <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif ($notification->data['alert']['type'] ==="Supprimer RFP")
                                    <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i data-feather="alert-triangle"></i></span>
                                    <strong>L'RFP "{{$notification->data['alert']['nom']}}" Va été supprimer vu l'expiration de l'appel d'offre !</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                                <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                    {{--RFP expiré--}}
                                @elseif($notification->data['alert']['type'] ==='echeance')
                                    <div class="content" data-toggle="tooltip" title="Notifié par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i data-feather="alert-circle"></i></span>
                                    <strong>{{$notification->data['alert']['title']}}"</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                                <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                    {{--Festive--}}
                                @elseif($notification->data['alert']['type'] ==='weekend')
                                <div class="content">
                                    <span class="icon"> <i class="mdi mdi-emoticon-cool"></i></span>
                                        <strong>LRIT vous souhaite un bon week-end!</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                               <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                               <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                </div>
                                @elseif($notification->data['alert']['type'] ==='Welcome')
                                    <div class="content">
                                    <span class="icon"> <i class="mdi mdi-emoticon-happy"></i></span>
                                    <strong>{{$notification->data['alert']['title']}} </strong>
                                    <button type="submit" class="close" aria-label="Close">
                                               <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                               <span aria-hidden="true">&times;</span>
                                    </button>
                                        <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                    {{--membres--}}
                                @elseif($notification->data['alert']['type'] ==='Nouveau membre')
                                    <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i class="mdi mdi-account-plus"></i></span>
                                    <strong>{{ $notification->data['alert']['nom'] }} A rejoint LRIT !</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                                <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                                <span aria-hidden="true">&times;</span>
                                    </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                    {{--Taches--}}
                                 @elseif($notification->data['alert']['type'] ==='Nouvelle tache')
                                    <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i class="mdi mdi-text-shadow"></i></span>
                                    <strong> {{ $notification->data['alert']['title'] }}   (projet : {{ $notification->data['alert']['id'] }}_{{ $notification->data['alert']['nom'] }})</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                               <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                               <span aria-hidden="true">&times;</span>
                                    </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif($notification->data['alert']['type'] ==='Modifier tache')
                                    <div class="content" data-toggle="tooltip" title="Modifier par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i class="mdi mdi-text-shadow"></i></span>
                                    <strong> {{ $notification->data['alert']['title'] }}   (projet : {{ $notification->data['alert']['id'] }}_{{ $notification->data['alert']['nom'] }})</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                               <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                               <span aria-hidden="true">&times;</span>
                                    </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif($notification->data['alert']['type'] ==='Supprimer tache')
                                    <div class="content" data-toggle="tooltip" title="Supprimer par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i class="mdi mdi-text-shadow"></i></span>
                                    <strong> {{ $notification->data['alert']['title'] }}   (projet : {{ $notification->data['alert']['id'] }}_{{ $notification->data['alert']['nom'] }})</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                               <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                               <span aria-hidden="true">&times;</span>
                                    </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                  {{--Livrables--}}
                                @elseif($notification->data['alert']['type'] ==='Nouveau livrable')
                                    <div class="content" data-toggle="tooltip" title="Ajouté par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i class="mdi mdi-trello"></i></span>
                                    <strong> {{ $notification->data['alert']['title'] }}   (projet : #{{ $notification->data['alert']['id'] }})</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                               <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                               <span aria-hidden="true">&times;</span>
                                    </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif($notification->data['alert']['type'] ==='Modifier livrable')
                                    <div class="content" data-toggle="tooltip" title="MAJ par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i class="mdi mdi-trello"></i></span>
                                    <strong> {{ $notification->data['alert']['title'] }}   (projet : #{{ $notification->data['alert']['id'] }})</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                               <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                               <span aria-hidden="true">&times;</span>
                                    </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @elseif($notification->data['alert']['type'] ==='Supprimer livrable')
                                    <div class="content" data-toggle="tooltip" title="Supprimer par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"> <i class="mdi mdi-trello"></i></span>
                                    <strong> {{ $notification->data['alert']['title'] }}   (projet : {#{{ $notification->data['alert']['id'] }})</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                               <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                               <span aria-hidden="true">&times;</span>
                                    </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                   {{--Alerts Tache par le chef d'equipe--}}
                                @elseif($notification->data['alert']['type'] ==='Poke')
                                    <div class="content" data-toggle="tooltip" title="Envoyé par : {{ $notification->data['alert']['par'] }}">
                                    <span class="icon"><i class="mdi mdi-alarm-check"></i></span>
                                    <strong>{{ $notification->data['alert']['title'] }} !  (projet :{{ $notification->data['alert']['nom'] }})</strong>
                                    <button type="submit" class="close"  aria-label="Close">
                                               <span class="text-info" align="right" style="font-size: 0.9rem;font-weight: 400;">Lu à : {{ $notification->read_at }}</span>
                                               <span aria-hidden="true">&times;</span>
                                    </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                    </div>
                                @endif

                            </a>
                        </div>
                @endif
</tr>

            </form>
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
