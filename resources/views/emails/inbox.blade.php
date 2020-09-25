@extends('layout.master')

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/email/inbox')}}">email</a></li>
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
              <br>
              <div class="aside-compose"></div>
              <div class="aside-nav collapse">
                <ul class="nav">
                  <li class="active"><a href="{{ url('/email/inbox') }}"><span class="icon"><i data-feather="inbox"></i></span>Inbox<span class="badge badge-danger-muted text-white font-weight-bold float-right">{{count($unreadMails)}}</span></a></li>
                  <li><a href="{{ url('/email/inboxSent') }}"><span class="icon"><i data-feather="mail"></i></span>Sent Mail</a></li>
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
            <div class="email-inbox-header">
              <div class="row align-items-center">
                <div class="col-lg-6">
                  <div class="email-title mb-2 mb-md-0"><span class="icon"><i data-feather="inbox"></i></span> Boite de receptions <span class="new-messages">({{count($unreadMails)}} nouveaux messages)</span> </div>
                </div>
                <div class="col-lg-6">
                  <div class="email-search">
                    <form class="search-form" action="/mailSearch" method="get">
                    <div class="input-group input-search">
                      <input class="form-control" name="MailSearch" type="text" placeholder="Chercher mail..."><span class="input-group-btn">
                      <button class="btn btn-outline-secondary" type="submit"><i data-feather="search"></i></button></span>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="email-filters d-flex align-items-center justify-content-between flex-wrap">
              <div class="email-filters-left flex-wrap d-none d-md-flex">
                <div class="btn-group ml-3">
                   <a class="btn btn-outline-success btn-block" href="{{ url('/email/compose/'.Auth::user()->id).'/0'}}"><i data-feather="pen-tool"></i> Rédiger un Email</a>

                </div>
              </div>
               <div class="btn-group ml-3" align="right">
                  <a href="{{ url('email/clearAll/'.Auth::user()->id)}}" class="btn btn-outline-primary" type="button">  tous lire <span class="caret"></span></a>
                  <form  action="{{ url('email/deleteAll/'.Auth::user()->id)}}" method="post" onsubmit="return confirm('Etes vous sur de vouloir supprimer tous vos messages ?')">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                  <button class="btn btn-outline-danger" type="submit">  tous supprimer <span class="caret"></span></button>
                  </form>
                </div>

              {{--<div class="email-filters-right"><span class="email-pagination-indicator">1-50 of 253</span>
                <div class="btn-group email-pagination-nav">
                  <button class="btn btn-outline-secondary btn-icon" type="button"><i data-feather="chevron-left"></i></button>
                  <button class="btn btn-outline-secondary btn-icon" type="button"><i data-feather="chevron-right"></i></button>
                </div>
              </div>--}}
            </div>
            <div class="email-list">
                @foreach($content as $c)
                @if($c->read_at == NULL)
                <div class="email-list-item email-list-item--unread">
                <div class="email-list-actions">
                  <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                        <form  action="{{ url('email/'.$c->id)}}" method="post" onsubmit="return confirm('Etes vous sure de vouloir supprimer ce message?')">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                           <a class="dropdown-item  d-flex align-items-center" href="{{url('email/markAsRead/'.$c->id)}}"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">Mark as read</span></a>
                           <a class="dropdown-item  d-flex align-items-center" href="{{url('email/markAsUnread/'.$c->id)}}"><i data-feather="eye-off" class="icon-sm mr-2"></i> <span class="">Mark as unread</span></a>
                           <div class="dropdown-divider"></div>
                           <button class="dropdown-item d-flex align-items-center" type="submit"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></button>
                        </form>
                        </div>
                  </div>
                </div>
                <a href="{{ url('/email/read/'.$c->id) }}" class="email-list-detail">
                  <div  class="mr-3">

                  <span class="from">
                      <img src="{{ asset('storage/'.$c->photo) }}" alt="sender" title="{{$c->name}}  {{$c->prenom}}" class="rounded-circle  wd-35"> {{$c->from}}
                  </span>
                    <p class="msg">{{$c->subject}}</p>

                  </div>
                  <span class="date">
                    <span class="icon"><i data-feather="paperclip"></i> </span>
                    {{$c->created_at}}
                  </span>
                </a>
              </div>

              @elseif($c->read_at <> NULL)
              <div class="email-list-item">
                <div class="email-list-actions">
                  <div class="dropdown mb-2">
                        <button class="btn p-0" type="button" id="dropdownMenuButton7" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton7">
                        <form  action="{{ url('email/'.$c->id)}}" method="post" onsubmit="return confirm('Etes vous sure de vouloir supprimer ce message?')">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                           <a class="dropdown-item  d-flex align-items-center" href="{{url('email/markAsRead/'.$c->id)}}"><i data-feather="eye" class="icon-sm mr-2"></i> <span class="">Mark as read</span></a>
                           <a class="dropdown-item  d-flex align-items-center" href="{{url('email/markAsUnread/'.$c->id)}}"><i data-feather="eye-off" class="icon-sm mr-2"></i> <span class="">Mark as unread</span></a>
                           <div class="dropdown-divider"></div>
                           <button class="dropdown-item d-flex align-items-center" type="submit"><i data-feather="trash" class="icon-sm mr-2"></i> <span class="">Delete</span></button>
                        </form>
                        </div>
                  </div>
                </div>
                <a href="{{ url('/email/read/'.$c->id) }}" class="email-list-detail">
                  <div  class="mr-3">

                  <span class="from">
                      <img src="{{ asset('storage/'.$c->photo) }}" alt="sender" title="{{$c->name}}  {{$c->prenom}}" class="rounded-circle  wd-35"> {{$c->from}}
                  </span>
                    <p class="msg">{{$c->subject}}</p>

                  </div>
                  <span class="date">
                   {{$c->created_at}}
                  </span>

                </a>
              </div>

              @endif
              @endforeach
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
