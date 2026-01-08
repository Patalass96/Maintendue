@extends('layouts.app')

@section('title', 'Conditions Générales d\'Utilisation')

@section('styles')
    @vite(['resources/css/app.css', 'resources/css/home.css',])
@endsection
@section('content')
<div class="container py-5">
    <div class="rows justify-content-center">
        <div class="col-md-10">
            <h1 class="mb-4">Conditions Générales d'Utilisation (CGU)</h1>
            <p class="text-muted">En vigueur au : {{ date('d/m/Y') }}</p>

            <div class="terms-content shadow-sm p-4 bg-white rounded">
                <section class="mb-5">
                    <h3>1. Objet de la plateforme</h3>
                    <p>MainTendue est une plateforme de mise en relation destinée à faciliter le don d'objets entre particuliers et associations caritatives au Togo.</p>
                </section>

                <section class="mb-5">
                    <h3>2. Engagement du donateur</h3>
                    <p>En publiant un don, l'utilisateur s'engage à fournir des objets propres, fonctionnels et respectant la dignité des bénéficiaires.</p>
                </section>

                <section class="mb-5">
                    <h3>3. Engagement des associations</h3>
                    <p>Les associations inscrites s'engagent à utiliser les dons reçus exclusivement dans le cadre de leurs activités sociales et humanitaires.</p>
                </section>

                <section class="mb-5">
                    <h3>4. Responsabilité</h3>
                    <p>MainTendue décline toute responsabilité en cas de litige entre un donateur et une association lors de la remise physique du don.</p>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @vite(['resources/js/app.js', 'resources/js/home.js'])
@endsection