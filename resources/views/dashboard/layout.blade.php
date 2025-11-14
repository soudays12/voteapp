
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="app.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <!-- SweetAlert JavaScript -->
    @vite('resources/css/app.css','resources/js/app.js','resources/fontawesome/css/all.min.css')
    <style>
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>

<body class="container-bg">
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: '{{ session('success') }}',
            });
        </script>
        {{ session()->forget('success') }}
    @endif
    
    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: '{{ session('error') }}',
            });
        </script>
        {{ session()->forget('error') }}
    @endif
    
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
                            <i class="fas fa-tachometer-alt icon"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.sessions') }}" class="sidebar-link active">
                            <i class="fas fa-calendar-alt icon"></i>
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
                        <a href="{{ route('dashboard.candidates') }}" class="sidebar-link ">
                            <i class="fas fa-user-tie icon"></i>
                            <span>Candidats</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.resultats') }}" class="sidebar-link">
                            <i class="fas fa-chart-bar icon"></i>
                            <span>Resultats</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <footer class="footer-aside mt-auto p-4">
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-3 px-4 py-3 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors group">
                        <i class="fas fa-power-off group-hover:rotate-12 transition-transform"></i>
                        <span class="font-medium">Déconnexion</span>
                    </button>
                </form>
            </footer>
        </aside>

        <!-- Main content -->
        <main class="main">
            <div class="header">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between w-full">
                    <div class="flex flex-col space-y-4 lg:space-y-0">
                        <div class="menu-and-title flex items-center space-x-4">
                            <!-- Menu Toggle Button -->
                            <button id="toggleSidebar" class="toggle-button">
                                ☰
                            </button>
                            <h1 class="main-title">Gestion des Sessions</h1>
                        </div>
                        <div class="tab-buttons flex items-center space-x-2">
                            <button class="tab-button active" data-tab="toutes">Toutes</button>
                            <button class="tab-button" data-tab="en-ligne">En ligne</button>
                        </div>
                    </div>
                    <div class="search-actions flex items-center space-x-3 mt-4 lg:mt-0">
                        <input type="text" placeholder="Recherche..." class="search-input">
                        <button class="btn-primary" id="openModal">Rechercher</button>
                    </div>
                </div>
            </div>
            
            
            
            <!-- Tabs content -->
            <div id="toutes" class="tab-content active">
                @yield('session')
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


        document.addEventListener("DOMContentLoaded", () => {
            const modalOverlay = document.getElementById('modalOverlay');
            const sessionInput = document.getElementById('hidden_session');

            document.querySelectorAll('.openModal').forEach(button => {
                button.addEventListener('click', (e) => {
                    const sessionId = e.currentTarget.getAttribute('data-id');
                    sessionInput.value = sessionId;
                    modalOverlay.classList.remove('hidden');
                });
            });

            modalOverlay.addEventListener('click', (e) => {
                if (e.target === modalOverlay) {
                    modalOverlay.classList.add('hidden');
                }
            });
        });
    </script>
</body>

</html>