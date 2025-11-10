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
        <a href="{{ route('home') }}" class="text-blue-600 font-semibold ">Accueil</a>
        <a href="{{ route('elections') }}" class="hover:text-blue-600  border-b-2 border-blue-600 pb-1">Election</a>
        <a href="{{ route('results') }}" class="hover:text-blue-600">Résultats</a>

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


    <br>
 
    <main class="min-h-screen   flex justify-center items-center  bg-gradient from-cyan-800 to-slate-600 ">
        <section class="bg-gradient-to-br from-indigo-50 via-white to-blue-100     ">
            <br>
            <div class="container flex justify-center ">
                <div class="w-full max-w-7xl justify-center items-center ">
                    
                    <!-- HEADER -->
                    <div class="">
                        <h1 class="font-bold text-2xl">
                            🗳️ {{ $session->nom }}
                        </h1>
                        <br>
                        <h1 class="font-bold text-xl">
                            {{ $session->description }}
                        </h1>
                        <br>
                    </div>
                    <!-- SESSION INFOS -->
                    <div class="bg-white rounded-2xl shadow-xl p-6 mb-10 border border-gray-200 hover:shadow-2xl transition">
                        <div class="flex flex-col md:flex-row justify-between items-center">
                            <a href="{{ route('home') }}"
                                class="mt-6 md:mt-0 inline-flex items-center px-6 py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 shadow-md hover:shadow-lg transition">
                                ← Retour aux sessions
                            </a>
                            <div class="space-y-3">
                                <div class="flex items-center text-gray-700 space-x-2">
                                    <i class="fa-solid fa-calendar-days text-blue-600"></i>
                                    <span class="font-medium">Début : {{ $session->date_debut }}</span>
                                </div>
                                <div class="flex items-center text-gray-700 space-x-2">
                                    <i class="fa-solid fa-clock text-blue-600"></i>
                                    <span class="font-medium">Fin : {{ $session->date_fin }}</span>
                                </div>
                            </div>
        
                        </div>
                    </div>
        
                    <br>
                    <!-- CANDIDATS SECTION -->
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-blue-800 mb-2">👤 Candidats Inscrits</h2>
                        <p class="text-gray-500">Choisissez celui qui représente le mieux vos valeurs</p>
                    </div>
        
                    
                    
                      <!-- SECTION candidats -->
                    <div class="max-w-7xl mx-auto mt-16 px-4" id="vote">
                        <h2 class="text-2xl text-blue-900 font-semibold mb-6">Voter un candidat de votre choix</h2>
    
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        @foreach ($session->candidates as $candidat)
                            <div class="bg-white border rounded-2xl p-8 shadow-sm hover:shadow-md transition text-center py-6">
                                <!-- Image -->
                                <div class="flex justify-center mb-6">
                                    <img src="{{ asset('images/' . $candidat->photo) }}" 
                                        class="w-24 h-24 rounded-full object-cover border-4 border-indigo-800 py-5  shadow-lg"
                                        alt="Photo de {{ $candidat->nom }}">
                                </div>
    
                                <h3 class="text-xl font-bold text-gray-800 mb-2">
                                    {{ $candidat->nom }} {{ $candidat->prenom }}
                                </h3>
                                
                                
                                <p class="text-gray-600 mb-6 leading-relaxed">
                                    {{ $candidat->description }}
                                </p>
                                
                                <div class="fle flex-col space-y-3">
                                    <button class="bg-green-50 w-full border-gray-500 py-5 text-green-600 font-semibold max-w-full max-h-full rounded-xl">
                                        {{ $candidat->percentage() }} %
                                    </button>
                                     <button class="bg-blue-50 w-full border-gray-500 py-5 text-blue-600 font-semibold max-w-full max-h-full rounded-xl">
                                        {{ $candidat->countvote }} {{ $candidat->countvote == 1 ? 'vote' : 'votes' }}
                                    </button>
                                    
                                    @if(Auth::check())
                                        <a href="{{ route('vote', ['session_id' => $candidat->session->id,'candidate_id' => $candidat->id,'voting_id' => $candidat->voting_id]) }}" class="block w-full">
                                            <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold w-full py-3 rounded-xl transition shadow-md hover:shadow-lg">
                                                Voter pour {{ $candidat->nom }}
                                            </button>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        
                        </div>
                    </div>
    
    
        
                </div>
            </div>
        </section>

    </main>


    <!-- FOOTER -->
    <footer class=" bottom-auto bg-blue-500 text-white text-center py-6 mt-16">
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
