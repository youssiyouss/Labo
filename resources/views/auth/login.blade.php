@extends('layout.master2')

@section('content')

<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page">
    <div class="col-md-8 col-xl-6 mx-auto">
      <div class="card">
        <div class="row">
          <div class="col-md-4 pr-md-0">
            <div class="auth-left-wrapper" style="background-image:  url('/assets/images/background.jpg') ">

            </div>
          </div>

          <div class="col-md-8 pl-md-0">
            <div class="row justify-content-center">
              <img src="/assets/images/logo_dark.png" height="100" width="110" alt="">
            </div>
            <div class="auth-form-wrapper px-4 py-5">

              <h5 class="font-weight-normal mb-4 noble-ui-logo logo-light d-block mb-2">Bienvenue a LRi<span>T</span> !</h5>
              <form method="POST" action="{{ route('login') }}">
                  @csrf
                <div class="form-group">
                  <label for="email">Adresse email</label>
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                  @error('email')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>



                <div class="form-group">
                  <label for="password">Mot de passe</label>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                      </span>
                  @enderror
                </div>

                <div class="form-check form-check-flat form-check-primary">
                  <label class="form-check-label" for="remember">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                      {{ __('Se souvenir de moi') }}
                  </label>
                </div>

                <div class="mt-3">
                  <button type="submit" class="btn btn-outline-primary mr-2 mb-2 mb-md-0">{{ __('Login') }}  <i class="mdi mdi-login-variant"></i></button>
                  @if (Route::has('password.request'))
                      <a class="btn btn-link" href="{{ route('password.request') }}">
                          {{ __('Mot de passe oublié ?') }}
                      </a>
                  @endif
                </div>
                <!-- <a href="{{ url('/auth/register') }}" class="d-block mt-3 text-muted">Not a user? Sign up</a> -->




              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

@endsection
