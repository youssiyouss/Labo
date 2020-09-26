@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/simplemde/simplemde.min.css') }}" rel="stylesheet" />
@endpush

@section('content')


<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/email/inbox')}}">email</a></li>
    <li class="breadcrumb-item active" aria-current="page">lire</li>
  </ol>
</nav>


<div class="row inbox-wrapper">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-3 email-aside border-lg-right">
            <div class="aside-content">
              <div class="aside-header">
                <button class="navbar-toggle" data-target=".aside-nav" data-toggle="collapse" type="button"><span class="icon"><i data-feather="chevron-down"></i></span></button><span class="title">Boite Mail</span>
                <p class="description">{{Auth::user()->email}}</p>
              </div>
              <br> <br>
              <div class="aside-nav collapse">
                <ul class="nav">
                  <li class="active"><a href="{{ url('/email/inbox') }}"><span class="icon"><i data-feather="inbox"></i></span>Inbox<span class="badge badge-danger-muted text-white font-weight-bold float-right">{{count($unreadMails)}}</span></a></li>
                  <li><a href="{{ url('/email/inboxSent') }}"><span class="icon"><i data-feather="mail"></i></span>Messages envoyés</a></li>
                  <li><a href="{{ url('email/tags/Important')}}"><span class="icon"><i data-feather="briefcase"></i></span>Important <span class="badge badge-success">{{$important}}</span></a></li>
                </ul>
                <span class="title">Labels</span>
                 <ul class="nav nav-pills nav-stacked">
                  <li>
                    <a href=" {{ url('email/tags/Planifier')}} "><i data-feather="tag" class="text-warning"></i> Planifier </a>
                  </li>
                  <li><a href="{{ url('email/tags/Travail')}}">
                    <i data-feather="tag" class="text-primary"></i>Travail </a>
                  </li>
                  <li>
                    <a href="{{ url('email/tags/Informel')}}"> <i data-feather="tag" class="text-info"></i>Informel </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-9 email-content">
            <div class="email-head">
              <div class="email-head-subject">
                <div class="title d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center">
                    <a class="active" href="#"><span class="icon"><i data-feather="star" class="text-primary-muted"></i></span></a>
                    <span>{{$content->subject}}</span>
                  </div>
                  <div class="icons">
                    <a class="icon" data-toggle="modal" data-target="#varyingModal"><i data-feather="share" class="text-muted hover-primary-muted" data-toggle="tooltip" title="Transférer"></i></a>
                    <a class="icon" href="{{ url('/email/compose/'.Auth::user()->id).'/'.$content->sender }}"><i data-feather="edit-3" class="text-muted hover-primary-muted" data-toggle="tooltip" title="Répondre"></i></a>

                    <div class="modal fade" id="varyingModal" tabindex="-1" role="dialog" aria-labelledby="varyingModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="varyingModalLabel">Transferer message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form method="POST" action="{{ url('email/transfer/'.$content->id)}}" enctype="multipart/form-data">
                            {{ csrf_field()}}
                        <div class="modal-body">
                            <div class="form-group row py-0">
                            <label class="col-md-1 control-label">To:</label>
                            <div class="col-md-11">
                                <div class="form-group">
                                    <select  name="to[]" required class="compose-multiple-select form-control w-100 @error('to') is-invalid @enderror" multiple="multiple">
                                        @foreach($users as $l)
                                        <option value="{{$l->email}}"  {{(old('email') ==$l->email) ? 'selected' : '' }}>{{ $l->name }} {{ $l->prenom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @error('to')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Send message</button>
                        </div>
                    </form>
                    </div>
                    </div>
                </div>

                  </div>
                </div>
              </div>
              <div class="email-head-sender d-flex align-items-center justify-content-between flex-wrap">
                <div class="d-flex align-items-center">
                  <div class="avatar">
                    <img src="{{ asset('storage/'.$content->photo) }}" alt="Avatar" class="rounded-circle user-avatar-md">
                  </div>
                  <div class="sender d-flex align-items-center">
                  <a href="#" title="{{$content->email}}">{{$content->name}}  {{$content->prenom}}</a> <span>to</span><a href="#" title="{{$content->to}}">me</a>
                    <div class="actions dropdown">
                      <a class="icon" href="#" data-toggle="dropdown"><i data-feather="chevron-down"></i></a>
                      <div class="dropdown-menu" role="menu">
                        <div class="dropdown mb-2">
                          <form  action="{{ url('email/'.$content->id)}}" method="post" onsubmit="return confirm('Etes vous sure de vouloir supprimer ce message?')">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                          <button class="dropdown-item d-flex align-items-center" type="submit"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></button>
                        </form>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="date">{{$content->created_at}}</div>
              </div>
            </div>
            <div class="email-body">
              {{$content->message}}
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/simplemde/simplemde.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets/js/email.js') }}"></script>
@endpush
