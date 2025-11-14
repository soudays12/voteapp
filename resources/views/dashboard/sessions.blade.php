@extends('dashboard.layout')

@section('session')
<div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
    <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-blue-50 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-800">Gestion des Sessions</h2>
    </div>
    <table class="min-w-full">
        <thead class="bg-gray-50">
            <tr class="text-gray-600 text-sm font-medium">
                <th class="px-6 py-4 text-left">#</th>
                <th class="px-6 py-4 text-left">Nom</th>
                <th class="px-6 py-4 text-left">Description</th>
                <th class="px-6 py-4 text-center">Date début</th>
                <th class="px-6 py-4 text-center">Date fin</th>
                <th class="px-6 py-4 text-center">Statut</th>
                <th class="px-6 py-4 text-center">Actions</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-200 text-sm">
            @forelse ($sessions as $index => $session)
                <tr>
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $session->nom }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ Str::limit($session->description, 50) }}</td>
                    <td class="px-6 py-4 text-center">{{ $session->date_debut }}</td>
                    <td class="px-6 py-4 text-center">{{ $session->date_fin }}</td>

                    <td class="px-6 py-4 text-center">
                        @if ($session->statut === 'active')
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Active</span>
                        @elseif ($session->statut === 'inactive')
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">Inactive</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Clôturée</span>
                        @endif
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="{{ route('dashboard.detailSession', $session->id) }}"
                               class="inline-flex items-center px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-full text-sm font-medium transition-colors">
                                <i class="fas fa-eye mr-1"></i>
                                Voir
                            </a>

                            <a href="{{ route('dashboard.editSession', $session->id) }}"
                               class="inline-flex items-center px-3 py-1 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded-full text-sm font-medium transition-colors">
                                <i class="fas fa-edit mr-1"></i>
                                Modifier
                            </a>

                            <form action="{{ route('dashboard.deleteSession', $session->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Supprimer cette session ?')"
                                        class="inline-flex items-center px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded-full text-sm font-medium transition-colors">
                                    <i class="fas fa-trash mr-1"></i>
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-6 text-gray-500">
                        Aucune session disponible pour le moment.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection