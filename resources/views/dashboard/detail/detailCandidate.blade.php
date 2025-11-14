<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du candidat</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-indigo-600 text-white p-6">
                <h1 class="text-3xl font-bold">{{ $candidate->nom }}</h1>
                <p class="text-indigo-200">Session: {{ $candidate->session->nom ?? 'Non définie' }}</p>
            </div>

            <!-- Content -->
            <div class="p-6">
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Photo -->
                    <div class="text-center">
                        <img src="{{ asset('images/' . $candidate->photo) }}" 
                             alt="{{ $candidate->nom }}" 
                             class="w-64 h-64 object-cover rounded-lg mx-auto shadow-md">
                    </div>

                    <!-- Informations -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Description</h3>
                            <p class="text-gray-600">{{ $candidate->description }}</p>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Statistiques de vote</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600">Nombre de votes:</span>
                                    <span class="font-bold text-2xl text-indigo-600">{{ $candidate->vote()->count() }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Pourcentage:</span>
                                    <span class="font-bold text-3xl text-green-600">{{ $percentage }}%</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Informations techniques</h3>
                            <div class="text-sm text-gray-500 space-y-1">
                                <p><strong>ID de vote:</strong> {{ $candidate->voting_id }}</p>
                                <p><strong>Créé le:</strong> {{ $candidate->created_at->format('d/m/Y à H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex space-x-4">
                    <a href="{{ route('dashboard.candidates') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
                        ← Retour à la liste
                    </a>
                    <a href="{{ route('candidate.edit', ['candidat_id' => $candidate->id]) }}" 
                       class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg transition">
                        Modifier
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>