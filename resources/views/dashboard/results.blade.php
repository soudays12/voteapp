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
                        <a href="{{ route('dashboard.resultats') }}" class="sidebar-link active">
                            <i class="fas fa-file-alt icon"></i>
                            <span>Resultats</span>
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