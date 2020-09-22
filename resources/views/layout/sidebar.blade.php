@php
  $first = DB::table('projets')
        ->join('taches', 'taches.ID_projet', '=', 'projets.id')
        ->join('delivrables',  'taches.id', '=' ,'delivrables.id_tache')
        ->select('projets.nom', 'projets.id')
        ->where('delivrables.id_respo','=',Auth::user()->id);
  $projets=DB::table('projets')
       ->join('users', 'users.id', '=', 'projets.chefDeGroupe')
       ->select('projets.nom', 'projets.id')
       ->where('users.id','=',Auth::user()->id)
       ->union($first)
       ->get();
@endphp
<nav class="sidebar">
  <div class="sidebar-header">
    <div class="dropdown-header d-flex align-items-center justify-content-between">
    <a href="/home" class="sidebar-brand">
      LRI <span>T</span>
      <img src="\assets\images\logo_dark.png" alt="" height="55" width="59">
    </a>
  </div>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body ps ps--active-y">
    <ul class="nav">
      <li class="nav-item {{ active_class(['/']) }}">
        <a href="{{ url('/home') }}" class="nav-link">
          <i class="link-icon" data-feather="home"></i>
          <span class="link-title">Accueil</span>
        </a>
      </li>

      <li class="nav-item nav-category">Avant projet</li>

      @can('Acces',Auth::user())
      <li class="nav-item {{ active_class(['auth/*']) }}" id="auth">
        <a href="{{ url('chercheurs') }}" class="nav-link">
          <i class="link-icon" data-feather="users"></i>
          <span class="link-title">Chercheurs</span>
        </a>
      </li>
      @endcan

      <li class="nav-item {{ active_class(['apps/calendar']) }}">
        <a href="{{ url('clients') }}" class="nav-link">
          <i class="link-icon" data-feather="phone-outgoing"></i>
          <span class="link-title">Maitre d'ouvrages</span>
        </a>
      </li>

      <li class="nav-item {{ active_class(['apps/calendar']) }}">
        <a href="{{ url('rfps') }}" class="nav-link">
          <i class="link-icon" data-feather="clipboard"></i>
          <span class="link-title">Appels d'offres</span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['advanced-ui/*']) }}">
        <a class="nav-link" data-toggle="collapse" href="#advanced-ui" role="button" aria-expanded="{{ is_active_route(['advanced-ui/*']) }}" aria-controls="advanced-ui">
          <i class="link-icon" data-feather="upload"></i>
          <span class="link-title">Soumissions</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['advanced-ui/*']) }}" id="advanced-ui">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ url('projets') }}" class="nav-link {{ active_class(['advanced-ui/cropper']) }}">Liste des projets</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('') }}" class="nav-link {{ active_class(['advanced-ui/sweet-alert']) }}">Canvas standards</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item nav-category">Gestion des Projets</li>
 @if(count($projets)>0)
      @foreach ($projets as $p)
      <li class="nav-item ">
        <a href="{{ url('taches/MesTaches/'.$p->id) }}" class="nav-link {{ active_class(['forms/basic-elements']) }}">
            <span data-toggle="tooltip" data-placement="left" title="#{{$p->id}} -{{$p->nom}}">* {{$p->nom}} </span>
        </a>
      </li>
      @endforeach
 @elseif(count($projets)==0)
       <li class="nav-item">
          <p class="text-muted">Vous n'avez aucun projet active</p>
       </li>
 @endif

      <li class="nav-item nav-category">web apps</li>
      <li class="nav-item {{ active_class(['email/*']) }}">
        <a class="nav-link" data-toggle="collapse" href="#email" role="button" aria-expanded="{{ is_active_route(['email/*']) }}" aria-controls="email">
          <i class="link-icon" data-feather="mail"></i>
          <span class="link-title">Email</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['email/*']) }}" id="email">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ url('/email/inbox') }}" class="nav-link {{ active_class(['email/inbox']) }}">Inbox</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/email/read') }}" class="nav-link {{ active_class(['email/read']) }}">Read</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('/email/compose') }}" class="nav-link {{ active_class(['email/compose']) }}">Compose</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item {{ active_class(['apps/chat']) }}">
        <a href="{{ url('alerte') }}" class="nav-link">
          <i class="link-icon" data-feather="bell"></i>
          <span class="link-title">Notifications
              @if (auth()->user()->unreadNotifications->count() >=1)
                  <span class="badge badge-pill badge-info">+{{auth()->user()->unreadNotifications->count()}}</span>
              @endif
          </span>
        </a>
      </li>
      <li class="nav-item {{ active_class(['apps/calendar']) }}">
        <a href="{{ url('/apps/calendar') }}" class="nav-link">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Calendar</span>
        </a>
      </li>

    </ul>
  </div>
</nav>
<nav class="settings-sidebar">
  <div class="sidebar-body">
    <a href="#" class="settings-sidebar-toggler">
      <i data-feather="settings"></i>
    </a>
    <div class="theme-wrapper">
      <h6 class="text-muted mb-2">Light Version:</h6>
      <a class="theme-item" href="https://www.nobleui.com/laravel/template/light/">
        <img src="{{ url('assets/images/screenshots/light.jpg') }}" alt="light version">
      </a>
      <h6 class="text-muted mb-2">Dark Version:</h6>
      <a class="theme-item active" href="https://www.nobleui.com/laravel/template/dark/">
        <img src="{{ url('assets/images/screenshots/dark.jpg') }}" alt="light version">
      </a>
    </div>
  </div>
</nav>
