<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Connexion</title>
  @vite('resources/css/app.css')
</head>
<body class="min-h-screen bg-gray-50 flex items-center justify-center p-6">
  
  @foreach ($errors->all() as $error)
    {{ $error }} <br />
  @endforeach
  <main class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
    <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Inscription</h1>

    <!-- Zone pour messages d'erreur globaux -->
    <div id="form-error" class="hidden mb-4 text-sm text-red-700 bg-red-100 p-3 rounded"></div>

    <form id="loginForm" action="{{ route('register') }}" method="POST" class="space-y-5" novalidate>
        @csrf

        <!-- 1 -Champ nom -->
        <label class="block">
          <span class="text-sm font-medium text-gray-700">Nom</span>
          <input type="text" name="nom" required placeholder="Votre nom"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
          />
        </label>


        <!-- 2 -Champ prénom -->
        <label class="block">
          <span class="text-sm font-medium text-gray-700">Prénom</span>
          <input type="text" name="prenom" required placeholder="Votre prénom"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
          />
        </label>


        <!-- 3 -Champ adresse e-mail -->
        <label class="block">
          <span class="text-sm font-medium text-gray-700">Adresse e-mail</span>
          <input type="email" name="email" required autofocus placeholder="prenom.nom@example.com"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
            aria-describedby="emailHelp"
          />
        </label>

        <!-- 4 -Mot de passe -->
        <label class="block relative">
          <span class="text-sm font-medium text-gray-700">Mot de passe</span>
          <input id="password" type="password" name="password" required minlength="6" placeholder="••••••••"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-4 py-2 pr-12 focus:outline-none focus:ring-2 focus:ring-indigo-400"
            aria-describedby="pwdHelp"
          />
          <!-- bouton show/hide -->
          <button type="button" id="togglePwd" aria-label="Afficher le mot de passe"
                  class="absolute right-2 top-9 transform -translate-y-1/2 text-sm text-gray-500 hover:text-gray-700">
            Afficher
          </button>
        </label>

        <!-- Remember + forgot -->
        <div class="flex items-center justify-between text-sm">
          <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
            <span>Se souvenir de moi</span>
          </label>
          <a href="#" class="text-indigo-600 hover:underline">Mot de passe oublié ?</a>
        </div>

        <!-- Submit -->
        <button type="submit"
                class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 rounded-md bg-indigo-600 text-white font-medium shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-400">
          S'inscrire'
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-gray-600">
      Pas encore de compte ?
      <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">se connecter</a>
    </p>
  </main>

  <script>
    // Toggle mot de passe
    const pwd = document.getElementById('password');
    const toggle = document.getElementById('togglePwd');
    toggle.addEventListener('click', () => {
      if (pwd.type === 'password') {
        pwd.type = 'text';
        toggle.textContent = 'Cacher';
        toggle.setAttribute('aria-label','Cacher le mot de passe');
      } else {
        pwd.type = 'password';
        toggle.textContent = 'Afficher';
        toggle.setAttribute('aria-label','Afficher le mot de passe');
      }
    });

    // Exemples simples de validation côté client (optionnel)
    const form = document.getElementById('loginForm');
    const formError = document.getElementById('form-error');
    form.addEventListener('submit', (e) => {
      formError.classList.add('hidden');
      if (!form.checkValidity()) {
        e.preventDefault();
        formError.textContent = 'Merci de remplir correctement le formulaire.';
        formError.classList.remove('hidden');
      }
    });
  </script>
</body>
</html>