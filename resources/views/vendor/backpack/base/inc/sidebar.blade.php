@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="{{ (Auth::user()->photo)?url(Storage::url(Auth::user()->photo)):'https://placehold.it/160x160/00a65a/ffffff/&text='.mb_substr(Auth::user()->name, 0, 1) }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->fullname }}</p>
            <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          @if(Auth::user()->isAdmin())
            <li class="header">{{ trans('backpack::base.administration') }}</li>
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/admins') }}"><i class="fa fa-user-secret"></i> <span>Administradores</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/users') }}"><i class="fa fa-user"></i> <span>Usuarios</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/tempusers') }}"><i class="fa fa-user"></i> <span>Usuarios Externos</span></a></li>

            <li class="treeview">
                <a href="#"><i class="fa fa-file-text"></i><span>Parametrizacion</span></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/professions') }}"><i class="fa fa-suitcase"></i> <span>Profesiones</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/companies') }}"><i class="fa fa-building-o"></i> <span>Empresas</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/educations') }}"><i class="fa fa-university"></i> <span>Educación</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/languages') }}"><i class="fa fa-language"></i> <span>Idiomas</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/skills') }}"><i class="fa fa-circle-o"></i> <span>Skills</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix','admin').'/countries')  }}"><i class="fa fa-map-marker"></i><span>Paises</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix','admin').'/departments')  }}"><i class="fa fa-map-marker"></i><span>Departamentos</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix','admin').'/cities')  }}"><i class="fa fa-map-marker"></i><span>Ciudades</span></a></li>
                    <li></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix','admin').'/eventtypes')  }}"><i class="fa"></i><span>Tipos de eventos</span></a></li>

                </ul>
            </li>

              <li class="treeview">
                  <a href="#"><i class="fa fa-file-text-o"></i>Contratación</a>
                  <ul class="treeview-menu">
                      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/contracts/find') }}"><i class="fa fa-search"></i> <span>Buscar profesionales</span></a></li>
                      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/contracts') }}"><i class="fa"></i> <span>Administrar contratos</span></a></li>
                  </ul>
              </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-file-text-o"></i>Eventos</a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/events') }}"><i class="fa fa-calendar"></i> <span>Administrar eventos</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/birthdays') }}"><i class="fa fa-birthday-cake"></i> <span>Cumpleaños</span></a></li>
                </ul>
            </li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/visits') }}"><i class="fa fa-circle-o"></i>Visitas</a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-check-square"></i>Control político</a>
                <ul class="treeview-menu">
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/electiontypes') }}"><i class="fa fa-check-circle-o"></i> <span>Tipos de candidaturas</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/election-support-types') }}"><i class="fa fa-check-circle-o"></i> <span>Tipos de apoyos</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/elections') }}"><i class="fa fa-check-circle"></i> <span>Configurar comicios</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/candidates') }}"><i class="fa fa-users"></i> <span>Candidatos</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/candidacies') }}"><i class="fa fa-list-ol"></i> <span>Candidaturas</span></a></li>
                    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/election-supports') }}"><i class="fa fa-random"></i> <span>Apoyo electoral</span></a></li>

                </ul>
            </li>

            @endif

          @if(!Auth::user()->isAdmin())
              @if(Auth::user()->curriculum)
                      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/curriculum/'.Auth::user()->curriculum->id) }}"><i class="fa fa-file-text-o"></i><span>Curriculum</span></a></li>
                      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/curriculum/'.Auth::user()->curriculum->id.'/edit' ) }}"><i class="fa fa-file-text-o"></i> <span>Editar Curriculum</span></a></li>

              @else
                      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/curriculum/create') }}"><i class="fa fa-file-text-o"></i> <span>Crear Curriculum</span></a></li>
              @endif
          @endif
          <!-- ======================================= -->
              <li class="header">{{ trans('backpack::base.user') }}</li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/profile/'.Auth::user()->id.'/edit') }}"><i class="fa fa-cog"></i> <span>Editar cuenta</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li>


        </ul>

      </section>
      <!-- /.sidebar -->
    </aside>
@endif
