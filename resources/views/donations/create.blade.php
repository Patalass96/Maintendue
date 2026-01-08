@extends('layouts.donateur')

@section('title', 'Publier un don ')

@section('content')
<div class="publish-donation">
    <h2>Publier un nouveau don</h2>
    <p class="subtitle">Remplissez les détails ci-dessous pour proposer un don.</p>

<form action="{{ route('donations.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label>Catégorie de don</label>
        <select name="category_id" class="form-input">
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="row">
        <input type="text" name="size" placeholder="Ex: M, L, 38">
        <select name="gender">
            <option value="unisex">Sélectionnez un genre</option>
            <option value="kids">Enfant</option>
        </select>
    </div>

    <div class="radio-group">
        <input type="radio" name="delivery_method" value="collection_point" checked> Point de collecte
        <input type="radio" name="delivery_method" value="direct"> Remise directe
    </div>
</form>