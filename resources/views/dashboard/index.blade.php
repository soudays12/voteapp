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
    <!-- SweetAlert JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
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
                        <a href="{{ route('dashboard.index') }}" class="sidebar-link active">
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
                        <a href="{{ route('dashboard.candidates') }}" class="sidebar-link ">
                            <i class="fas fa-coins icon"></i>
                            <span>Candidats</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.resultats') }}" class="sidebar-link">
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
                        <h1 class="main-title">Tableau de bord</h1>

                    </div>
                </div>
            </div>

            <!-- Stat cards -->
            <div class="card-grid">
                <div class="card">
                    <div class="info-icon">
                        <p class="card-title">Utilisateurs inscrits</p>
                        <p class="card-value">{{ $users }}</p>
                        <p class="card-trend">+13%</p>
                    </div>
                    <div class="rounded-icon bg-pink">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>

                <div class="card">
                    <div class="info-icon">
                        <p class="card-title">Candidats</p>
                        <p class="card-value">{{ $candidats }}</p>
                        <p class="card-trend">+13%</p>
                    </div>
                    <div class="rounded-icon bg-purple">
                        <i class="fas fa-lock"></i>
                    </div>
                </div>

                <div class="card">
                    <div class="info-icon">
                        <p class="card-title">Nombre total de votes</p>
                        <p class="card-value">{{ $votes }}</p>
                        <p class="card-trend">+13%</p>
                    </div>
                    <div class="rounded-icon bg-blue">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                </div>

                <div class="card">
                    <div class="info-icon">
                        <p class="card-title">Sessions</p>
                        <p class="card-value">{{ $sessions }}</p>
                        <p class="card-trend">+13%</p>
                    </div>
                    <div class="rounded-icon bg-orange">
                        <i class="fas fa-star"></i>
                    </div>
                </div>
            </div>


            <!-- Tabs content -->
            <div id="toutes" class="tab-content active">
                <div class="grid-content">
                    <!-- Table -->
                    <div class="table-section">
                        <h3 class="section-title">Statistiques</h3>
                        
                    </div>

                    <!-- Clients -->
                    <div class="client-section">
                        <h3 class="section-title">Nouveaux utilisateurs</h3>
                        <ul class="client-list">
                            <li>MOUNCHILI NDAM<br><span class="text-muted">Abdou Rahman</span></li>
                            <li>MOUNCHILI NDAM<br><span class="text-muted">Abdou Rahman</span></li>
                            <li>MOUNCHILI NDAM<br><span class="text-muted">Abdou Rahman</span></li>
                            <li>MOUNCHILI NDAM<br><span class="text-muted">Abdou Rahman</span></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="en-ligne" class="tab-content">
                <div class="card">
                    <p>Contenu des utilisateurs en ligne...</p>
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