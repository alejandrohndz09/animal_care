<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Inicio</div>
                <a class="nav-link" href="/">
                    <div class="sb-nav-link-icon"><i class="fas fa-home" ></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Menu</div>
               
                <a class="nav-link" href="/animal">
                    <div class="sb-nav-link-icon"><i class="fas fa-dog" ></i></div>
                    Animales
                </a>
                <a class="nav-link" href="/persona">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-invoice" ></i></div>
                    Expedientes
                </a>
                <a class="nav-link" href="">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-envelopes-bulk" ></i></div>
                    Trámites
                </a>
                
                <a class="nav-link" href="/albergue">
                    <div class="sb-nav-link-icon"><i class="fas fa-tents" ></i></div>
                    Albergue
                </a>
                
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                   aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-folder"></i>
                    </div>
                    Otras Gestiones
                    <div class="sb-sidenav-collapse-arrow"><i 
                                                              class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link" href="/especie">
                            <div class="sb-nav-link-icon"><i class="fas fa-cat" ></i></div>
                            
                            Especie
                        </a>
                        <a class="nav-link" href="/vacuna">
                            <div class="sb-nav-link-icon"><i class="fas fa-syringe"></i></div>
                            Vacunas
                        </a>
                        <a class="nav-link" href="/patologia">
                            <div class="sb-nav-link-icon"> <i class="fas fa-stethoscope"></i></div>
                            Patologias
                        </a>
                    </nav>
                </div>
                <div class="sb-sidenav-menu-heading">Otros</div>
                <a class="nav-link" href="/miembro">
                    <div class="sb-nav-link-icon"><i class="fas fa-user" ></i></div>
                    Miembros
                </a>
                <a class="nav-link" href="/Inventario">
                    <div class="sb-nav-link-icon"><i class="fas fa-warehouse" ></i></div>
                    Inventario
                </a>
                

               
               
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Bienvenido</div>
            {{ session()->has('usuario') ? session()->get('usuario')->persona->nombre . ' ' . session()->get('usuario')->persona->Apellido : 'unknown' }}
        </div>
    </nav>
</div>
