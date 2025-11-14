@extends('dashboard.layout')

@section('session')
<!-- SECTION PRINCIPALE -->
<div class="max-w-7xl mx-auto mt-16 px-4" id="vote">
    <h2 class="text-2xl text-blue-900 font-semibold mb-6">Resultats de l'élection</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @if(isset($candidats) && $candidats->count())
            @foreach ($candidats as $candidat)
            <div class="bg-white border rounded-2xl p-8 shadow-sm hover:shadow-md transition text-center py-6">
                <!-- Image -->
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/' . $candidat->photo) }}" 
                        class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg"
                        alt="Photo de {{ $candidat->nom }}">
                </div>

                <h3 class="text-xl font-bold text-gray-800 mb-2">
                    {{ $candidat->nom }}
                </h3>
                
                <!-- Pourcentage -->
                <div class="mb-4">
                    <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">
                        {{ $candidat->percentage }}% des votes 
                    </span>
                </div>
                
                <p class="text-gray-600 mb-6 leading-relaxed">
                    {{ $candidat->description }}
                </p>
                
                <div class="space-y-3">
                    <button class="bg-blue-50 text-blue-600 font-semibold w-full py-3 rounded-xl">
                        {{ $candidat->votes_count }} {{ $candidat->votes_count == 1 ? 'vote' : 'votes' }}
                    </button>
                </div>
            </div>
            @endforeach
        @else
            <p class="text-gray-500">Aucun candidat pour cette session.</p>
        @endif
    </div>
</div>

<!-- SECTION RÉSULTATS -->
<section class="max-w-7xl mx-auto mt-16 px-4">
    <h2 class="text-3xl font-bold text-gray-600 mb-6 border-b pb-2">Top 3 des candidats</h2>
    <div class="flex flex-row gap-6 justify-center">
        @if(isset($topCandidates) && $topCandidates->count())
            @foreach ($topCandidates as $top)
            <div class="bg-white border rounded-2xl p-8 shadow-sm hover:shadow-md transition text-center py-6 flex-1 max-w-sm">
                <!-- Image -->
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('images/' . $top->photo) }}" 
                        class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg"
                        alt="Photo de {{ $top->nom }}">
                </div>

                <h3 class="text-xl font-bold text-gray-800 mb-2">
                    {{ $top->nom }}
                </h3>
                
                <!-- Pourcentage -->
                <div class="mb-4">
                    <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">
                        {{ $top->percentage }}% des votes
                    </span>
                </div>
                
                <p class="text-gray-600 mb-6 leading-relaxed">
                    {{ $top->description }}
                </p>
                
                <div class="space-y-3">
                    <button class="bg-blue-50 text-blue-600 font-semibold w-full py-3 rounded-xl">
                        {{ $top->votes_count }} {{ $top->votes_count == 1 ? 'vote' : 'votes' }}
                    </button>
                </div>
            </div>
            @endforeach
        @else
            <p class="text-gray-500">Aucun top candidat disponible.</p>
        @endif
    </div>
</section>

<section class="max-w-7xl mx-auto mt-16 px-4">
    <h2 class="text-3xl font-bold text-gray-600 mb-6 border-b pb-2">Le gagnant c'est</h2>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <!-- Autres contenus -->
        </div>
        
        <div>
            @if(isset($bestCandidate) && $bestCandidate)
            <div class="bg-white p-6 rounded-2xl shadow">
                <h2 class="text-xl font-bold text-gray-800 text-center mb-4">🎯 Gagnant</h2>
                
                <div class="text-center">
                    <img src="{{ asset('images/' . $bestCandidate->photo) }}" 
                        class="w-20 h-20 rounded-full object-cover border-2 border-yellow-400 mx-auto mb-3"
                        alt="{{ $bestCandidate->nom }}">
                    
                    <h3 class="font-bold text-gray-800">{{ $bestCandidate->nom }}</h3>
                    <p class="text-yellow-600 font-semibold text-sm">{{ $bestCandidate->percentage }}%</p>
                    <p class="text-gray-500 text-xs mt-2">{{ $bestCandidate->votes_count }} votes</p>
                </div>
            </div>
            @else
            <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border-2 border-yellow-200 p-6 rounded-2xl shadow-lg">
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-full mb-3">
                        <span class="text-2xl">🤝</span>
                    </div>
                    <h2 class="text-xl font-bold text-yellow-800 mb-2">Égalité parfaite</h2>
                    <p class="text-yellow-700 text-sm">Plusieurs candidats partagent la première place</p>
                </div>
                
                @if(isset($tiedCandidates) && $tiedCandidates->count())
                    <div class="space-y-3">
                        @foreach($tiedCandidates as $index => $tied)
                        <div class="flex items-center justify-between p-4 bg-white rounded-xl shadow-sm border border-yellow-100 hover:shadow-md transition-shadow">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <img src="{{ asset('images/' . $tied->photo) }}" 
                                        class="w-12 h-12 rounded-full object-cover border-2 border-yellow-300"
                                        alt="{{ $tied->nom }}">
                                    <div class="absolute -top-1 -right-1 w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-bold text-yellow-800">{{ $index + 1 }}</span>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $tied->nom }}</p>
                                    <p class="text-sm text-gray-500">Candidat à égalité</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="inline-flex items-center space-x-2 bg-yellow-100 px-3 py-1 rounded-full">
                                    <span class="text-sm font-bold text-yellow-800">{{ $tied->percentage }}%</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ $tied->votes_count }} {{ $tied->votes_count == 1 ? 'vote' : 'votes' }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</section>
@endsection