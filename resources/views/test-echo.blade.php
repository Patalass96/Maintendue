@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Test Laravel Echo + Reverb</h2>

    <div id="echo-status" class="alert alert-info">
        Connexion WebSocket en cours...
    </div>

    <button onclick="testEcho()" class="btn btn-primary">
        Tester la connexion
    </button>

    <div id="echo-messages" class="mt-3"></div>
</div>

<script>
    // Vérifier si Echo est chargé
    if (typeof window.Echo !== 'undefined') {
        document.getElementById('echo-status').className = 'alert alert-success';
        document.getElementById('echo-status').innerHTML = '✅ Laravel Echo est chargé !';

        // S'abonner à un canal de test
        window.Echo.channel('test-channel')
            .listen('TestEvent', (e) => {
                console.log('Événement reçu:', e);
            });
    } else {
        document.getElementById('echo-status').className = 'alert alert-danger';
        document.getElementById('echo-status').innerHTML = '❌ Laravel Echo NON chargé !';
    }

    function testEcho() {
        if (window.Echo) {
            const messages = document.getElementById('echo-messages');
            messages.innerHTML += '<div class="alert alert-success">✅ Echo fonctionne !</div>';
        }
    }
</script>
@endsection
