@extends('dashboard.layout')

@section('session')

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
                
                
                <!-- session id -->
                <input type="hidden" name="session_id" value="{{ $session->id }}"/>

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


<div class="p-6 bg-white rounded-lg shadow-lg">
    <div class="flex justify-between items-center border-b pb-4 mb-4">
        <h2 class="text-2xl font-bold text-indigo-700">
            🗓️ Détails de la session : {{ $session->titre }}
        </h2>
        <a href="{{ route('dashboard.sessions') }}" 
           class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="grid md:grid-cols-2 gap-6 mb-8">
        <div class="p-4 bg-blue-50 rounded-lg">
            <h3 class="font-semibold text-gray-700 mb-2">📋 Description</h3>
            <p class="text-gray-600">{{ $session->description }}</p>
        </div>

        <div class="p-4 bg-green-50 rounded-lg">
            <h3 class="font-semibold text-gray-700 mb-2">📅 Informations</h3>
            <p><strong>Début :</strong> {{ $session->date_debut }}</p>
            <p><strong>Fin :</strong> {{ $session->date_fin }}</p>
            <p><strong>Statut :</strong> 
                <span class="px-2 py-1 rounded text-white
                    @if($session->statut == 'active') bg-green-600
                    @elseif($session->statut == 'terminée') bg-blue-600
                    @else bg-gray-500 @endif">
                    {{ ucfirst($session->statut) }}
                </span>
            </p>
        </div>
    </div>

    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold text-gray-800">👥 Candidats inscrits</h3>
        <a href="#" id="openModal" class=" bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition openModal"
           data-id="{{ $session->id }}">
            <i class="fas fa-plus-circle"></i> Ajouter un candidat
        </a>
    </div>

    @if($session->candidates->isEmpty())
        <p class="text-gray-500 italic">Aucun candidat pour cette session.</p>
    @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($session->candidates as $candidate)
                <div class="bg-blue-100 p-4 rounded-lg shadow hover:shadow-lg transition">
                    <img src="{{ asset('storage/' . $candidate->image) }}" 
                         alt="{{ $candidate->nom }}" 
                         class="w-full h-40 object-cover rounded-lg mb-3">
                    <h4 class="text-lg font-semibold text-indigo-700">{{ $candidate->nom }}</h4>
                    <p class="text-sm text-gray-600">{{ Str::limit($candidate->description, 100) }}</p>
                    <div class="flex justify-between items-center mt-3 text-sm">
                        <a href="#" class="text-cyan-600 hover:text-cyan-800"><i class="fas fa-eye"></i> Voir</a>
                        <a href="#" class="text-yellow-600 hover:text-yellow-800"><i class="fas fa-pen"></i> Modifier</a>
                        <a href="#" class="text-rose-600 hover:text-rose-800"><i class="fas fa-trash"></i> Supprimer</a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>

    const openModal = document.getElementById('openModal');
    const modalOverlay = document.getElementById('modalOverlay');
    const sessionInput = document.getElementById('hidden_session');

    
    openModal.addEventListener('click', (e) => {
        modalOverlay.classList.remove('hidden');
    });
    

    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) {
            modalOverlay.classList.add('hidden');
        }
    });


</script>

@endsection