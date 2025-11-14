@extends('dashboard.layout')

@section('session')
<!-- Stat cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-shadow">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <p class="text-sm font-medium text-gray-600 mb-1">Utilisateurs inscrits</p>
                <p class="text-3xl font-bold text-gray-900">{{ $users }}</p>
                <p class="text-sm text-green-600 font-medium">+13%</p>
            </div>
            <div class="w-12 h-12 bg-gradient-to-r from-pink-400 to-pink-600 rounded-lg flex items-center justify-center">
                <i class="fas fa-users text-white"></i>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="info-icon">
            <p class="card-title">Candidats</p>
            <p class="card-value">{{ $candidats }}</p>
            <p class="card-trend">+13%</p>
        </div>
        <div class="w-12 h-12 bg-gradient-to-r from-purple-400 to-purple-600 rounded-lg flex items-center justify-center">
            <i class="fas fa-user-tie text-white"></i>
        </div>
    </div>

    <div class="card">
        <div class="info-icon">
            <p class="card-title">Nombre total de votes</p>
            <p class="card-value">{{ $votes }}</p>
            <p class="card-trend">+13%</p>
        </div>
        <div class="w-12 h-12 bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
            <i class="fas fa-envelope text-white"></i>
        </div>
    </div>

    <div class="card">
        <div class="info-icon">
            <p class="card-title">Sessions</p>
            <p class="card-value">{{ $sessions }}</p>
            <p class="card-trend">+13%</p>
        </div>
        <div class="w-12 h-12 bg-gradient-to-r from-orange-400 to-orange-600 rounded-lg flex items-center justify-center">
            <i class="fas fa-calendar-alt text-white"></i>
        </div>
    </div>
</div>

<div class="grid-content">
    <!-- Table -->
    <div class="table-section">
        <h3 class="section-title">Statistiques</h3>
    </div>

</div>
@endsection