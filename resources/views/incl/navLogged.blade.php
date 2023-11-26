
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
            <h1>Moda</h1>
            @if(auth()->user()->role_id == config('constants.roles.client_role'))
              <div onclick="window.location='{{url('/cart')}}'" class="nav-cart" title="Carrito de compra">
                <div>
                  <i class="fa-solid fa-cart-shopping"></i>
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
            <li><a href="{{ url('/dashboard') }}">Página de inicio</a></li>
            @if(auth()->user()->role_id == config('constants.roles.client_role'))
              <li><a href="{{ url('/shipments') }}">Pedidos</a></li>
            @elseif(auth()->user()->role_id == config('constants.roles.agent_role'))
              <li><a href="{{ url('/categories') }}">Categorías</a></li>
              <li><a href="{{ url('/shipments') }}">Pedidos</a></li>
            @elseif(auth()->user()->role_id == config('constants.roles.admin_role'))
              <li><a href="{{ url('/categories') }}">Categorías</a></li>
              <li><a href="{{ url('/shipments') }}">Pedidos</a></li>
              <li><a href="{{ url('/users') }}">Usuarios</a></li>
            @endif
          </div>
        </div>
      </div>
    </nav>