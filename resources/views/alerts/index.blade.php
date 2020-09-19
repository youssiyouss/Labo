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



<div class="row chat-wrapper">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">
        <div class="row position-relative">
          <div class="col-lg-12 chat-content">
            <div class="chat-header border-bottom pb-2">
                  <div class="d-flex justify-content-between align-items-center pb-2 mb-2">
                    <div class="d-flex align-items-center">
                    <p>Tout les notifications</p>
                    </div>
                    <p align="right">
                     @if(auth()->user()->notifications->count()!=0)

                        <form  action="{{ url('alert/')}}" method="post" onsubmit="return confirm('Etes vous sure de vouloir supprimer tous les notifications définitivement?')">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <a href="{{ url('clearAll')}}" class="btn btn-outline-info" type="button">Tout lu <i data-feather="check-square"></i></a>
                        <button type="submit"  class="btn btn-outline-danger">Tout effacer  <i data-feather="delete"></i></button>
                        </form>

                     @endif
                    </p>
                    </div>
            </div>

            <div class="chat-body">
                      @if(auth()->user()->notifications->count()==0)
                            <div class="text-center">
                                <h5 class="alert alert-warning">Pas de notifications</h5>
                            </div>
                     @endif
                     <table class="table">
                       <tbody>
                        @foreach(auth()->user()->notifications as $notification)
    {{--Notifications Non Lu--}}

              <a href="@if($notification->data['alert']['voir'] ){{ url($notification->data['alert']['voir'])}} @endif"data-toggle="tooltip" title="Par : {{ $notification->data['alert']['par'] }}" name="button">
                    <tr >
                        @if($notification->read_at === NULL)
                                <div class="alert alert-fill-light alert-dismissible fade show" role="alert">
                                  <strong>{{ $notification->data['alert']['title'] }}</strong>
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                  </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
                                </div>
    {{--Notifications Lu--}}

                        @elseif($notification->read_at <> NULL)

                                <div class="alert alert-fill-info alert-dismissible fade show" role="alert">
                                  <strong>{{ $notification->data['alert']['title'] }}</strong>
                                <p style="float: right;font-size: 0.9rem; font-weight: 500;line-height: 1; color: cornflowerblue; text-shadow: 0 1px 0 #fff; opacity: .5;"> Lu  à: {{ $notification->read_at}}</p>
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                  </button>
                                    <footer class="blockquote-footer">{{ $notification->created_at }}</footer>
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
