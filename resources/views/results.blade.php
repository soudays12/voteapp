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



  <!-- SECTION SESSIONS -->
  <div class="max-w-7xl mx-auto mt-16 px-4" id="vote">
    <h2 class="text-2xl text-blue-900 font-semibold mb-6">Cliquez sur voir pour acceder aux resultats des concours</h2>

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
              <a href="{{ route('resultofsession', $session->id ) }}" class="block w-full">
                <button class="bg-blue-500 hover:bg-blue-600 text-white font-semibold w-full py-3 rounded-xl transition shadow-md hover:shadow-lg">
                  Voir les resultats
                </button>
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>





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
