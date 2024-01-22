@extends('layouts.master')


@section('content')
    <div id="layoutSidenav_content">

        <div style="display:flex;align-content: center; height: 80vh;justify-content: center">

            <div class="col-xl-12"
                style="display: flex; font-size: 46px; color:#000; align-items: center; justify-content: center; gap: 5px; ">
                <img src="{{ asset('img/logo.png') }}" height="120px;" style="padding-bottom: 3px">
                <strong style="font-family: 'Raleway','More Sugar','Dosis',Arial, sans-serif;">AnimalCare</strong>
            </div>
        </div>


    </div>

    <div class="floating-button" data-toggle="modal" data-target="#ayudaDash" data-bs-pp="tooltip" data-bs-placement="top"
        title="Ayuda">
        <span>?</span>
    </div>
@endsection
