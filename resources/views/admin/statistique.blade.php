@extends('layouts.admin')

@section('title', 'Statistiques')
@section('page-title', 'Statistiques Globales')

@section('content')
<div class="statistics-container">
    
    <!-- KPI Principaux -->
    <div class="main-kpi mb-30">
        <div class="kpi-grid">
            <div class="kpi-card primary">
                <div class="kpi-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="kpi-content">
                    <h3>2,450</h3>
                    <p>Utilisateurs Actifs</p>
                    <div class="kpi-trend up">
                        <i class="fas fa-arrow-up"></i>
                        <span>+19% ce mois</span>
                    </div>
                </div>
            </div>
            
            <div class="kpi-card success">
                <div class="kpi-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <div class="kpi-content">
                    <h3>120</h3>
                    <p>Associations Actives</p>
                    <div class="kpi-trend up">
                        <i class="fas fa-plus"></i>
                        <span>+5 nouvelles</span>
                    </div>
                </div>
            </div>
            
            <div class="kpi-card warning">
                <div class="kpi-icon">
                    <i class="fas fa-donate"></i>
                </div>
                <div class="kpi-content">
                    <h3>15.240 FCFA</h3>
                    <p>Dons Collectés</p>
                    <div class="kpi-trend up">
                        <i class="fas fa-arrow-up"></i>
                        <span>+32% ce mois</span>
                    </div>
                </div>
            </div>
            
            <div class="kpi-card danger">
                <div class="kpi-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <div class="kpi-content">
                    <h3>845</h3>
                    <p>Transactions</p>
                    <div class="kpi-trend down">
                        <i class="fas fa-arrow-down"></i>
                        <span>-3% ce mois</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres de période -->
    <div class="period-filters mb-30">
        <div class="filters-header">
            <h4><i class="fas fa-calendar-alt"></i> Période d'analyse</h4>
        </div>
        <div class="filters-body">
            <div class="period-buttons">
                <button class="period-btn active" data-period="today">Aujourd'hui</button>
                <button class="period-btn" data-period="week">7 derniers jours</button>
                <button class="period-btn" data-period="month">30 derniers jours</button>
                <button class="period-btn" data-period="quarter">Trimestre</button>
                <button class="period-btn" data-period="year">Année</button>
                <button class="period-btn" data-period="custom">Personnalisé</button>
            </div>
            
            <div class="custom-period" id="customPeriod" style="display: none;">
                <div class="date-inputs">
                    <input type="date" class="form-control" id="startDate">
                    <span>à</span>
                    <input type="date" class="form-control" id="endDate">
                    <button class="btn btn-primary" id="applyCustom">
                        <i class="fas fa-check"></i>
                        Appliquer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques principaux -->
    <div class="main-charts mb-30">
        <div class="chart-row">
            <div class="chart-card">
                <div class="chart-header">
                    <h4><i class="fas fa-chart-line"></i> Croissance des utilisateurs</h4>
                    <select class="chart-select">
                        <option value="monthly">Par mois</option>
                        <option value="weekly">Par semaine</option>
                        <option value="daily">Par jour</option>
                    </select>
                </div>
                <div class="chart-body">
                    <canvas id="growthChart"></canvas>
                </div>
            </div>
            
            <div class="chart-card">
                <div class="chart-header">
                    <h4><i class="fas fa-chart-pie"></i> Dons par catégorie</h4>
                    <select class="chart-select">
                        <option value="all">Toutes catégories</option>
                        <option value="education">Éducation</option>
                        <option value="health">Santé</option>
                        <option value="environment">Environnement</option>
                    </select>
                </div>
                <div class="chart-body">
                    <canvas id="donationsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques détaillées -->
    <div class="detailed-stats mb-30">
        <div class="stats-tabs">
            <button class="stats-tab active" data-tab="activity">
                <i class="fas fa-chart-bar"></i>
                Activité
            </button>
            <button class="stats-tab" data-tab="geography">
                <i class="fas fa-map"></i>
                Géolocalisation
            </button>
            <button class="stats-tab" data-tab="financial">
                <i class="fas fa-money-bill-wave"></i>
                Financier
            </button>
            <button class="stats-tab" data-tab="users">
                <i class="fas fa-user-chart"></i>
                Utilisateurs
            </button>
        </div>
        
        <div class="stats-content">
            <!-- Onglet Activité -->
            <div class="tab-content active" id="activity-tab">
                <div class="activity-grid">
                    <div class="activity-card">
                        <h5>Activité quotidienne</h5>
                        <div class="activity-chart">
                            <canvas id="dailyActivity"></canvas>
                        </div>
                    </div>
                    
                    <div class="activity-card">
                        <h5>Heures de pointe</h5>
                        <div class="peak-hours">
                            <div class="hour-item">
                                <span>14h-15h</span>
                                <div class="hour-bar">
                                    <div class="bar-fill" style="width: 85%"></div>
                                </div>
                                <span class="hour-percent">85%</span>
                            </div>
                            <div class="hour-item">
                                <span>19h-20h</span>
                                <div class="hour-bar">
                                    <div class="bar-fill" style="width: 72%"></div>
                                </div>
                                <span class="hour-percent">72%</span>
                            </div>
                            <div class="hour-item">
                                <span>12h-13h</span>
                                <div class="hour-bar">
                                    <div class="bar-fill" style="width: 65%"></div>
                                </div>
                                <span class="hour-percent">65%</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="activity-card">
                        <h5>Actions les plus fréquentes</h5>
                        <div class="actions-list">
                            <div class="action-item">
                                <i class="fas fa-search"></i>
                                <div>
                                    <strong>Recherche d'associations</strong>
                                    <small>2,450 fois/jour</small>
                                </div>
                            </div>
                            <div class="action-item">
                                <i class="fas fa-eye"></i>
                                <div>
                                    <strong>Consultation de profils</strong>
                                    <small>1,890 fois/jour</small>
                                </div>
                            </div>
                            <div class="action-item">
                                <i class="fas fa-donate"></i>
                                <div>
                                    <strong>Dons effectués</strong>
                                    <small>845 fois/jour</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Onglet Géographie -->
            <div class="tab-content" id="geography-tab">
                <div class="geography-grid">
                    <div class="geo-card">
                        <h5>Répartition par région</h5>
                        <div class="regions-map">
                            <!-- Carte simplifiée -->
                            <div class="map-container">
                                <div class="map-region" data-region="lome" style="top: 60%; left: 30%;" title="Lomé: 65%">
                                    <div class="region-dot"></div>
                                </div>
                                <div class="map-region" data-region="kara" style="top: 30%; left: 60%;" title="Kara: 15%">
                                    <div class="region-dot"></div>
                                </div>
                                <div class="map-region" data-region="savanes" style="top: 20%; left: 50%;" title="Savanes: 10%">
                                    <div class="region-dot"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="geo-card">
                        <h5>Top villes</h5>
                        <div class="top-cities">
                            <div class="city-item">
                                <span>Lomé</span>
                                <div class="city-bar">
                                    <div class="bar-fill" style="width: 65%"></div>
                                </div>
                                <span>65%</span>
                            </div>
                            <div class="city-item">
                                <span>Kara</span>
                                <div class="city-bar">
                                    <div class="bar-fill" style="width: 15%"></div>
                                </div>
                                <span>15%</span>
                            </div>
                            <div class="city-item">
                                <span>Sokodé</span>
                                <div class="city-bar">
                                    <div class="bar-fill" style="width: 10%"></div>
                                </div>
                                <span>10%</span>
                            </div>
                            <div class="city-item">
                                <span>Autres</span>
                                <div class="city-bar">
                                    <div class="bar-fill" style="width: 10%"></div>
                                </div>
                                <span>10%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Onglet Financier -->
            <div class="tab-content" id="financial-tab">
                <div class="financial-grid">
                    <div class="finance-card">
                        <h5>Évolution des dons</h5>
                        <div class="finance-chart">
                            <canvas id="financialChart"></canvas>
                        </div>
                    </div>
                    
                    <div class="finance-card">
                        <h5>Statistiques financières</h5>
                        <div class="finance-stats">
                            <div class="stat-item">
                                <i class="fas fa-money-bill"></i>
                                <div>
                                    <h6>Don moyen</h6>
                                    <p>18.050cfa</p>
                                </div>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-users"></i>
                                <div>
                                    <h6>Donateurs actifs</h6>
                                    <p>845</p>
                                </div>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-repeat"></i>
                                <div>
                                    <h6>Taux de récurrence</h6>
                                    <p>24%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Onglet Utilisateurs -->
            <div class="tab-content" id="users-tab">
                <div class="users-grid">
                    <div class="users-card">
                        <h5>Démographie</h5>
                        <div class="demography-stats">
                            <div class="demo-item">
                                <div class="demo-label">Hommes</div>
                                <div class="demo-value">55%</div>
                            </div>
                            <div class="demo-item">
                                <div class="demo-label">Femmes</div>
                                <div class="demo-value">45%</div>
                            </div>
                            <div class="demo-item">
                                <div class="demo-label">18-25 ans</div>
                                <div class="demo-value">35%</div>
                            </div>
                            <div class="demo-item">
                                <div class="demo-label">26-35 ans</div>
                                <div class="demo-value">40%</div>
                            </div>
                            <div class="demo-item">
                                <div class="demo-label">36+ ans</div>
                                <div class="demo-value">25%</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="users-card">
                        <h5>Source d'acquisition</h5>
                        <div class="acquisition-chart">
                            <canvas id="acquisitionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rapports et export -->
    <div class="reports-section">
        <div class="section-header">
            <h3><i class="fas fa-file-alt"></i> Rapports et export</h3>
        </div>
        
        <div class="reports-grid">
            <div class="report-card">
                <div class="report-icon">
                    <i class="fas fa-file-excel"></i>
                </div>
                <div class="report-content">
                    <h5>Rapport mensuel</h5>
                    <p>Statistiques complètes du mois</p>
                    <button class="btn btn-outline btn-sm">
                        <i class="fas fa-download"></i>
                        Télécharger
                    </button>
                </div>
            </div>
            
            <div class="report-card">
                <div class="report-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="report-content">
                    <h5>Analyse des dons</h5>
                    <p>Détails des transactions</p>
                    <button class="btn btn-outline btn-sm">
                        <i class="fas fa-download"></i>
                        Télécharger
                    </button>
                </div>
            </div>
            
            <div class="report-card">
                <div class="report-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="report-content">
                    <h5>Rapport utilisateurs</h5>
                    <p>Démographie et activité</p>
                    <button class="btn btn-outline btn-sm">
                        <i class="fas fa-download"></i>
                        Télécharger
                    </button>
                </div>
            </div>
            
            <div class="report-card">
                <div class="report-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="report-content">
                    <h5>Rapport personnalisé</h5>
                    <p>Créer un rapport sur mesure</p>
                    <button class="btn btn-primary btn-sm" id="customReport">
                        <i class="fas fa-plus"></i>
                        Créer
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    /* ===== STATISTICS STYLES ===== */
    .statistics-container {
        padding: 20px;
    }

    /* KPI Principaux */
    .main-kpi {
        background: white;
        border-radius: var(--border-radius);
        padding: 25px;
        box-shadow: var(--shadow);
    }

    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 25px;
    }

    .kpi-card {
        padding: 25px;
        border-radius: var(--border-radius);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: transform 0.3s;
    }

    .kpi-card:hover {
        transform: translateY(-5px);
    }

    .kpi-card.primary {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
    }

    .kpi-card.success {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .kpi-card.warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    .kpi-card.danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
    }

    .kpi-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
    }

    .kpi-content {
        flex: 1;
    }

    .kpi-content h3 {
        margin: 0 0 8px 0;
        font-size: 32px;
        font-weight: 800;
    }

    .kpi-content p {
        margin: 0 0 10px 0;
        font-size: 16px;
        opacity: 0.9;
    }

    .kpi-trend {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
    }

    .kpi-trend.up {
        color: rgba(255, 255, 255, 0.9);
    }

    .kpi-trend.down {
        color: rgba(255, 255, 255, 0.7);
    }

    /* Filtres de période */
    .period-filters {
        background: white;
        border-radius: var(--border-radius);
        padding: 25px;
        box-shadow: var(--shadow);
    }

    .filters-header {
        margin-bottom: 20px;
    }

    .filters-header h4 {
        margin: 0;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .period-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .period-btn {
        padding: 10px 20px;
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius-sm);
        color: #6b7280;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .period-btn:hover {
        background: #e5e7eb;
    }

    .period-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .custom-period {
        margin-top: 20px;
        padding: 20px;
        background: #f9fafb;
        border-radius: var(--border-radius);
        border: 1px solid #e5e7eb;
    }

    .date-inputs {
        display: flex;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .date-inputs span {
        color: #6b7280;
        font-weight: 600;
    }

    /* Graphiques principaux */
    .main-charts {
        background: white;
        border-radius: var(--border-radius);
        padding: 25px;
        box-shadow: var(--shadow);
    }

    .chart-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(500px, 1fr));
        gap: 25px;
    }

    @media (max-width: 1200px) {
        .chart-row {
            grid-template-columns: 1fr;
        }
    }

    .chart-card {
        padding: 20px;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
        background: white;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .chart-header h4 {
        margin: 0;
        color: #1f2937;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chart-select {
        padding: 8px 15px;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius-sm);
        background: white;
        font-size: 14px;
        min-width: 150px;
    }

    .chart-body {
        height: 300px;
        position: relative;
    }

    /* Statistiques détaillées */
    .detailed-stats {
        background: white;
        border-radius: var(--border-radius);
        padding: 25px;
        box-shadow: var(--shadow);
    }

    .stats-tabs {
        display: flex;
        gap: 5px;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 25px;
        overflow-x: auto;
    }

    .stats-tab {
        padding: 15px 25px;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        color: #6b7280;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        white-space: nowrap;
        transition: all 0.3s;
    }

    .stats-tab:hover {
        color: var(--primary-color);
    }

    .stats-tab.active {
        color: var(--primary-color);
        border-bottom-color: var(--primary-color);
        background: linear-gradient(to bottom, rgba(59, 130, 246, 0.05), transparent);
    }

    .stats-content {
        min-height: 400px;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Grilles spécifiques */
    .activity-grid, .geography-grid, .financial-grid, .users-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .activity-card, .geo-card, .finance-card, .users-card {
        padding: 20px;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
        background: #f9fafb;
    }

    .activity-card h5, .geo-card h5, .finance-card h5, .users-card h5 {
        margin: 0 0 20px 0;
        color: #1f2937;
        font-size: 16px;
    }

    /* Heures de pointe */
    .peak-hours, .top-cities {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .hour-item, .city-item {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .hour-item span:first-child, .city-item span:first-child {
        width: 100px;
        font-size: 14px;
        color: #4b5563;
    }

    .hour-bar, .city-bar {
        flex: 1;
        height: 10px;
        background: #e5e7eb;
        border-radius: 5px;
        overflow: hidden;
    }

    .bar-fill {
        height: 100%;
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        border-radius: 5px;
    }

    .hour-percent, .city-item span:last-child {
        width: 40px;
        text-align: right;
        font-weight: 600;
        color: #1f2937;
        font-size: 14px;
    }

    /* Actions */
    .actions-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .action-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: white;
        border-radius: var(--border-radius-sm);
        border: 1px solid #e5e7eb;
    }

    .action-item i {
        font-size: 24px;
        color: var(--primary-color);
        width: 40px;
        height: 40px;
        background: var(--primary-light);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .action-item strong {
        display: block;
        font-size: 15px;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .action-item small {
        color: #6b7280;
        font-size: 13px;
    }

    /* Carte */
    .map-container {
        position: relative;
        width: 100%;
        height: 200px;
        background: #f1f5f9;
        border-radius: var(--border-radius);
        overflow: hidden;
    }

    .map-region {
        position: absolute;
        cursor: pointer;
    }

    .region-dot {
        width: 20px;
        height: 20px;
        background: var(--primary-color);
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        transition: transform 0.3s;
    }

    .map-region:hover .region-dot {
        transform: scale(1.5);
    }

    /* Statistiques financières */
    .finance-stats {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .finance-stats .stat-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: white;
        border-radius: var(--border-radius-sm);
        border: 1px solid #e5e7eb;
    }

    .finance-stats .stat-item i {
        font-size: 24px;
        color: var(--primary-color);
        width: 50px;
        height: 50px;
        background: var(--primary-light);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .finance-stats .stat-item h6 {
        margin: 0 0 4px 0;
        color: #6b7280;
        font-size: 14px;
    }

    .finance-stats .stat-item p {
        margin: 0;
        color: #1f2937;
        font-size: 20px;
        font-weight: 700;
    }

    /* Démographie */
    .demography-stats {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .demo-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 15px;
        background: white;
        border-radius: var(--border-radius-sm);
        border: 1px solid #e5e7eb;
    }

    .demo-label {
        color: #4b5563;
        font-size: 14px;
    }

    .demo-value {
        color: #1f2937;
        font-weight: 700;
        font-size: 16px;
    }

    /* Rapports */
    .reports-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 25px;
        box-shadow: var(--shadow);
    }

    .reports-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .report-card {
        padding: 20px;
        border: 1px solid #e5e7eb;
        border-radius: var(--border-radius);
        text-align: center;
        transition: all 0.3s;
    }

    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .report-icon {
        width: 70px;
        height: 70px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        color: var(--primary-color);
        font-size: 32px;
    }

    .report-content h5 {
        margin: 0 0 8px 0;
        color: #1f2937;
    }

    .report-content p {
        margin: 0 0 15px 0;
        color: #6b7280;
        font-size: 14px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .kpi-grid {
            grid-template-columns: 1fr;
        }
        
        .chart-row {
            grid-template-columns: 1fr;
        }
        
        .activity-grid, .geography-grid, .financial-grid, .users-grid {
            grid-template-columns: 1fr;
        }
        
        .stats-tabs {
            flex-direction: column;
        }
        
        .stats-tab {
            justify-content: center;
        }
        
        .period-buttons {
            justify-content: center;
        }
        
        .date-inputs {
            justify-content: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des périodes
    const periodBtns = document.querySelectorAll('.period-btn');
    const customPeriod = document.getElementById('customPeriod');
    
    periodBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Retirer la classe active
            periodBtns.forEach(b => b.classList.remove('active'));
            // Ajouter la classe active
            this.classList.add('active');
            
            const period = this.dataset.period;
            
            // Afficher/masquer la période personnalisée
            if (period === 'custom') {
                customPeriod.style.display = 'block';
            } else {
                customPeriod.style.display = 'none';
                loadStatistics(period);
            }
        });
    });
    
    // Appliquer la période personnalisée
    document.getElementById('applyCustom')?.addEventListener('click', function() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        
        if (!startDate || !endDate) {
            showNotification('Veuillez sélectionner une période complète', 'warning');
            return;
        }
        
        showNotification(`Chargement des statistiques du ${startDate} au ${endDate}`, 'info');
        // Ici, tu chargerais les statistiques pour cette période
    });
    
    // Gestion des onglets
    const statsTabs = document.querySelectorAll('.stats-tab');
    const tabContents = document.querySelectorAll('.tab-content');
    
    statsTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Retirer la classe active
            statsTabs.forEach(t => t.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Ajouter la classe active
            this.classList.add('active');
            const tabId = this.dataset.tab;
            document.getElementById(`${tabId}-tab`).classList.add('active');
        });
    });
    
    // Initialiser les graphiques
    if (typeof Chart !== 'undefined') {
        // Graphique de croissance
        const growthCtx = document.getElementById('growthChart')?.getContext('2d');
        if (growthCtx) {
            new Chart(growthCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                    datasets: [{
                        label: 'Utilisateurs',
                        data: [1500, 1800, 2100, 1900, 2300, 2450, 2600, 2500, 2700, 2900, 3100, 3300],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            grid: {
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }
        
        // Graphique des dons
        const donationsCtx = document.getElementById('donationsChart')?.getContext('2d');
        if (donationsCtx) {
            new Chart(donationsCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Éducation', 'Santé', 'Environnement', 'Social', 'Autre'],
                    datasets: [{
                        data: [35, 25, 20, 15, 5],
                        backgroundColor: [
                            '#3b82f6',
                            '#10b981',
                            '#f59e0b',
                            '#8b5cf6',
                            '#6b7280'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right'
                        }
                    }
                }
            });
        }
        
        // Graphique d'acquisition
        const acquisitionCtx = document.getElementById('acquisitionChart')?.getContext('2d');
        if (acquisitionCtx) {
            new Chart(acquisitionCtx, {
                type: 'pie',
                data: {
                    labels: ['Réseaux sociaux', 'Recherche', 'Recommandation', 'Email', 'Autre'],
                    datasets: [{
                        data: [40, 25, 20, 10, 5],
                        backgroundColor: [
                            '#3b82f6',
                            '#10b981',
                            '#f59e0b',
                            '#8b5cf6',
                            '#6b7280'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    }
    
    // Charger les statistiques
    function loadStatistics(period) {
        showNotification(`Chargement des statistiques pour: ${period}`, 'info');
        // Ici, tu ferais un appel AJAX pour charger les données
    }
    
    // Rapports personnalisés
    document.getElementById('customReport')?.addEventListener('click', function() {
        showNotification('Création de rapport personnalisé en développement', 'info');
    });
    
    // Télécharger les rapports
    document.querySelectorAll('.btn-outline').forEach(btn => {
        btn.addEventListener('click', function() {
            const card = this.closest('.report-card');
            const reportName = card.querySelector('h5').textContent;
            showNotification(`Téléchargement du rapport: ${reportName}`, 'info');
            // Simulation de téléchargement
            setTimeout(() => {
                showNotification('Rapport téléchargé avec succès', 'success');
            }, 1500);
        });
    });
    
    // Fonction de notification
    function showNotification(message, type = 'info') {
        const flashContainer = document.querySelector('.flash-container') || document.body;
        const alert = document.createElement('div');
        alert.className = `alert-flash ${type} fade-in`;
        alert.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check' : 'info'}-circle"></i>
            <span>${message}</span>
            <button class="close-btn">&times;</button>
        `;
        
        if (!flashContainer.classList.contains('flash-container')) {
            flashContainer.style.position = 'fixed';
            flashContainer.style.top = '20px';
            flashContainer.style.right = '20px';
            flashContainer.style.zIndex = '9999';
        }
        
        flashContainer.appendChild(alert);
        
        // Auto-remove après 5s
        setTimeout(() => {
            alert.classList.add('fade-out');
            setTimeout(() => alert.remove(), 500);
        }, 5000);
        
        // Bouton de fermeture
        alert.querySelector('.close-btn').addEventListener('click', () => {
            alert.remove();
        });
    }
    
    // Charger les statistiques par défaut
    loadStatistics('month');
});
</script>
@endpush