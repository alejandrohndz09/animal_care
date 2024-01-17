<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">


    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="/">
        <div style="display: flex; font-size: 24px;  align-items: center; gap: 5px; ">
            <img src="{{ asset('img/logo.png') }}" height="60px;" style="padding-bottom: 3px">
            <strong style="font-family: 'Raleway','More Sugar','Dosis',Arial, sans-serif;">AnimalCare</strong>
        </div>
    </a>
    <!-- Sidebar Toggle-->

    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
            class="fas fa-bars"></i></button>





    <ul class="navbar-nav d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user fa-fw"></i> {{ Auth::user()->usuario }}</a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a data-bs-toggle="modal" data-bs-target="#closeSession" class="dropdown-item">
               <i class="fas fa-arrow-right-from-bracket" style="margin-right: 3px; color: #6067eb"></i>
                Cerrar Sesión</a>
                </li>
            </ul>
        </li>
    </ul>


</nav>

<div class="modal fade" id="closeSession" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <form action="/logout" method="get">
                <div class="modal-header">
                    <h5 style="margin-left: auto; margin-right: auto;">Aviso</h5>
                </div>
                <div class="modal-body text-center">
                    <div style="margin: 0; display: flex; align-items: center; justify-content: center ">
                        <i class="fas fa-warning" style="margin-right: 3px; color:#867596; font-size: 18px "></i>
                        ¿Realmente desea cerrar sesión?
                    </div>

                </div>
                <div class="modal-footer" style="display:flex; justify-content: center; gap:40px">
                    <button id="confirmar" type="submit" class="button button-pri">
                        <i class="svg-icon fas fa-check"></i>
                        <span class="lable">Confirmar</span></button>
                    <button type="button" class="button button-red" data-bs-dismiss="modal"> <i
                            class="svg-icon fas fa-xmark"></i>
                        <span class="lable">Cancelar</span> </button>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
