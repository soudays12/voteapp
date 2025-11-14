@extends('dashboard.layout')

@section('session')
<div class="space-y-6">
    <!-- Table -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
        <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-blue-50 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Liste des Utilisateurs</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr class="text-gray-600 text-sm font-medium">
                        <th class="px-6 py-4 text-left">Nom complet</th>
                        <th class="px-6 py-4 text-left">Email</th>
                        <th class="px-6 py-4 text-center">Statut</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">{{ substr($user->nom, 0, 1) }}{{ substr($user->prenom, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $user->nom }} {{ $user->prenom }}</p>
                                    <p class="text-sm text-gray-500">Utilisateur</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Actif
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center">
                                <a href="#" class="inline-flex items-center px-3 py-1 bg-cyan-100 hover:bg-cyan-200 text-cyan-700 rounded-full text-sm font-medium transition-colors">
                                    <i class="fas fa-eye mr-1"></i>
                                    Voir
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection