<!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-ice-cream"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><img src="/proyecto/gestion_stock/public/images/logo_rincon.png" width="150px"></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="{{ url('/') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Inicio</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Gestion
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cubes"></i>
          <span>Stock</span>
        </a>

        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            
            <a class="collapse-item" href="{{ url('/productos') }}">Productos</a>
            <a class="collapse-item" href="{{ url('/depositos') }}">Depositos</a>
            <h6 class="collapse-header">Movimientos:</h6>
            <a class="collapse-item" href="{{ url('/movimiento_mp_ingreso_seleccion') }}">Ingresos Insumos</a>
            <a class="collapse-item" href="{{ url('/movimiento_mp_salida_seleccion') }}">Transferencia Insumos</a>
            <a class="collapse-item" href="{{url('/movimiento_descarte_seleccion')}}">Salida Insumos</a>
            <h6 class="collapse-header">Informes</h6>
            <a class="collapse-item" href="cards.html">Tracking de Lotes de productos</a>
            <a class="collapse-item" href="cards.html">Stock a fecha</a>
            <a class="collapse-item" href={{ url('/stock_seleccion_deposito') }}>Stock por deposito</a>
            <a class="collapse-item" href="cards.html">Stock por agrupacion</a>
          
           <h6 class="collapse-header">Valorizacion</h6>
            <a class="collapse-item" href="cards.html">Existencias</a>
            <a class="collapse-item" href="cards.html">Stock Min/Max/Pto Pedido</a>
            <a class="collapse-item" href="cards.html">Costo de Productos</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Ventas Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-shopping-cart"></i>
          <span>Ventas</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Clientes:</h6>
            <a class="collapse-item" href="utilities-color.html">Nomina</a>
            <a class="collapse-item" href="utilities-border.html">Pedidos</a>
            <a class="collapse-item" href="utilities-animation.html">Informes</a>
            
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-cog"></i>
          <span>Produccion</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href={{ url('/lotes_produccion') }}>Lotes</a>
           
          
          </div>
        </div>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->