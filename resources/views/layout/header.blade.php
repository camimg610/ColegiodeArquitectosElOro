<section class="full-box nav-lateral">
    <div class="full-box nav-lateral-bg show-nav-lateral"></div>
    <div class="full-box nav-lateral-content">
        <figure class="full-box nav-lateral-avatar">
            <i class="far fa-times-circle show-nav-lateral"></i>
            <img src="{{ asset('assets/logo.png') }}" style="width: 140px; height: auto; margin-bottom: 20px; display: block; margin-left: auto; margin-right: auto;" class="img-fluid" alt="Avatar">
            <figcaption class="roboto-medium text-center">
                COLEGIO DE ARQUITECTOS EL ORO <br><small class="roboto-condensed-light">{{ Auth::user()->Nombre }} {{ Auth::user()->Apellido }}</small>
            </figcaption>
        </figure>
        <div class="full-box nav-lateral-bar"></div>
        <nav class="full-box nav-lateral-menu">
            <ul>
                <li>
                    <a href="{{ route('inicio') }}"><i class="fab fa-dashcube fa-fw"></i> &nbsp; Inicio</a>
                </li>

                <li>
                    <a href="#" class="nav-btn-submenu"><i class="fas fa-users fa-fw"></i> &nbsp; Registro de
                        usuarios <i class="fas fa-chevron-down"></i></a>
                    <ul>

                        <li>
                            <a href="{{ route('usuarios.index') }}"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Usuario</a>
                        </li>
                        <li>
                            <a href="{{ route('roles.index') }}"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Roles</a>
                        </li>
                        <li>
                            <a href="{{ route('permisos.index') }}"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Permisos</a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="#" class="nav-btn-submenu"><i class="fas fa-pallet fa-fw"></i> &nbsp; Inscripciones
                        <i class="fas fa-chevron-down"></i></a>
                    <ul>

                        <li>
                            <a href="{{ route('inscripciones.index') }}"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de
                                Inscripciones</a>
                        </li>

                    </ul>
                </li>

                <li>
                    <a href="#" class="nav-btn-submenu"><i class="fas fa-file-invoice-dollar fa-fw"></i> &nbsp;
                        Eventos <i class="fas fa-chevron-down"></i></a>
                    <ul>

                        <li>
                            <a href="{{ route('eventos.index') }}"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp;
                                Lista de eventos</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#" class="nav-btn-submenu"><i class="fas  fa-user-secret fa-fw"></i> &nbsp;
                        Alquiler <i class="fas fa-chevron-down"></i></a>
                    <ul>

                        <li>
                            <a href="{{ route('alquiler.index') }}"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; Lista de
                                Alquiler</a>
                        </li>

                    </ul>
                </li>

                <!--<li>
                    <a href="company.html"><i class="fas fa-store-alt fa-fw"></i> &nbsp; Empresa</a>
                </li>-->
            </ul>
        </nav>
    </div>
</section>
