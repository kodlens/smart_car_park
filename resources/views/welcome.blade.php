@extends('layouts.app')

@section('content')


<div class="container is-max-desktop">
    <section class="section">
        <div class="is-flex justify-content-center is-flex-direction-column">
            <div class="welcome-text mb-2">
                <p class="title">
                    EnSys
                </p>
                <p class="subtitle">
                    Tangub City National High School - Senior High School Enrollment System
                </p>
            </div>

            <div class="model-img" style="margin: auto;">
                <img src="/img/front.jpg" />
            </div>


        </div>
        <div class="buttons is-centered">
            <b-button class="is-info"
                  label="REGISTER HERE"
                  icon-right="home"
                tag="a"
                href="/registration"></b-button>
        </div>

    </section>
</div>
    
@endsection
