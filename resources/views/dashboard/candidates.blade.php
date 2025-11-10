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
                        <a href="{{ route('dashboard.candidates') }}" class="sidebar-link active">
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
                        <h1 class="main-title">Gestion des candidats</h1>

                    </div>
                    <div class="tab-buttons">
                        <button class="tab-button active" data-tab="toutes">Toutes</button>
                        <button class="tab-button" data-tab="en-ligne">En ligne</button>
                    </div>
                </div>
                <div class="search-actions">
                    <input type="text" placeholder="Recherche..." class="search-input">
                    <button class="btn-primary">Rechercher</button>
                </div>
            </div>

            
            <!-- popup pour ajouter les candidats -->
            <div id="modalOverlay"
                class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center">
                <!-- Popup -->
                <div class="bg-white w-[650px] rounded shadow-lg relative">
                    <!-- Contenu -->
                    <div class="max-h-[500px] overflow-y-auto p-4" style="we">
                        <form id="candidateForm" action="{{ route('candidate.store') }}" method="post" enctype="multipart/form-data" class="space-y-6" novalidate>
                            @csrf

                            <!-- Section image -->
                            <label for="file" class="flex flex-col items-center border-2 border-dashed border-gray-300 rounded-xl p-6 bg-gray-50 hover:bg-gray-100 transition">
                                <input type="file" id="file" name="image" accept="image/*" hidden>
                                <div class="img-area text-center cursor-pointer" id="imgPreviewArea" data-img="">
                                    <i class='bx bxs-cloud-upload text-4xl text-indigo-500'></i>
                                    <h3 class="text-gray-700 font-semibold mt-2">Choisissez l'image du candidat</h3>
                                    <p class="text-sm text-gray-500">Pas plus grand que <span class="font-semibold text-indigo-600">2MB</span></p>
                                </div>
                                <button type="button" id="selectImage" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 transition">
                                    Choisir une image
                                </button>
                            </label>

                            <script>
                                const selectImage = document.getElementById('selectImage');
                                const inputFile = document.getElementById('file');
                                const imgArea = document.querySelector('.img-area');

                                selectImage.addEventListener('click', () => inputFile.click());

                                inputFile.addEventListener('change', () => {
                                    const image = inputFile.files[0];
                                    if (image && image.size < 2000000) {
                                        const reader = new FileReader();
                                        reader.onload = () => {
                                            imgArea.innerHTML = ''; // Vide la zone
                                            const img = document.createElement('img');
                                            img.src = reader.result;
                                            img.classList.add('w-32', 'h-32', 'object-cover', 'rounded-md', 'mx-auto');
                                            imgArea.appendChild(img);
                                        };
                                        reader.readAsDataURL(image);
                                    } else {
                                        alert("L'image dépasse 2 Mo ou n'est pas valide !");
                                    }
                                });
                            </script>


                            <!-- Nom -->
                            <label class="block">
                                <span class="text-sm font-medium text-gray-700">Nom</span>
                                <input 
                                    type="text" 
                                    name="nom" 
                                    required 
                                    placeholder="Nom du candidat"
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
                                />
                            </label>


                             <!-- session -->
                            <label class="block">
                                <h3 class="text-sm font-medium text-gray-700">Session</h3>
                               
                                <select name="session_id" id=""
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                                    @foreach ($sessions as $session)
                                        <option value="{{ $session->id }}">{{ $session->nom }}</option>
                                    @endforeach
                                </select>
                            </label>
                            

                            <!-- Description -->
                            <label class="block">
                                <span class="text-sm font-medium text-gray-700">Description</span>
                                <textarea 
                                    name="description" 
                                    rows="4"
                                    required
                                    placeholder="Description du projet"
                                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 resize-none"
                                ></textarea>
                            </label>

                           


                            <!-- Bouton de soumission -->
                            <button type="submit"
                                class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 rounded-md bg-indigo-600 text-white font-medium shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                                <i class='bx bx-plus-circle text-lg'></i>
                                Ajouter le candidat
                            </button>
                        </form>

                    </div>
                </div>
            </div>
            <!-- popup -->


            <!-- Tabs content -->
            <div id="toutes" class="tab-content active">
                <div class="grid-content">
                    <!-- Table -->
                    <div class="table-section">
                        <div class="flex space-x-11 py-2">
                            <h3 class="section-title">Liste des candidats</h3>
                            <button class="btn-primary" id="openModal">+ Ajouter un candidat</button>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nom du candidat</th>
                                    <th>Description</th>
                                    <th>Photo</th>
                                    <th>Votes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($candidats as $candidat)
                                <tr v-for="i in 5">
                                    <td>{{ $candidat-> nom }}<br><span class="text-muted">Abdou Rahman</span></td>
                                    <td>{{ $candidat-> description }}</td>
                                    <td>
                                        <img src="{{ asset('images/' . $candidat->photo) }}" alt="{{ $candidat->nom }}" class="w-16 h-16 object-cover rounded">
                                    </td>
                                    <td>{{ $candidat-> countvote }}</td> 
                                    <td>
                                        <a href="{{ route('candidate.detail', ['candidat_id' => $candidat->id]) }}" role="button">
                                            <i class="fas fa-eye bg-cyan-100 rounded-2 px-2 py-2 text-cyan-600" style="cursor: pointer;"></i>
                                        </a>

                                        <a href="{{ route('candidate.edit', ['candidat_id' => $candidat->id]) }}" 
                                        role="button" 
                                        onclick="alert('Attention, vous voulez modifier les informations du candidat {{ $candidat->nom }} ?')">
                                            <i class="fas fa-pen bg-indigo-100 rounded-2 px-2 py-2 text-indigo-600" style="cursor: pointer;"></i>
                                        </a>

                                        <a href="{{ route('candidate.delete', ['candidat_id' => $candidat->id]) }}" 
                                        role="button"  
                                        onclick="alert('Attention, vous allez supprimer l’utilisateur {{ $candidat->nom }} !')">
                                            <i class="fas fa-trash bg-rose-100 rounded-2 px-2 py-2 text-rose-600" style="cursor: pointer;"></i>
                                        </a>

                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Clients -->
                    <div class="client-section">
                        <h3 class="section-title">Nouveaux candidats</h3>
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



        /* partie modal */
        const openModal = document.getElementById('openModal');
        const closeModal = document.getElementById('closeModal');
        const modalOverlay = document.getElementById('modalOverlay');

        // Ouvrir le popup
        openModal.addEventListener('click', (e) => {
            e.preventDefault();
            modalOverlay.classList.add('active'); // 👈 affiche le modal
        });

        // Fermer via le bouton "X"
        closeModal.addEventListener('click', () => {
            modalOverlay.classList.remove('active'); // 👈 cache le modal
        });

        // Fermer en cliquant à l’extérieur du popup
        document.addEventListener('click', (e) => {
            if (e.target === modalOverlay) {
                modalOverlay.classList.remove('active');
            }
        });


    </script>
</body>

</html>