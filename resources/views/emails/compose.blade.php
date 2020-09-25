@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/simplemde/simplemde.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/email/inbox')}}">email</a></li>
    <li class="breadcrumb-item active" aria-current="page">envoyer</li>
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
              <br>
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
            <div class="email-head">
              <div class="email-head-title d-flex align-items-center">
                <span data-feather="edit" class="icon-md mr-2"></span>
                Nouveau mail
              </div>
            </div>
            <div class="email-compose-fields">
            <form method="POST" action="{{ url('email')}}" enctype="multipart/form-data">
             {{ csrf_field()}}
            <input type="hidden" name="from" value="{{$from}}">
              <div class="to">
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

              </div>
              <div class="subject">
                <div class="form-group row py-0">
                  <label class="col-md-1 control-label">Subject:</label>
                  <div class="col-md-10">
                  <input name="subject" value="{{old('subject')}}" type="text" class="form-control  @error('subject') is-invalid @enderror" required>
                  </div>
                  @error('subject')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <br>
              <div class="tag">
                <div class="form-group row py-0">
                  <label class="col-md-1 control-label">Tag:</label>
                   <div class="col-md-10">
                    <select name="tag" class="form-control  @error('tag') is-invalid @enderror js-example-basic-single w-100" value="{{old('tag')}}">
                        <option value="">---------Ajoutez un tag---------</option>
                        <option value="Important"> Important</option>
                        <option value="Planifier">Planifier</option>
                        <option value="Travail">Travail</option>
                        <option value="Informel">Informel</option>
                    </select>
                </div>
                  @error('tag')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
            <br>

            <div class="email editor">
              <div class="col-md-12">
                <div class="form-group">
                  <label class="control-label sr-only" for="simpleMdeEditor">Descriptions </label>
                  <textarea name="tinymce"  class="form-control  @error('message') is-invalid @enderror" id="simpleMdeEditor" rows="5" required> </textarea>
                </div>
                @error('message')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
              </div>
              <div class="email action-send">
                <div class="col-md-12">
                  <div class="form-group mb-0">
                    <button class="btn btn-primary btn-space" type="submit"><i class="icon s7-mail"></i> Send</button>
                  <a href="{{ url('email/inbox')}}" class="btn btn-secondary btn-space" type="button"><i class="icon s7-close"></i> Cancel</a>
                  </div>
                </div>
              </div>
            </div>
            </form>
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
  <script src="{{ asset('assets/js/select2.js') }}"></script>
@endpush
