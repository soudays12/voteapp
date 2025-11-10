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
                        <a href="{{ route('dashboard.users') }}" class="sidebar-link active">
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
                        <h1 class="main-title">Utilisateurs</h1>

                    </div>
                    <div class="tab-buttons">
                        <button class="tab-button active" data-tab="toutes">Toutes</button>
                        <button class="tab-button" data-tab="en-ligne">En ligne</button>
                    </div>
                </div>
                <div class="search-actions">
                    <input type="text" placeholder="Recherche..." class="search-input">
                    <button class="btn-primary"> Rechercher</button>
                </div>
            </div>


            <!-- Tabs content -->
            <div id="toutes" class="tab-content active">
                <div class="grid-content">
                    <!-- Table -->
                    <div class="table-section">
                        <h3 class="section-title">Statistiques</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Prénom</th>
                                    <th>Prenom</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr v-for="i in 5">
                                    <td>{{ $user-> nom }}<br><span class="text-muted">Abdou Rahman</span></td>
                                    <td>{{ $user-> prenom }}</td>
                                    <td>{{ $user-> email }}</td>
                                    <td>
                                        
                                        <a href=" route('dashboard.users', $user->id) " class=" bg-cyan-100  rounded-2 px-2 py-2 text-cyan-600" style="cursor: pointer;">
                                            <i class="fas fa-eye" style="cursor: pointer;"></i>
                                            Voir
                                        </a>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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