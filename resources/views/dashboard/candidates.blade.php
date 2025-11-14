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

<!-- Table -->
<div class="table-section">
    <div class="flex items-center justify-between py-4 mb-6">
        <h3 class="section-title text-xl font-semibold text-gray-800">Liste des candidats</h3>
        <button class="btn-primary flex items-center space-x-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition" id="openModal">
            <i class="fas fa-plus"></i>
            <span>Ajouter un candidat</span>
        </button>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Nom du candidat</th>
                <th>Description</th>
                <th>Photo</th>
                <th>Votes</th>
                <th>Pourcentage</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($candidatsWithPercentage as $candidat)
            <tr>
                <td>{{ $candidat->nom }}<br><span class="text-muted">Candidat</span></td>
                <td>{{ $candidat->description }}</td>
                <td>
                    <img src="{{ asset('images/' . $candidat->photo) }}" alt="{{ $candidat->nom }}" class="w-16 h-16 object-cover rounded">
                </td>
                <td>{{ $candidat->vote()->count() }}</td>
                <td><span class="font-semibold text-indigo-600">{{ $candidat->percentage }}%</span></td> 
                <td>
                    <div class="flex items-center justify-center space-x-2">
                        <a href="{{ route('candidate.detail', ['candidat_id' => $candidat->id]) }}" 
                           class="inline-flex items-center justify-center w-8 h-8 bg-cyan-100 hover:bg-cyan-200 rounded-full transition-colors" 
                           title="Voir les détails">
                            <i class="fas fa-eye text-cyan-600 text-sm"></i>
                        </a>

                        <a href="{{ route('candidate.edit', ['candidat_id' => $candidat->id]) }}" 
                           class="inline-flex items-center justify-center w-8 h-8 bg-indigo-100 hover:bg-indigo-200 rounded-full transition-colors" 
                           title="Modifier"
                           onclick="return confirm('Modifier les informations de {{ $candidat->nom }} ?')">
                            <i class="fas fa-pen text-indigo-600 text-sm"></i>
                        </a>

                        <a href="{{ route('candidate.delete', ['candidat_id' => $candidat->id]) }}" 
                           class="inline-flex items-center justify-center w-8 h-8 bg-rose-100 hover:bg-rose-200 rounded-full transition-colors" 
                           title="Supprimer"
                           onclick="return confirm('Supprimer le candidat {{ $candidat->nom }} ?')">
                            <i class="fas fa-trash text-rose-600 text-sm"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    /* partie modal */
    const openModal = document.getElementById('openModal');
    const closeModal = document.getElementById('closeModal');
    const modalOverlay = document.getElementById('modalOverlay');

    // Ouvrir le popup
    openModal.addEventListener('click', (e) => {
        e.preventDefault();
        modalOverlay.classList.add('active');
    });

    // Fermer via le bouton "X"
    closeModal.addEventListener('click', () => {
        modalOverlay.classList.remove('active');
    });

    // Fermer en cliquant à l'extérieur du popup
    document.addEventListener('click', (e) => {
        if (e.target === modalOverlay) {
            modalOverlay.classList.remove('active');
        }
    });
</script>
@endsection