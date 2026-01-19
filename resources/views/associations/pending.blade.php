@extends('layouts.auth')

@section('title', 'En attente de validation')

@section('content')
    <div
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <div class="mx-auto h-24 w-24 flex items-center justify-center rounded-full bg-yellow-100">
                    <svg class="h-12 w-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                    En attente de validation
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ $association->legal_name }}
                </p>
            </div>

            <div class="bg-white shadow-lg rounded-lg p-6 space-y-4">
                @if($association->verification_status === 'pending')
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Votre profil association a été soumis avec succès et est en cours de vérification par notre
                                    équipe.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <h3 class="text-lg font-medium text-gray-900">Prochaines étapes :</h3>
                        <ul class="space-y-2">
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                    </path>
                                </svg>
                                <span class="text-sm text-gray-700">Votre profil a été soumis</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm text-gray-700">Vérification en cours (24-48h)</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="h-6 w-6 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="text-sm text-gray-700">Vous recevrez un email de confirmation</span>
                            </li>
                        </ul>
                    </div>
                @elseif($association->verification_status === 'rejected')
                    <div class="bg-red-50 border-l-4 border-red-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Profil rejeté</h3>
                                <p class="mt-2 text-sm text-red-700">
                                    Votre demande d'association a été rejetée. Veuillez contacter l'administration pour plus
                                    d'informations.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="mailto:{{ config('mail.from.address') }}"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Contacter l'administration
                        </a>
                    </div>
                @endif

                <div class="pt-4 border-t border-gray-200">
                    <p class="text-xs text-gray-500 text-center">
                        </p>
                </div>

                <div class="flex justify-center">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 underline">
                            Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection