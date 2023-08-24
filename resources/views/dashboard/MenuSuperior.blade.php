<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
   
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
            class="fas fa-bars"></i></button>
 <!-- Navbar Brand-->
 <a class="navbar-brand ps-3" href="/dashboard">
    <img src="{{ asset('img/logo.png') }}" height="60px;" style="padding-bottom: 3px"></a>
    <ul class="navbar-nav d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a data-bs-toggle="modal" data-bs-target="#closeSession" class="dropdown-item">Logout</a></li>
            </ul>
        </li>
    </ul>
</nav>
<div class="modal fade" id="closeSession" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
            <div class="modal-body">
                <div class="mt-3">
                    <h5 id="editModalLabel">¿Enserio desea cerrar sesión?</h5>
                    <div class="mt-1 d-flex align-center">
                        <form action="/cerrar-sesion" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                Confirmar
                            </button>
                        </form>
                        
                        <a  class="btn btn-secondary mx-2" data-bs-dismiss="modal" tabindex="5">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>
