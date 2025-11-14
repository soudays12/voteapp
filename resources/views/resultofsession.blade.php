<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vote.com</title>
  <!-- SweetAlert CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <!-- SweetAlert JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800 font-sans">
  @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Succès',
            text: '{{ session('success') }}',
        });
    </script>
  @endif

  @if(session('error'))
      <script>
          Swal.fire({
              icon: 'error',
              title: 'Erreur',
              text: '{{ session('error') }}',
          });
      </script>
  @endif

  @foreach ($errors->all() as $error)
    <script>
          Swal.fire({
              icon: 'error',
              title: 'Erreur',
              text: '{{ $error }} ',
          });
      </script>
  @endforeach

  <!-- NAVBAR -->
  <header class="w-full bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
      <!-- Logo -->
      <a href="#" class="text-xl font-bold bg-gradient-to-b from-blue-400 to-purple-600 bg-clip-text text-transparent">VOTE.COM</a>


      <!-- Bouton hamburger (mobile) -->
      <button id="menu-btn" class="md:hidden text-gray-700 focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

      <!-- Menu principal -->
      <nav id="menu" class="hidden md:flex items-center space-x-6 text-gray-600 font-medium">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Accueil</a>
        <a href="{{ route('elections') }}" class="hover:text-blue-600">Election</a>
        <a href="{{ route('results') }}" class=" text-blue-600 font-semibold border-b-2 border-blue-600 pb-1">Résultats</a>

        @if(Auth::check())
            <p class="text-blue-500">Bienvenue M.{{ Auth::user()->nom }} !</p>
            <a href="{{ route('logout') }}" class="bg-gradient-to-b from-blue-400 to-purple-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                Deconnexion
            </a>
        @else
            <a href="{{ route('login') }}" class="bg-gradient-to-b from-blue-400 to-purple-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                Connexion
            </a>
        @endif

      </nav>
    </div>

    <!-- Menu mobile -->
    <div id="mobile-menu" class="md:hidden hidden px-6 pb-4 bg-white border-t">
      <a href="#" class="block py-2 text-blue-600 font-semibold">Accueil</a>
      <a href="#" class="block py-2 text-gray-600 hover:text-blue-600">Candidats</a>
      <a href="#" class="block py-2 text-gray-600 hover:text-blue-600">Résultats</a>
      <a href="{{ route('login') }}" class="block mt-2 bg-blue-600 text-white text-center px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
        Connexion
      </a>
    </div>
  </header>



  <!-- SECTION PRINCIPALE -->
  <div class="max-w-7xl mx-auto mt-16 px-4" id="vote">
    <h2 class="text-2xl text-blue-900 font-semibold mb-6">Resultats de l'élection</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      
      @foreach ($candidats as $candidat)
        <div class="bg-white border rounded-2xl p-8 shadow-sm hover:shadow-md transition text-center py-6">
            <!-- Image -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/' . $candidat->photo) }}" 
                    class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg"
                    alt="Photo de {{ $candidat->nom }}">
            </div>

            <h3 class="text-xl font-bold text-gray-800 mb-2">
                {{ $candidat->nom }} {{ $candidat->prenom }}
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
                    {{ $candidat->countvote }} {{ $candidat->countvote == 1 ? 'vote' : 'votes' }}
                </button>
                
            </div>
        </div>
      @endforeach
    </div>
  </div>

  <!-- SECTION RÉSULTATS -->
  <section class="max-w-7xl mx-auto mt-16 px-4">
    <h2 class="text-3xl font-bold text-gray-600 mb-6 border-b pb-2">Top 3 des candidats</h2>
    <div class="flex flex-row gap-6 justify-center">
    @if (isset($topCandidates))
        @foreach ($topCandidates as $top)
        <div class="bg-white border rounded-2xl p-8 shadow-sm hover:shadow-md transition text-center py-6 flex-1 max-w-sm">
          <!-- Image -->
          <div class="flex justify-center mb-6">
            <img src="{{ asset('images/' . $top->photo) }}" 
              class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg"
              alt="Photo de {{ $top->nom }}">
          </div>

              <h3 class="text-xl font-bold text-gray-800 mb-2">
                  {{ $top->nom }} {{ $top->prenom }}
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
                    {{ $top->countvote }} {{ $top->countvote == 1 ? 'vote' : 'votes' }}
                </button>
            </div>
          </div>
          @endforeach
    @endif
    </div>
  </section>


  <section class="max-w-7xl mx-auto mt-16 px-4">
    <h2 class="text-3xl font-bold text-gray-600 mb-6 border-b pb-2">Le gagnant c'est</h2>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <!-- Vos autres contenus... -->
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

  <!-- FOOTER -->
  <footer class="bg-blue-500 text-white text-center py-6 mt-16">
    <p>&copy; 2025 Plateforme de Vote en Ligne — Tous droits réservés.</p>
  </footer>

  <!-- Script pour le menu hamburger -->
  <script>
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

      menuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  </script>

</body>
</html>
