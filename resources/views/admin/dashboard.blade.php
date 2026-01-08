@extends('layouts.admin')

@section('title', 'Tableau de bord Administrateur')

@section('styles')
    @vite(['resources/css/app.css', 'ressources/css/dashboard.css' ,'resources/css/admin.css',])
@endsection

 @stack('styles') 

@section('content')
<div class="page-header">
    <h1>Tableau de bord Administrateur</h1>
    <p>Vue d'ensemble et gestion des opérations de la plateforme MAIN TENDUE.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <span>Utilisateurs Actifs</span>
            <h3>2,450</h3>
            <small class="text-success">+19% le mois dernier</small>
        </div>
        <i class="fas fa-users icon-bg"></i>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <span>Associations Actives</span>
            <h3>120</h3>
            <small class="text-success">+5 nouvelles ce trimestre</small>
        </div>
        <i class="fas fa-shield-alt icon-bg"></i>
    </div>
    </div>

<div class="charts-row">
    <div class="chart-container">
        <h4>Dons par Catégorie</h4>
        <canvas id="donationsChart"></canvas>
    </div>
    <div class="chart-container">
        <h4>Croissance des Utilisateurs Actifs</h4>
        <canvas id="growthChart"></canvas>
    </div>
</div>

<div class="tables-row">
    <div class="table-card">
        <h4>Validation des Associations</h4>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ASSOCIATION</th>
                    <th>DATE D'INSCRIPTION</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Les Mains Tendues</td>
                    <td>2023-10-26</td>
                    <td class="action-btns">
                        <button class="btn-validate" style="padding: 8px 18px;
                            border: 1px solid #e5e7eb;
                            color: #fff;
                            background: green;
                            border-radius: 6px;
                            cursor: pointer;
                            font-weight: 600;">Valider
                        </button>
                        <button class="btn-reject" style=" padding: 8px 18px;
                            background: #ef4444 !important;
                            color: #fff;
                            border: none;
                            border-radius: 6px;
                            cursor: pointer;
                            margin-left: 8px;">Rejeter
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    </div>
@endsection

@section('scripts')
    @vite(['resources/js/app.js', 'resources/js/admin.js'])
@endsection

 @stack('scripts') 