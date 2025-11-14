@extends('dashboard.layout')

@section('session')



<div class="bg-white rounded shadow-lg relative">
    <!-- Contenu -->
    <div class="overflow-y-auto p-4" style="we">
        <form id="candidateForm" action="{{ route('candidate.update', $candidate_info->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6" novalidate>
            @csrf
            @method('PUT')
    
            <!-- Section image -->
            <div class="space-y-4">
                <label class="block text-sm font-medium text-gray-700">Photo actuelle</label>
                <div class="flex justify-center">
                    <img src="{{ asset('images/' . $candidate_info->photo) }}" alt="{{ $candidate_info->nom }}" class="w-32 h-32 object-cover rounded-lg border">
                </div>
                
                <label for="file" class="flex flex-col items-center border-2 border-dashed border-gray-300 rounded-xl p-6 bg-gray-50 hover:bg-gray-100 transition">
                    <input type="file" id="file" name="image" accept="image/*" hidden>
                    <div class="img-area text-center cursor-pointer" id="imgPreviewArea" data-img="">
                        <i class='bx bxs-cloud-upload text-4xl text-indigo-500'></i>
                        <h3 class="text-gray-700 font-semibold mt-2">Changer l'image (optionnel)</h3>
                        <p class="text-sm text-gray-500">Pas plus grand que <span class="font-semibold text-indigo-600">2MB</span></p>
                    </div>
                    <button type="button" id="selectImage" class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700 transition">
                        Choisir une nouvelle image
                    </button>
                </label>
            </div>
    
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
                    value="{{ $candidate_info->nom }}"
                    placeholder="Nom du candidat"
                    class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400"
                />
            </label>
    
            <!-- session -->
            <label class="block">
                <h3 class="text-sm font-medium text-gray-700">Session</h3>
                <select name="session_id" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                    @foreach ($sessions as $session)
                        <option value="{{ $session->id }}" {{ $session->id == $candidate_info->session_id ? 'selected' : '' }}>
                            {{ $session->nom }}
                        </option>
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
                >{{ $candidate_info->description }}</textarea>
            </label>
    
            
    
    
            <!-- Bouton de soumission -->
            <button type="submit"
                class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 rounded-md bg-indigo-600 text-white font-medium shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400 transition">
                <i class='bx bx-edit text-lg'></i>
                Modifier le candidat
            </button>
        </form>
    
    </div>
</div>
@endsection