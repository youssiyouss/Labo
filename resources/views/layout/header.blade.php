<nav class="navbar">
  <a href="#" class="sidebar-toggler">
    <i data-feather="menu"></i>
  </a>
  <div class="navbar-content">
    <form class="search-form">
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <i data-feather="search"></i>
          </div>
        </div>
        <input type="text" class="form-control" id="navbarForm" placeholder="Cherchez ici...">
      </div>
    </form>
    <ul class="navbar-nav">

      <li class="nav-item dropdown nav-apps">
        <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather="grid"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="appsDropdown">
          <div class="dropdown-header d-flex align-items-center justify-content-between">
            <p class="mb-0 font-weight-medium">Web Apps</p>
            <a href="javascript:;" class="text-muted">Edit</a>
          </div>
          <div class="dropdown-body">
            <div class="d-flex align-items-center apps">
              <a href="{{ url('/apps/chat') }}"><i data-feather="message-square" class="icon-lg"></i><p>Chat</p></a>
              <a href="{{ url('/apps/calendar') }}"><i data-feather="calendar" class="icon-lg"></i><p>Calendrier</p></a>
              <a href="{{ url('/email/inbox') }}"><i data-feather="mail" class="icon-lg"></i><p>Email</p></a>
              <a href="{{ url('/general/profile') }}"><i data-feather="instagram" class="icon-lg"></i><p>Profil</p></a>
            </div>
          </div>
          <div class="dropdown-footer d-flex align-items-center justify-content-center">
            <a href="javascript:;">View all</a>
          </div>
        </div>
      </li>
      <li class="nav-item dropdown nav-messages">
        <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i data-feather="mail"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="messageDropdown">
          <div class="dropdown-header d-flex align-items-center justify-content-between">
            <p class="mb-0 font-weight-medium">9 New Messages</p>
            <a href="javascript:;" class="text-muted">Clear all</a>
          </div>
          <div class="dropdown-body">
            <a href="javascript:;" class="dropdown-item">
              <div class="figure">
                <img src="{{ url('https://via.placeholder.com/30x30') }}" alt="userr">
              </div>
              <div class="content">
                <div class="d-flex justify-content-between align-items-center">
                  <p>Leonardo Payne</p>
                  <p class="sub-text text-muted">2 min ago</p>
                </div>
                <p class="sub-text text-muted">Project status</p>
              </div>
            </a>
            <a href="javascript:;" class="dropdown-item">
              <div class="figure">
                <img src="{{ url('https://via.placeholder.com/30x30') }}" alt="userr">
              </div>
              <div class="content">
                <div class="d-flex justify-content-between align-items-center">
                  <p>Carl Henson</p>
                  <p class="sub-text text-muted">30 min ago</p>
                </div>
                <p class="sub-text text-muted">Client meeting</p>
              </div>
            </a>
            <a href="javascript:;" class="dropdown-item">
              <div class="figure">
                <img src="{{ url('https://via.placeholder.com/30x30') }}" alt="userr">
              </div>
              <div class="content">
                <div class="d-flex justify-content-between align-items-center">
                  <p>Jensen Combs</p>
                  <p class="sub-text text-muted">1 hrs ago</p>
                </div>
                <p class="sub-text text-muted">Project updates</p>
              </div>
            </a>
            <a href="javascript:;" class="dropdown-item">
              <div class="figure">
                <img src="{{ url('https://via.placeholder.com/30x30') }}" alt="userr">
              </div>
              <div class="content">
                <div class="d-flex justify-content-between align-items-center">
                  <p>Amiah Burton</p>
                  <p class="sub-text text-muted">2 hrs ago</p>
                </div>
                <p class="sub-text text-muted">Project deadline</p>
              </div>
            </a>
            <a href="javascript:;" class="dropdown-item">
              <div class="figure">
                <img src="{{ url('https://via.placeholder.com/30x30') }}" alt="userr">
              </div>
              <div class="content">
                <div class="d-flex justify-content-between align-items-center">
                  <p>Yaretzi Mayo</p>
                  <p class="sub-text text-muted">5 hr ago</p>
                </div>
                <p class="sub-text text-muted">New record</p>
              </div>
            </a>
          </div>
          <div class="dropdown-footer d-flex align-items-center justify-content-center">
            <a href="javascript:;">View all</a>
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
            <a href="{{url('clearAll')}}" class="text-muted">Clear all</a>
         @endif

          </div>
          <div class="dropdown-body">
         @foreach (auth()->user()->unreadNotifications as $notification)
            <a href="{{ url('readNotification/'.$notification->id) }}" class="dropdown-item">

                @if ($notification->data['alert']['type'] ==="Modification de l'RFP")
                   <div class="icon"> <i class="mdi mdi-table-edit"></i></div>
                    <div class="content">
                        <p>L'RFP numero {{ $notification->data['alert']['id'] }} a été modifier</p>
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
                        <p>L'RFP numero {{ $notification->data['alert']['id'] }} a été supprimer</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                @elseif($notification->data['alert']['type'] ==='echeance')
                  <div class="icon"> <i data-feather="alert-circle"></i></div>
                  <div class="content">
                        <p>La date d'echeance pour l'RFP numero {{ $notification->data['alert']['id'] }} s'approche !</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>
                @elseif($notification->data['alert']['type'] ==='weekend')
                   <div class="icon"> <i class="mdi mdi-emoticon-cool"></i></div>
                   <div class="content">
                        <p>LRIT vous souhaite un bon week-end!</p>
                        <p class="sub-text text-muted"> {{$notification->created_at}}</p>
                    </div>

                @elseif($notification->data['alert']['type'] ==='Nouveau membre')
                   <div class="icon"> <i data-feather="user-plus"></i></div>
                   <div class="content">
                        <p>Un nouveau membre a rejoint LRIT!</p>
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
