<!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" >

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html" style="margin-top: 20px">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-ice-cream" style="color:#c6aa6a"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><img src="/proyecto/gestion_stock/public/images/logo_rincon.png" width="150px"></div>
      </a>

      <!-- Divider -->
     

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active" style="margin-top: 30px">
        <a class="nav-link" href="{{ url('/') }}">
          <i class="fas fa-fw fa-tachometer-alt" ></i>
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
            <h5 class="collapse-header">GESTION</h5>
            <a class="collapse-item" href="{{ url('/productos') }}">Productos Terminados</a>
            <a class="collapse-item" href="{{ url('/insumos') }}">Insumos y M. Primas</a>
             <h5 class="collapse-header">Depositos</h5>
            <a class="collapse-item" href="{{ url('/depositos') }}">Gestión de Depósitos</a>
            <h5 class="collapse-header">Movimientos:</h5>
            <a class="collapse-item" href="{{ url('/movimiento_mp_ingreso_seleccion') }}">Ingresos </a>
            <a class="collapse-item" href="{{ url('/movimiento_mp_salida_seleccion') }}">Transferencias</a>
            <a class="collapse-item" href="{{url('/movimiento_descarte_seleccion')}}">Salidas</a>
            <h6 class="collapse-header">Informes</h6>
             <a class="collapse-item" href={{ url('/stock_seleccion_deposito') }}>Stock por deposito</a>
             <a class="collapse-item" href={{ url('/saldos_a_fecha') }}>Stock a fecha</a>
             <a class="collapse-item" href={{ url('/stock_por_agrupacion_seleccion')}}>Stock por agrupacion</a>
            <a class="collapse-item" href={{ url('/control_vencimientos_seleccion') }}>Control Vencimientos</a>

           <h6 class="collapse-header">Valorizacion</h6>
            <a class="collapse-item" href="{{ url('/stock_valorizado') }}">Existencias</a>
            <a class="collapse-item" href="{{ url('/stock_punto_pedido') }}">Stock Min/Max/Pto Pedido</a>
            <a class="collapse-item" href="{{ url('/productos_sin_stock_seleccion') }}">Productos sin stock</a>
     
          </div>
        </div>
      </li>



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

      <!-- Nav Item - Ventas Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-shopping-cart"></i>
          <span>Ventas</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Clientes:</h6>
            <a class="collapse-item" href={{ url('/clientes')}}>Nomina</a>
            <h5 class="collapse-header">Listas de Precios</h5>
            <a class="collapse-item" href="{{ url('/listas') }}">Listas de Precios</a>
            <a class="collapse-item" href="utilities-border.html">Actualización</a>
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