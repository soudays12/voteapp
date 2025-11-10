<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de session</title>
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

<script>
    const sessionForm = document.getElementById('sessionForm');
    sessionForm.addEventListener('submit', function () {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'candidats';
        input.value = JSON.stringify(candidats);
        this.appendChild(input);
    });
</script>

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
                        <a href="{{ route('dashboard.candidates') }}" class="sidebar-link">
                            <i class="fas fa-coins icon"></i>
                            <span>Candidats</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.elections') }}" class="sidebar-link">
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
        <main class="main ">
            <div class="header p-5 sm:p5">
                <div>
                    <div class="menu-and-title">
                        <!-- Menu Toggle Button -->
                        <button id="toggleSidebar" class="toggle-button">
                            ☰
                        </button>
                        <h1 class="main-title">Inscription de session</h1>
                    </div>
                </div>
            </div>


            <!-- popup pour ajouter les utilisateurs -->
            <div id="modalOverlay"
                class="fixed inset-0 bg-black bg-opacity-40 hidden flex items-center justify-center">
                <!-- Popup -->
                <div class="bg-white w-[650px] rounded shadow-lg relative">
                    <!-- Contenu -->
                    <div class="max-h-[500px] overflow-y-auto p-4" style="we">
                        <form id="candidateForm" enctype="multipart/form-data" class="space-y-6" novalidate>
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
                            <button 
                                type="submit"
                                class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 rounded-md bg-indigo-600 text-white font-medium shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition"
                            >
                                <i class='bx bx-plus-circle text-lg'></i>
                                Ajouter le candidat
                            </button>
                        </form>

                    </div>
                </div>
            </div>
            <!-- popup -->



            <div class="p-5 sm:p-5">
                <ol class="flex items-center w-full mb-4 sm:mb-5">
                    <li class="flex w-full items-center text-blue-600 dark:text-blue-500 after:content-[''] after:w-full after:h-1 after:border-b after:border-blue-100 after:border-4 after:inline-block dark:after:border-blue-800">
                        <div class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full lg:h-12 lg:w-12 dark:bg-blue-800 shrink-0">
                            <svg class="w-4 h-4 text-blue-600 lg:w-6 lg:h-6 dark:text-blue-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
                                <path d="M18 0H2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2ZM6.5 3a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5ZM3.014 13.021l.157-.625A3.427 3.427 0 0 1 6.5 9.571a3.426 3.426 0 0 1 3.322 2.805l.159.622-6.967.023ZM16 12h-3a1 1 0 0 1 0-2h3a1 1 0 0 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Zm0-3h-3a1 1 0 1 1 0-2h3a1 1 0 1 1 0 2Z"/>
                            </svg>
                        </div>
                    </li>
                </ol>

                <div class="bg-white rounded-lg shadow p-6">
                    <form id="sessionForm" action="{{ route('dashboard.updateSession') }}" method="POST">
                        @csrf
                        <h3 class="mb-4 text-lg font-medium leading-none text-gray-900 dark:text-white">Nouvelle session</h3>
    
                        <input type="hidden" name="id" value="{{ $session->id }}">
                        <div class="grid gap-4 mb-4 sm:grid-cols-2">
    
                            <!-- Nom -->
                            <div class="sm:col-span-2">
                                <label for="nom" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom</label>
                                <input type="text" name="nom" id="nom"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                    value="{{ $session->nom}}"
                                    placeholder="Ex: Session électorale 2025" required>
                            </div>
                            <!-- Description -->
                            <div class="sm:col-span-2">
                                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea name="description" id="description" rows="4"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ $session->description }}
                                </textarea>
                            </div>
    
    
                            <!-- Date de début -->
                            <div id="date-debut-container" class="transition-all duration-300">
                                <label for="date_debut" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date de début</label>
                                <input type="date" name="date_debut" id="date_debut"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    value="{{ $session->date_debut}}">
                            </div>
    
                            <!-- Date de fin -->
                            <div>
                                <label for="date_fin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date de fin</label>
                                <input type="date" name="date_fin" id="date_fin"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    value="{{ $session->date_fin}}">
                            </div>
    
                        </div>
    
                        <button type="button"
                            id="openModal"
                            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
                            Inscrire un candidat
                        </button>
                        <input type="submit" value="Enregistrer les modifications"
                            class="text-white cursor-pointer bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700">
                    </form>
                </div>
            </div>

            


            <!-- candidats chisis pour l'election-->            
            <div class="candidats grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-5 sm:p-5">

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
                    
                    <div class="space-y-3">
                        <button class="bg-rose-50 border-gray-500 py-5 text-rose-600 font-semibold w-full max-h-full rounded-xl">
                            {{ $candidat->countvote }} {{ $candidat->countvote == 1 ? 'vote' : 'votes' }}
                        </button>
                        
                        @if(Auth::check())
                            <a href="{{ route('vote', ['candidat_id' => $candidat->id]) }}" class="block w-full">
                                <button class="bg-rose-500 hover:bg-rose-600 text-white font-semibold w-full py-3 rounded-xl transition shadow-md hover:shadow-lg">
                                    Retirer {{ $candidat->nom }}
                                </button>
                            </a>
                        @endif
                    </div>
                    </div>
                @endforeach

            </div>

            <!-- Candidats choisis pour l'élection -->
            <div id="candidatsContainer" class="candidats grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-5 sm:p-5">
                <!-- Les candidats ajoutés s'affichent ici -->
            </div>


        </main>
    </div>

    <script>
        // cacher/afficher la date de début selon la case cochée
        const demarrerCheckbox = document.getElementById('demarrer');
        const dateDebutContainer = document.getElementById('date-debut-container');

        demarrerCheckbox.addEventListener('change', () => {
            if (demarrerCheckbox.checked) {
                dateDebutContainer.style.display = 'none';
            } else {
                dateDebutContainer.style.display = 'block';
            }
        });




        // lmdskjmlfjdmlsjf
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
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) {
                modalOverlay.classList.remove('active');
            }
        });


         
        // 2 - formulaire d'ajout


        let candidats = [];

        // formulaire d'ajout
        const candidateForm = document.getElementById('candidateForm');
        const candidatsContainer = document.getElementById('candidatsContainer');

        
        candidateForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const nom = this.nom.value.trim();
            const description = this.description.value.trim();
            const file = this.image.files[0];
            let imagePreview = '';

            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    imagePreview = reader.result;
                    ajouterCandidat({ nom, description, imagePreview });

                    // 🟢 déplacer ici après que l'image est lue
                    document.getElementById('modalOverlay').classList.add('hidden');
                    this.reset();
                };
                reader.readAsDataURL(file);
            } else {
                ajouterCandidat({ nom, description, imagePreview });

                // 🟢 ici aussi pour le cas sans image
                document.getElementById('modalOverlay').classList.add('hidden');
                this.reset();
            }
        });


        function ajouterCandidat(candidat) {
            candidats.push(candidat);
            afficherCandidats();
        }

        function afficherCandidats() {
            candidatsContainer.innerHTML = ''; // vide la zone

            candidats.forEach((c, index) => {
                const div = document.createElement('div');
                div.classList.add('border', 'rounded-lg', 'shadow', 'p-4', 'bg-white', 'text-center');

                div.innerHTML = `
                    <img src="${c.imagePreview || 'https://via.placeholder.com/150'}" class="w-32 h-32 object-cover rounded-full mx-auto mb-2">
                    <h3 class="font-semibold text-gray-800">${c.nom}</h3>
                    <p class="text-sm text-gray-500">${c.description}</p>
                    <button onclick="supprimerCandidat(${index})" class="text-red-500 text-xs mt-2">Supprimer</button>
                `;

                candidatsContainer.appendChild(div);
            });
        }

        function supprimerCandidat(index) {
            candidats.splice(index, 1);
            afficherCandidats();
        }

        // ouverture modale
        document.getElementById('openModal').addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('modalOverlay').classList.remove('hidden');
        });
    </script>

</body>

</html>