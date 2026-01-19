@extends('layouts.admin')

@section('title', 'Modifier Utilisateur')

@section('content')
    <div class="container py-4">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white py-3 border-0">
                <h4 class="mb-0 fw-bold"><i class="fas fa-user-edit me-2"></i>Modifier l'utilisateur</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstname" class="form-label">Prénom</label>
                            <input type="text" name="firstname" id="firstName" class="form-control"
                                value="{{ $user->firstname ?? '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastname" class="form-label">Nom</label>
                            <input type="text" name="lastname" id="lastName" class="form-control"
                                value="{{ $user->lastname ?? '' }}">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="phone" class="form-label">Téléphone</label>
                            <input type="text" name="phone" id="phone" class="form-control"
                                value="{{ $user->phone ?? '' }}">
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary rounded-pill">Annuler</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 ms-2">Enregistrer les
                            modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection