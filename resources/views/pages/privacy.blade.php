@extends('layouts.app')

@section('title', 'Politique de Confidentialité')

@section('styles')
    @vite(['resources/css/app.css', 'resources/css/home.css',])
@endsection

@section('content')
<section class="about-hero" style="background: url('{{ asset('assets/images/hero/banniereAllPage.jpg') }}'); background-size: cover; color: white; padding: 100px 0; text-align: center;">
    

<div class="container py-5">
    <div class="rows justify-content-center">
        <div class="col-md-10">

             {{-- <h1 class="mb-4">Politique de Confidentialité</h1> 
            <h1 style="color: #ffffff; font-weight: 600; font-size: 2.5rem; line-height: 1.4;">
        Faciliter le don pour <span style="color: #f8990b;">changer des vies</span>.
    </h1> 
            <p class="text-muted">Dernière mise à jour : {{ date('d/m/Y') }}</p> --}}

            <section class="mb-2">
                <h3>1. Collecte des données</h3>
                <p>Sur MainTendue, nous collectons des informations lorsque vous vous inscrivez, publiez un don ou contactez une association. Les données incluent votre nom, email et numéro de téléphone.</p>
            </section>

            <section class="mb-2">
                <h3>2. Utilisation des informations</h3>
                <p>Toutes les informations que nous recueillons auprès de vous peuvent être utilisées pour :</p>
                <ul>
                    <li>Personnaliser votre expérience et répondre à vos besoins individuels.</li>
                    <li>Améliorer notre plateforme de solidarité.</li>
                    <li>Vous mettre en relation pour la remise des dons.</li>
                </ul>
            </section>

            <section class="mb-2">
                <h3>3. Protection des données</h3>
                <p>Nous mettons en œuvre une variété de mesures de sécurité pour préserver la sécurité de vos informations personnelles.</p>
            </section>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @vite(['resources/js/app.js', 'resources/js/home.js'])
@endsection