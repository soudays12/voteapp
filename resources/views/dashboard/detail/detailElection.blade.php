<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="app.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    @vite('resources/css/app.css','resources/js/app.js','resources/fontawesome/css/all.min.css')
    <style>
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
    </style>
</head>


<body class="container-bg">
    <div class="container-screen">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-avatar"></div>
                <h2 class="sidebar-title">Mohamed</h2>
            </div>
            <nav class="sidebar-nav">
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ route('dashboard.index') }}" class="sidebar-link">
                            <i class="fas fa-chart-line icon"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.sessions') }}" class="sidebar-link">
                            <i class="fas fa-users icon"></i>
                            <span>Sessions</span> 
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.users') }}" class="sidebar-link">
                            <i class="fas fa-users icon"></i>
                            <span>Utilisateurs</span> 
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.candidates') }}" class="sidebar-link">
                            <i class="fas fa-coins icon"></i>
                            <span>Candidats</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.elections') }}" class="sidebar-link active">
                            <i class="fas fa-file-alt icon"></i>
                            <span>Election</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <footer class="footer-aside">
                <button class="circular-exit-button">
                    <span class="fas fa-power-off"></span>
                </button>
                <br>
                <span class="{{ route('logout') }}">Deconnexion</span>
            </footer>
        </aside>

        <!-- Main content -->
        <main class="main">
            <div class="header">
                <div>

                    <div class="menu-and-title">
                        <!-- Menu Toggle Button -->
                        <button id="toggleSidebar" class="toggle-button">
                            ☰
                        </button>
                        <h1 class="main-title">Elections</h1>

                    </div>
                </div>
            </div>



            
            <!-- SECTION PRINCIPALE -->
            <div class="max-w-7xl mx-auto mt-16 px-4" id="vote">
                <h2 class="text-2xl text-blue-900 font-semibold mb-6">Resultats de l'élection</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                @foreach ($candidats as $candidat)
                    <div class="bg-white border rounded-2xl p-8 shadow-sm hover:shadow-md transition text-center py-6">
                        <div class="flex justify-center mb-6">
                            <img src="{{ asset('images/' . $candidat->photo) }}" 
                                class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg"
                                alt="Photo de {{ $candidat->nom }}">
                        </div>

                        <h3 class="text-xl font-bold text-gray-800 mb-2">
                            {{ $candidat->nom }} {{ $candidat->prenom }}
                        </h3>
                        
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
                <h2 class="text-3xl font-bold text-gray-600 mb-6 border-b pb-2">Pourcentage de vote</h2>
                <div class="bg-white p-6 rounded-2xl shadow space-y-4">
                @foreach ($candidats as $candidat)
                <div class="bg-white border rounded-2xl p-8 shadow-sm hover:shadow-md transition text-center py-6">

                    <div class="flex justify-center mb-6">
                        <img src="{{ asset('images/' . $candidat->photo) }}" 
                            class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg"
                            alt="Photo de {{ $candidat->nom }}">
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                        {{ $candidat->nom }} {{ $candidat->prenom }}
                    </h3>
                    

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
            </section>


             <!-- -->
            <section class="max-w-7xl mx-auto mt-16 px-4">
                <h2 class="text-3xl font-bold text-gray-600 mb-6 border-b pb-2">Le gagnant c'est</h2>
                <div class="bg-white p-6 rounded-2xl shadow space-y-4">
                <div class="bg-white border rounded-2xl p-8 shadow-sm hover:shadow-md transition text-center py-6">
                    <div class="flex justify-center mb-6">
                        <img src="{{ asset('images/' . $candidat->photo) }}" 
                            class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg"
                            alt="Photo de {{ $candidat->nom }}">
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mb-2">
                        {{ $candidat->nom }} {{ $candidat->prenom }}
                    </h3>
                    
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
            </section>

        </main>
    </div>

    <script>
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('active');
                });
                button.classList.add('active');

                document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
                document.getElementById(button.dataset.tab).classList.add('active');
            });
        });

        document.getElementById('toggleSidebar').addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('show');
        });
    </script>
</body>

</html>