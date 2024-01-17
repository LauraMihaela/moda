
    <nav>
      <div class="navbar">
        <div class="container nav-container">
            <input class="checkbox" type="checkbox" name="" id="" />
            <div class="hamburger-lines">
              <span class="line line1"></span>
              <span class="line line2"></span>
              <span class="line line3"></span>
            </div>  
          <div class="logo">
            <h1>{{ config('app.name') }}</h1>
            {{-- Languages --}}
            {{-- Iconos obtenidos de https://flagicons.lipis.dev/  --}}
            <li class="nav-item dropdown no-arrow mx-1" id="list-languages">

              <a class="nav-link dropdown-toggle languages-flag" href="javascript:void(0);" 
              id="languagesDropdown" role="button" data-toggle="dropdown" 
              aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-flag"></i>
                <span class=""></span>
              </a>
              <!-- Dropdown - Languages -->
              <div id="dropLanguages" 
              class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" 
              aria-labelledby="languagesDropdown">
                <h6 class="dropdown-header">
                  Seleccione un idioma
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="{{ url('/setLanguage/en') }}">
                  <div class="mr-3">
                    <div class="">
                      <span class="fi fi-us"></span>
                    </div>
                  </div>
                  <div>
                    <span class="font-weight-bold">@lang('messages.en')</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="{{ url('/setLanguage/es') }}">
                  <div class="mr-3">
                    <div class="">
                      <span class="fi fi-es"></span>
                    </div>
                  </div>
                  <div>
                    <span class="font-weight-bold">@lang('messages.es')</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="{{ url('/setLanguage/ro') }}">
                  <div class="mr-3">
                    <div class="">
                      <span class="fi fi-ro"></span>
                    </div>
                  </div>
                  <div>
                    <span class="font-weight-bold">@lang('messages.ro')</span>
                  </div>
                </a>
              </div>


            </li>
            @if(auth()->user()->role_id == config('constants.roles.client_role'))
              {{-- <div onclick="window.location='{{url('/cart')}}'" class="nav-cart" title="@lang('messages.shopping-cart')"> --}}
              <div class="nav-cart" title="@lang('messages.number-of-bought-products')" id="main-number-cart">
                <div>
                  {{-- <i class="fa-solid fa-cart-shopping"></i> --}}
                  <i class="fa-solid fa-basket-shopping"></i>
                </div>
                <div class="elements-cart">
                    <span>0</span>
                </div>
              </div>
            @endif
            <div onclick="window.location='{{url('/profile')}}'" class="nav-icon" title="Perfil de usuario">
              <i class="fa-solid fa-user"></i>
            </div>
            <div onclick="window.location='{{url('/logout')}}'" class="nav-icon" title="Cerrar sesión">
              <i class="fa-solid fa-right-from-bracket"></i>
            </div>

          </div>
          {{-- {{dump(auth()->user()->role_id)}}
          {{dd(config('constants.roles.client_role'))}} --}}

          <div class="menu-items">
            <li><a href="{{ url('/dashboard') }}">@lang('messages.nav-main-dashboard')</a></li>
            @if(auth()->user()->role_id == config('constants.roles.client_role'))
              <li><a href="{{ url('/shipments') }}">@lang('messages.nav-main-shipments')</a></li>
            @elseif(auth()->user()->role_id == config('constants.roles.agent_role'))
              <li><a href="{{ url('/categories') }}">@lang('messages.nav-main-categories')</a></li>
              <li><a href="{{ url('/shipments') }}">@lang('messages.nav-main-shipments')</a></li>
              <li><a href="{{ url('/fashionDesigners') }}">@lang('messages.nav-main-fashion-designers')</a></li>
            @elseif(auth()->user()->role_id == config('constants.roles.admin_role'))
              <li><a href="{{ url('/categories') }}">@lang('messages.nav-main-categories')</a></li>
              <li><a href="{{ url('/shipments') }}">@lang('messages.nav-main-shipments')</a></li>
              <li><a href="{{ url('/fashionDesigners') }}">@lang('messages.nav-main-fashion-designers')</a></li>
              <li><a href="{{ url('/users') }}">@lang('messages.nav-main-users')</a></li>
            @endif
          </div>
        </div>
      </div>
    </nav>