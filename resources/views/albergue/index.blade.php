@extends('layouts.master')

@section('styles')
    
@endsection

@section('content')
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4 py-4">
                <div style="width: 100%; display: flex; align-items: center; justify-content: space-between; gap:20px">

                </div>

                <div class="row mt-3">
                    <div class="col-xl-12">
                        <div
                            style="width:100%; display: flex;  justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <h1>Albergues </h1>
                            <input id="searchInput" class="inputField card" style="width: 50% " autocomplete="off"
                                placeholder="🔍︎ Buscar" type="search">
                        </div>

                            <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-3">
                                <div class="card shadow p-3 mb-5 bg-body rounded" style="max-width: 300px;">
                                    <div class="row g-0">
                                        <div class="col-md-3 d-flex align-items-center">
                                            <span class="font-weight-bold"><i class="fa fa-weight-scale"
                                                    style="color: #f5a623; font-size: 55px"></i></span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="card-body">
                                                <h5 class="card-title fw-bold">Medidor No. 1</h5>
                                                <p class="card-text mb-0 fw-semibold">CANTON EL ZAPOTE</p>
                                                <p class="card-text fs-6"><small class="text-muted">
                                                        HOLA
                                                    </small></p>
                                            </div>
                                            <a href="" class="stretched-link"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
@endsection
