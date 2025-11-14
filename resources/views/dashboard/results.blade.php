@extends('dashboard.layout')

@section('session')
<div class="max-w-7xl mx-auto mt-16 px-4" id="vote">
    <h2 class="text-2xl text-blue-900 font-semibold mb-6">Resultats des differentes sessions</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach ($sessions as $session)
        <div class="bg-white border rounded-2xl shadow-sm hover:shadow-md transition text-center py-6">
            <div class="">
                <img src="{{ asset('images/default.jpeg')}}" 
                    class="w-full h-30  object-cover border-4 border-indigo-800 shadow-lg"
                    alt="Session de vote">
            </div>
        
            <div class="p-8 ">
                <h3 class="text-xl font-bold text-gray-800 mb-2">
                {{ $session->nom }}
                </h3>
                
                <p class="text-gray-600 mb-6 leading-relaxed">
                {{ Str::limit($session->description, 100) }}...
                </p>
    
                <div class="space-y-3 flex flex-row justify-center">

                <a href="{{ route('dashboard.resultatSession', $session ) }}" class="block w-full">
                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold w-full py-3 rounded-xl transition shadow-md hover:shadow-lg">
                    Voir les détails
                    </button>
                </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection