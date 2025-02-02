<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Inicio</div>
                <a class="nav-link" href="/">
                    <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Menu</div>

                <a class="nav-link" href="/animal">
                    <div class="sb-nav-link-icon"><i class="fas fa-dog"></i></div>
                    Animales
                </a>
                <a class="nav-link" href="/expediente">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-invoice"></i></div>
                    Expedientes
                </a>
                <a class="nav-link" href="/adopcion">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-envelopes-bulk"></i></div>
                    Adopciones
                </a>

                <a class="nav-link" href="/albergue">
                    <div class="sb-nav-link-icon"><i class="fas fa-tents"></i></div>
                    Albergue
                </a>
                @if(Auth::user()->rol==1)
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                    aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-folder"></i>
                    </div>
                    Otras Gestiones
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link" href="/especie">
                            <div class="sb-nav-link-icon"><i class="fas fa-cat"></i></div>
                            Especies
                        </a>
                        <a class="nav-link" href="/raza">
                            <div class="sb-nav-link-icon"><i class="fas fa-paw"></i></div>
                            Razas
                        </a>
                        <a class="nav-link" href="/vacuna">
                            <div class="sb-nav-link-icon"><i class="fas fa-syringe"></i></div>
                            Vacunas
                        </a>
                        <a class="nav-link" href="/patologia">
                            <div class="sb-nav-link-icon"> <i class="fas fa-stethoscope"></i></div>
                            Patologías
                        </a>
                    </nav>
                </div>
                @endif
                <div class="sb-sidenav-menu-heading">Otros</div>
                @if(Auth::user()->rol==1)
                <a class="nav-link" href="/miembro">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Miembros
                </a>
                @endif
                <a class="nav-link" href="/inventario">
                    <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>
                    Inventario
                </a>




            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small"><b>Bienvenido</b></div>
            <div style="margin: 0; display: flex; align-items: flex-start;width:auto; color:#e2e3fc; font-size: 15px ">
                
                <p style="margin: 0">
                    <i class="fas fa-user" style="margin-right:3px; "></i>
                    <b>{{ Auth::user()->usuario }}</b><br>
                    {{ Auth::user()->rol == 1 ? '(administrador)' : '(usuario)' }}
                </p>
            </div>

        </div>
    </nav>
</div>
