@extends('layouts.association')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-semibold mb-6">Créer une association</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('associations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 bg-white p-6 rounded shadow-sm">
        @csrf

        <div>
            <label for="name" class="block font-medium">Nom de l'association</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required
                class="w-full mt-1 p-2 border rounded @error('name') border-red-500 @enderror">
            @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block font-medium">Email de contact</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                class="w-full mt-1 p-2 border rounded @error('email') border-red-500 @enderror">
            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="phone" class="block font-medium">Téléphone</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                    class="w-full mt-1 p-2 border rounded @error('phone') border-red-500 @enderror">
                @error('phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="is_active" class="block font-medium">Activer maintenant</label>
                <select id="is_active" name="is_active" class="w-full mt-1 p-2 border rounded">
                    <option value="0" {{ old('is_active') === '0' ? 'selected' : '' }}>Non</option>
                    <option value="1" {{ old('is_active') === '1' ? 'selected' : '' }}>Oui</option>
                </select>
            </div>
        </div>

        <div>
            <label for="address" class="block font-medium">Adresse</label>
            <input id="address" name="address" type="text" value="{{ old('address') }}"
                class="w-full mt-1 p-2 border rounded @error('address') border-red-500 @enderror">
            @error('address') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block font-medium">Description</label>
            <textarea id="description" name="description" rows="4"
                class="w-full mt-1 p-2 border rounded @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="document" class="block font-medium">Pièce justificative (PDF / image)</label>
            <input id="document" name="document" type="file" accept=".pdf,image/*"
                class="w-full mt-1 p-1 @error('document') border-red-500 @enderror">
            @error('document') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            <p class="text-sm text-gray-500 mt-1">Facultatif — fournir un document d'enregistrement ou une preuve d'activité.</p>
        </div>

        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('associations.index') }}" class="px-4 py-2 border rounded text-gray-700">Annuler</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Créer l'association</button>
        </div>
    </form>
</div>
@endsection