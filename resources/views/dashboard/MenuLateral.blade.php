<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Inicio</div>
                <a class="nav-link" href="/home">
                    <div class="sb-nav-link-icon"><i class="fas fa-home" ></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Menu</div>
                <a class="nav-link" href="/animal">
                    <div class="sb-nav-link-icon"><i class="fas fa-dog" ></i></div>
                    Mascotas
                </a>
                <a class="nav-link" href="/persona">
                    <div class="sb-nav-link-icon"><i class="fas fa-file-invoice" ></i></div>
                    Expedientes
                </a>
                <a class="nav-link" href="">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-envelopes-bulk" ></i></div>
                    Trámites
                </a>
                <a class="nav-link" href="/Inventario">
                    <div class="sb-nav-link-icon"><i class="fas fa-warehouse" ></i></div>
                    Inventario
                </a>

                <a class="nav-link" href="/miembro">
                    <div class="sb-nav-link-icon"><i class="fas fa-user" ></i></div>
                    Miembro
                </a>
                <a class="nav-link" href="/albergue">
                    <div class="sb-nav-link-icon"><i class="fas fa-tents" ></i></div>
                    Albergue
                </a>
                
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                   aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-folder"></i>
                    </div>
                    Formularios
                    <div class="sb-sidenav-collapse-arrow"><i 
                                                              class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo"
                    data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link" href="/form1" data-toggle="modal" data-target="#generarcierre">
                            <div class="sb-nav-link-icon"><i class="fas fa-file"></i></div>
                            Prototipo 1
                        </a>
                        <a class="nav-link" href="/form2">
                            <div class="sb-nav-link-icon"><i 
                                    class="fas fa-file"></i></div>
                                    Prototipo 2
                        </a>
                        <a class="nav-link" href="/form3">
                            <div class="sb-nav-link-icon"><i 
                                    class="fas fa-file"></i></div>
                                    Prototipo 3
                        </a>
                    </nav>
                </div>
               
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Bienvenido</div>
            {{ session()->has('usuario') ? session()->get('usuario')->persona->nombre . ' ' . session()->get('usuario')->persona->Apellido : 'unknown' }}
        </div>
    </nav>
</div>
