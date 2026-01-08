@extends('layouts.app')

@section('title', 'Mentions Légales')

@section('styles')
    @vite(['resources/css/app.css', 'resources/css/home.css',])
@endsection

@section('content')
<section class="about-hero" style="background: url('{{ asset('assets/images/hero/banniereAllPage.jpg') }}'); background-size: cover; color: white; padding: 100px 0; text-align: center;">
        <div class="container">
            <h1 style="font-size: 3rem; margin-bottom: 20px; color: #FFF">Mentions Légales</h1>
<h1 style="font-size: 3.5rem; margin-bottom: 20px; color: #FFF; font-weight: 700;">
            Confiance et <span style="color: #f8990b;">Transparence</span>
        </h1>
        <p style="font-size: 1.3rem; max-width: 800px; margin: 0 auto; line-height: 1.6; color: #f8fafc;">
            La sécurité de vos données est le socle de l'entraide sur <strong>MainTendue</strong>. Découvrez notre cadre légal pour une solidarité sécurisée au <span style="color: #3b82f6;">Togo</span>.
        </p>


        </div>
    </section>
<div class="container py-5">
    <div class="rows justify-content-center">
        <div class="col-md-10">
            <h1 class="mb-4">Mentions Légales</h1>
            
            <div class="mentions-content shadow-sm p-4 bg-white rounded">
                <section class="mb-5">
                    <h3>1. Éditeur du site</h3>
                    <p>Le site <strong>MainTendue</strong> est édité par l'organisation MainTendue Togo.</p>
                    <p>Siège social : Rue de la Solidarité, Lomé, Togo.</p>
                    <p>Email : contact@maintendue.tg.</p>
                    <p>Téléphone : +228 92 71 96 30/99444263.</p>
                </section>

                <section class="mb-5">
                    <h3>2. Directrice de la publication</h3>
                    <p>Le responsable de la publication est l'équipe de coordination de MainTendue.</p>
                </section>

                <section class="mb-5">
                    <h3>3. Hébergement</h3>
                    <p>Ce site est hébergé par [Nom de ton hébergeur, ex: Hostinger ou local], dont le siège social est situé à [Adresse hébergeur].</p>
                </section>

                <section class="mb-5">
                    <h3>4. Propriété intellectuelle</h3>
                    <p>Le logo, les textes et les éléments graphiques sont la propriété exclusive de MainTendue. Toute reproduction est interdite sans accord préalable.</p>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    @vite(['resources/js/app.js', 'resources/js/home.js',])
@endsection