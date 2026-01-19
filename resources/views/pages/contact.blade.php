@extends('layouts.app')

@section('title', 'Contactez-nous')

@section('styles')
    @vite(['resources/css/app.css', 'resources/css/home.css',])
@endsection

@section('content')
    <section class="about-hero"
        style="background: url('{{ asset('assets/images/hero/banniereAllPage.jpg') }}'); background-size: cover; color: white; padding: 100px 0; text-align: center;">
        <div class="container">
            <h1 style="color: #ffffff; font-weight: 600; font-size: 2.5rem; line-height: 1.4;">
                Besoin d'aide ? <span style="color: #f8990b;">Contactez-nous</span>
            </h1>
        </div>
    </section>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="contact-info p-4">
                    <h3 class="mb-4">Informations de Contact</h3>
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                        </div>
                        <div>
                            <p class="mb-0">Lome, Togo</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <i class="fas fa-phone text-primary"></i>
                        </div>
                        <div>
                            <p class="mb-0">+228 92719630/99444263</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <i class="fas fa-envelope text-primary"></i>
                        </div>
                        <div>
                            <p class="mb-0">support@maintendue.tg</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card border-0 shadow-sm p-4 rounded-4">
                    <h3 class="mb-4">Envoyez-nous un message</h3>
                    <form action="#" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nom complet</label>
                                <input type="text" class="form-control rounded-pill px-4" id="name" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control rounded-pill px-4" id="email" name="email" required>
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">Sujet</label>
                                <input type="text" class="form-control rounded-pill px-4" id="subject" name="subject"
                                    required>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control rounded-4 px-4" id="message" name="message" rows="5"
                                    required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2">Envoyer le
                                    message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['resources/js/app.js', 'resources/js/home.js'])
@endsection