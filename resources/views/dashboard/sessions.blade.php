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
                        <a href="{{ route('dashboard.sessions') }}" class="sidebar-link active">
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
                        <h1 class="main-title">Gestion des Sessions</h1>

                    </div>
                    <br>
                    <div class="gap-4 flex items-center">

                        <div class="tab-buttons">
                            <button class="tab-button active" data-tab="toutes">Toutes</button>
                            <button class="tab-button" data-tab="en-ligne">En ligne</button>
                        </div>
                        <div class="button">
                            <a href="{{ route('dashboard.addSession')}}" class="py-2 px-3 bg-blue-700 text-white rounded-lg">Ajouter une session</a>
                        </div>
                    </div>
                </div>
                <div class="search-actions">
                    <input type="text" placeholder="Recherche..." class="search-input">
                    <button class="btn-primary" id="openModal"> Rechercher</button>
                </div>
            </div>
            
            

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr class="text-gray-600 text-sm uppercase">
                            <th class="px-6 py-3 text-left">#</th>
                            <th class="px-6 py-3 text-left">Nom</th>
                            <th class="px-6 py-3 text-left">Description</th>
                            <th class="px-6 py-3 text-center">Date début</th>
                            <th class="px-6 py-3 text-center">Date fin</th>
                            <th class="px-6 py-3 text-center">Statut</th>
                            <th class="px-6 py-3 text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse ($sessions as $index => $session)
                            <tr>
                                <td class="px-6 py-4">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">{{ $session->nom }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ Str::limit($session->description, 50) }}</td>
                                <td class="px-6 py-4 text-center">{{ $session->date_debut }}</td>
                                <td class="px-6 py-4 text-center">{{ $session->date_fin }}</td>

                                <td class="px-6 py-4 text-center">
                                    @if ($session->statut === 'active')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Active</span>
                                    @elseif ($session->statut === 'inactive')
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">Inactive</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Clôturée</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center space-x-2">
                                    <a href="{{ route('dashboard.detailSession', $session->id) }}"
                                    class="text-blue-600 hover:underline">Voir</a>

                                    <a href="{{ route('dashboard.editSession', $session->id) }}"
                                    class="text-yellow-500 hover:underline">Modifier</a>

                                    <form action="{{ route('dashboard.deleteSession', $session->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Supprimer cette session ?')"
                                                class="text-red-600 hover:underline">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-gray-500">
                                    Aucune session disponible pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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