@extends('layouts.app')

@section('title', 'À propos de MainTendue')

@section('styles')
    @vite(['resources/css/app.css', 'resources/css/home.css',])
@endsection

@section('content')
<div class="about-page">
    <section class="about-hero" style="background: url('{{ asset('assets/images/hero/banniereAllPage.jpg') }}'); background-size: cover; color: white; padding: 100px 0; text-align: center;">
        <div class="container">
            {{-- <h1 style="font-size: 3rem; margin-bottom: 20px; color: #FFF">Donner, c'est changer une vie</h1> --}}
            <h1 style="color: #ffffff; font-weight: 600; font-size: 2.5rem; line-height: 1.4;">
        Donner, c'est <span style="color: #f8990b;">changer une vie</span>.
    </h1>
            {{-- <p style="font-size: 1.2rem; max-width: 700px; margin: 0 auto;">MainTendue est la première plateforme solidaire au Togo dédiée à la redistribution d'objets essentiels entre particuliers, associations et d'autres personne en difficultés.</p> --}}
            <p style="color: #f8fafc; font-size: 1.3rem; line-height: 1.8; margin-top: 20px; font-weight: 300;">
                Découvrez comment <strong>MainTendue</strong> est devenue la première plateforme solidaire au <span style="color: #f8990b;">Togo</span> dédiée à connecter la générosité des particuliers aux besoins urgents des associations et des personnes en difficulté.
           </p>
        </div>
    </section>

    <section class="mission py-5">
        <div class="container">
            <div class="row align-items-center" style="display: flex; gap: 50px; margin-top: 50px;">
                <div class="col-md-6" style="flex: 1; font-family: 'Poppins', sans-serif; text-align: center; padding: 20px;">
    
    <h2 style="color: #2d3748; margin-bottom: 25px; font-weight: 600; font-size: 2.5rem;">
        Notre Mission
    </h2>

    <p style="line-height: 1.8; color: #4a5568; font-size: 1.1rem; margin-bottom: 20px;">
        Fondée sur des valeurs <span style="color: #3b82f6; font-weight: 600;">humanitaires</span> 
        d'entraide et de <span style="color: #3b82f6; font-weight: 600;">dignité</span>, 
        <strong style="color: #2d3748;">MainTendue</strong> connecte ceux qui ont trop avec ceux qui n'ont pas assez.
    </p>

    <p style="line-height: 1.8; color: #4a5568; font-size: 1.1rem;">
        Nous facilitons le don de <span style="color: #3b82f6;">vêtements</span>, de matériel scolaire, d'alimentation, 
        et d'équipements pour <span style="color: #3b82f6; font-weight: 600;">soutenir</span> les orphelinats 
        et les familles en difficulté à travers tout le <strong style="color: #2d3748;">Togo</strong>.
    </p>

</div>
                <div class="col-md-6" style="flex: 1;">
                    <img src="{{ asset('assets/images/hero/myphoto.png') }}" alt="Mission" style="width: 100%; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                </div>
                <div class="col-md-6" style="flex: 1; font-family: 'Poppins', sans-serif; text-align: center; padding: 20px;">
    
    <h2 style="color: #2d3748; margin-bottom: 25px; font-weight: 600; font-size: 2.5rem;">
        Notre Vision
    </h2>

    <p style="line-height: 1.8; color: #4a5568; font-size: 1.1rem; margin-bottom: 20px;">
        Chez <strong style="color: #2d3748;">MainTendue</strong>, notre vision est de bâtir un écosystème numérique où la 
        <span style="color: #3b82f6; font-weight: 600;">solidarité</span> ne rencontre aucun obstacle. 
        Nous croyons fermement qu'un processus de validation rigoureux est le socle d'un engagement 
        <i style="color: #3b82f6;">social durable</i>.
    </p>

    <p style="line-height: 1.8; color: #4a5568; font-size: 1.1rem;">
        En connectant des donateurs passionnés avec des associations locales 
        <strong style="color: #3b82f6;">scrupuleusement vérifiées</strong>, nous aspirons à transformer chaque intention de 
        <span style="color: #3b82f6; font-weight: 600;">don</span> en un 
        <span style="color: #3b82f6; font-weight: 600;">impact</span> réel, transparent et immédiat pour ceux qui en ont le plus besoin.
    </p>

</div>
            </div>
        </div>
    </section>

    <section class="values py-5" style="background-color: #f7fafc; padding: 60px 0;">
        <div class="container" style="text-align: center;">
            <h2 style="margin-bottom: 40px;">Nos Valeurs</h2>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
                <div style="padding: 30px; background: white; border-radius: 10px;">
                    <i class="fas fa-heart" style="font-size: 2rem; color: #48bb78; margin-bottom: 15px;"></i>
                    <h3>Solidarité</h3>
                    <p>L'entraide est au cœur de chaque action sur notre plateforme.</p>
                </div>
                <div style="padding: 30px; background: white; border-radius: 10px;">
                    <i class="fas fa-check-circle" style="font-size: 2rem; color: #48bb78; margin-bottom: 15px;"></i>
                    <h3>Transparence</h3>
                    <p>Nous vérifions chaque association pour garantir l'impact de vos dons.</p>
                </div>
                <div style="padding: 30px; background: white; border-radius: 10px;">
                    <i class="fas fa-leaf" style="font-size: 2rem; color: #48bb78; margin-bottom: 15px;"></i>
                    <h3>Dignité</h3>
                    <p>Nous encourageons le don d'objets en bon état pour respecter les bénéficiaires.</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
    @vite(['resources/js/app.js', 'resources/js/home.js'])
@endsection