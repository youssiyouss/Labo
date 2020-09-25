<nav class="navbar">
  <a href="#" class="sidebar-toggler">
    <i data-feather="menu"></i>
  </a>
  <div class="navbar-content">
    <form class="search-form" action="/search" method="get">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i data-feather="search"></i>
          </div>
        </div>
        <input type="search" class="form-control" name="search" placeholder="Cherchez ici...">
      </div>
    </form>
    <ul class="navbar-nav">

      <li class="nav-item dropdown nav-messages">
          @php
            $messages = DB::table('emails')
                ->join('users','users.email','emails.from')
                ->select('users.name','users.prenom','users.photo','emails.*')
                ->where([['to', Auth::user()->email],['read_at' ,Null]])
                ->orderBy('created_at','desc')
                ->get();
          @endphp
        <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather="mail"></i>
          @if(count($messages))
          <div class="indicator">
            <div class="circle1"></div>
          </div>
          @endif
        </a>
        <div class="dropdown-menu" aria-labelledby="messageDropdown">
          <div class="dropdown-header d-flex align-items-center justify-content-between">
            <p class="mb-0 font-weight-medium">{{count($messages) }}Nouveaux Messages</p>
            @if(count($messages))<a href="{{url('email/clearAll')}}" class="text-muted">Clear all</a>@endif
          </div>
          <div class="dropdown-body">
            @foreach ($messages as $m)
          <a href="{{url('email/read/'.$m->id)}}" class="dropdown-item">
              <div class="figure">
                <img src="{{ asset('storage/'.$m->photo) }}" alt="userr">
              </div>
              <div class="content">
                <div class="d-flex justify-content-between align-items-center">
                  <p>{{$m->name}}  {{$m->prenom}}</p>
                <p class="sub-text text-muted">{{carbon\Carbon::parse($m->created_at)->locale('fr')->diffForHumans()}}</p>
                </div>
                <p class="sub-text text-muted">{{$m->subject}}</p>
              </div>
            </a>
            @endforeach
          </div>
          <div class="dropdown-footer d-flex align-items-center justify-content-center">
          <a href="{{ url('email/inbox')}}">Voir tout</a>
          </div>
        </div>
      </li>
      <li class="nav-item dropdown nav-notifications">
        <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather="bell"></i>
          @if(auth()->user()->unreadNotifications->count() != 0)
          <div class="indicator">
            <div class="circle"></div>
          </div>
          @endif
        </a>
        <div class="dropdown-menu" aria-labelledby="notificationDropdown">
          <div class="dropdown-header d-flex align-items-center justify-content-between">
            <p class="mb-0 font-weight-medium">{{ auth()->user()->unreadNotifications->count() }}  nouvelles notifications !</p>
         @if (auth()->user()->unreadNotifications->count()>= 1 )
            <a href="{{url('alerte/clearAll')}}" class="text-muted">Clear all</a>
         @endif

          </div>
          <div class="dropdown-body">
         @foreach (auth()->user()->unreadNotifications->take(4) as $notification)
            <a href="{{ url('alerte')}}" class="dropdown-item">
                    {{--RFPS--}}
                @if ($notification->data['alert']['type'] ==="Modifier RFP")
                   <div class="icon"> <i class="mdi mdi-table-edit"></i></div>
                    <div class="content">
                        <p>L'RFP N°{{ $notification->data['alert']['id'] }} a été modifier</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                @elseif($notification->data['alert']['type'] ==='Nouveau RFP')
                   <div class="icon"> <i data-feather="gift"></i></div>
                    <div class="content">
                        <p>Un nouveau RFP a été soumis !</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                @elseif ($notification->data['alert']['type'] ==="Supprimer RFP")
                   <div class="icon"> <i data-feather="alert-triangle"></i></div>
                    <div class="content">
                        <p>L'RFP N°{{ $notification->data['alert']['id'] }} a été supprimer</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                    {{--RFP expiré--}}
                @elseif($notification->data['alert']['type'] ==='echeance')
                  <div class="icon"> <i data-feather="alert-circle"></i></div>
                  <div class="content">
                        <p>La date d'echeance pour l'RFP N°{{ $notification->data['alert']['id'] }} s'approche !</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                    {{--membres--}}
                @elseif($notification->data['alert']['type'] ==='Nouveau membre')
                   <div class="icon"> <i data-feather="user-plus"></i></div>
                   <div class="content">
                        <p>Un nouveau membre a rejoint LRIT!</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                    {{--Taches--}}
                @elseif($notification->data['alert']['type'] ==='Nouvelle tache')
                   <div class="icon"> <i data-feather="type"></i></div>
                   <div class="content">
                        <p>Une nouvelle tâche vous a été attribuée !</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                @elseif($notification->data['alert']['type'] ==='Modifier tache')
                   <div class="icon"> <i data-feather="type"></i></div>
                   <div class="content">
                        <p>Une de vos tâches assignées a subi une modification !</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                @elseif($notification->data['alert']['type'] ==='Supprimer tache')
                   <div class="icon"> <i data-feather="type"></i></div>
                   <div class="content">
                        <p>Une de vos tâches assignées a été  annulée !</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                @elseif($notification->data['alert']['type'] ==='Equipe')
                   <div class="icon"> <i data-feather="plus"></i></div>
                   <div class="content">
                        <p>Vous avez été ajouter a une équipe de recherche</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                    {{--festive--}}
                @elseif($notification->data['alert']['type'] ==='weekend')
                   <div class="icon"> <i class="mdi mdi-emoticon-cool"></i></div>
                   <div class="content">
                        <p>LRIT vous souhaite un bon week-end!</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                @elseif($notification->data['alert']['type'] ==='Welcome')
                   <div class="icon"> <i data-feather="smile"></i></div>
                   <div class="content">
                        <p>{{$notification->data['alert']['title']}} </p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                @elseif($notification->data['alert']['type'] ==='Birthday')
                   <div class="icon"> <i data-feather="heart-on"></i></div>
                   <div class="content">
                        <p>C'est votre anniverssaire aujourd'hui !</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                    {{--Livrables--}}
                @elseif($notification->data['alert']['type'] ==='Nouveau livrable')
                   <div class="icon"> <i data-feather="trello"></i></div>
                   <div class="content">
                        <p>Vous avez un livrable a rendre !</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                @elseif($notification->data['alert']['type'] ==='Modifier livrable')
                   <div class="icon"> <i data-feather="trello"></i></div>
                   <div class="content">
                        <p>Un de vos livrables a été mise a jour !</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                @elseif($notification->data['alert']['type'] ==='Supprimer livrable')
                   <div class="icon"> <i data-feather="trello"></i></div>
                   <div class="content">
                        <p>Un de vos livrables a été annulé par le chef d'equipe!</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                @elseif($notification->data['alert']['type'] ==='Equipe')
                   <div class="icon"> <i data-feather="plus"></i></div>
                   <div class="content">
                        <p>Vous avez été ajouter a une équipe de recherche</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                    {{--Alerts Tache par le chef d'equipe--}}

                   @elseif($notification->data['alert']['type'] ==='Poke')
                   <div class="icon"> <i data-feather="alert-octagon"></i></div>
                   <div class="content">
                        <p>Vous avez recu un Poke à propos du projet N°{{$notification->data['alert']['id']}} </p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                   </div>
                   {{--Projets--}}
                 @elseif($notification->data['alert']['type'] ==='Nouveau Projet')
                   <div class="icon"> <i data-feather="star"></i></div>
                   <div class="content">
                        <p>Soumission d'un nouvea projet pour l'RFP N°{{$notification->data['alert']['id']}} </p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                   </div>
                   @elseif($notification->data['alert']['type'] ==='Modifier Projet')
                   <div class="icon"> <i data-feather="star"></i></div>
                   <div class="content">
                        <p>le projet N°{{$notification->data['alert']['id']}}  a été modifier</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                   </div>
                   @elseif($notification->data['alert']['type'] ==='Supprimer Projet')
                   <div class="icon"> <i data-feather="star"></i></div>
                   <div class="content">
                        <p>Suppression du projet N°{{$notification->data['alert']['id']}} !</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                   </div>
                   {{--Téléchargement Fichiers--}}
                    @elseif($notification->data['alert']['type'] ==='Download')
                   <div class="icon"> <i data-feather="download"></i></div>
                   <div class="content">
                        <p>Téléchargement terminé !</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                   </div>
                   {{--Canvas--}}
                    @elseif($notification->data['alert']['type'] ==='Canvas')
                   <div class="icon"> <i data-feather="align-justify"></i></div>
                   <div class="content">
                        <p>{{$notification->data['alert']['title']}}</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                   </div>
                @endif
            </a>
         @endforeach


          </div>
          <div class="dropdown-footer d-flex align-items-center justify-content-center">
            <a href="{{ url( 'alerte' ) }}">Voir tout</a>
          </div>
        </div>
      </li>
      <li class="nav-item dropdown nav-profile">
        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="{{ asset('storage/'.Auth::user()->photo) }}" alt="profile">
        </a>
        <div class="dropdown-menu" aria-labelledby="profileDropdown">
          <div class="dropdown-header d-flex flex-column align-items-center">
            <div class="figure mb-3">
              <img src="{{ asset('storage/'.Auth::user()->photo) }}" alt="">
            </div>
            <div class="info text-center">
              <p class="name font-weight-bold mb-0">{{ Auth::user()->name}} {{ Auth::user()->prenom}}</p>
              <p class="email text-muted mb-3">{{ Auth::user()->email}}</p>
            </div>
          </div>
          <div class="dropdown-body">
            <ul class="profile-nav p-0 pt-3">
              <li class="nav-item">
                <a href="{{ url('chercheurs/'.Auth::user()->id)}} " class="nav-link">
                  <i data-feather="user"></i>
                  <span>Mon Profil</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('chercheurs/'.Auth::user()->id.'/edit' )}}" class="nav-link">
                  <i data-feather="edit"></i>
                  <span>Editer Profil</span>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="javascript:;" class="nav-link">
                  <i data-feather="repeat"></i>
                  <span>Switch User</span>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="{{ route('logout') }}"  class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  <i data-feather="log-out"></i>
                  <span>Log Out</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                   @csrf
              </form>


              </li>
            </ul>
          </div>
        </div>
      </li>
    </ul>
  </div>
</nav>
