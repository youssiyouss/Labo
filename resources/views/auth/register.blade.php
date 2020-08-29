@extends('layout.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>

                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>
                        <div class="form-group">
                          <label for="exampleInputText1">Prénom*</label>
                          <input type="text" class="form-control @error('prenom') is-invalid @enderror"  id="exampleInputText1" placeholder="Veuillez saisir votre prénom"
                          name="prenom" value="{{ old('prenom') }}" required autocomplete="prenom">
                          @error('prenom')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="">
                          <div class="form-group ">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <div class="col-md-12">
                          <input type="checkbox" onchange="ShowPsw(this);"  style="cursor:pointer;">
                          <span id="checkbox">Afficher le mot de passe</span>
                        </div>


                        </div>

                        <div class="form-group">
                          <label for="exampleInputNumber1">Numero de téléphne*</label>
                          <input type="tel" class="form-control @error('tel') is-invalid @enderror" id="exampleInputNumber1" placeholder="06********"
                           name="tel" value="{{ old('tel') }}" required autocomplete="tel">
                           @error('tel')
                           <div class="invalid-feedback">
                             {{ $message }}
                           </div>
                           @enderror
                        </div>

                        <div class="form-group">
                          <label for="exampleFormControlSelect1">Grade*</label>
                          <select class="form-control  @error('grade') is-invalid @enderror"  name="grade" required id="exampleFormControlSelect1">
                            <option selected disabled value="{{old('grade')}}">{{old('grade')}}</option>
                            <option value="Directeur">Directeur</option>
                            <option value="Chercheur">Chercheur</option>
                            <option value="Enseignant-Chercheur">Enseignant-Chercheur</option>
                            <option value="Chercheur post-doctorants">Chercheur post-doctorants</option>
                            <option value="Doctorant">Doctorant</option>
                            <option value="Stagiaire">Stagiaire</option>
                            <option value="Membre externe">Membre externe</option>
                          </select>
                          @error('grade')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label for="exampleFormControlTextarea1">À propos</label>
                          <textarea class="form-control  @error('about') is-invalid @enderror" id="exampleFormControlTextarea1"  rows="5" name="about" placeholder="Parlez-nous brièvement de vous">{{old('about')}}</textarea>
                          @error('about')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                        <div class="form-group">
                          <label>Photo de profile</label>
                         <div class="input-group col-xs-12">
                             <input type="file" accept=".png,.jpg,.jpeg,.svg,.bmp" data-default-file="{{old('photo')}}"
                              name="photo" class="form-group  @error('photo') is-invalid @enderror" id="myDropify" value="{{old('photo')}}" class="border" unique/>
                          </div>
                          @error('photo')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
