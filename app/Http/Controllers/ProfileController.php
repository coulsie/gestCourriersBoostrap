<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Met à jour les informations du profil dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // 1. Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // 2. Valider les données de la requête
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // La règle 'unique:users' doit ignorer l'ID de l'utilisateur actuel
            'email' => ['required','string','email','max:255',Rule::unique('users')->ignore($user->id),],
            // Ajoutez ici d'autres champs personnalisés si nécessaire :
            // 'phone_number' => 'nullable|string|max:20',
        ]);

        // 3. Mettre à jour les attributs de l'utilisateur
        $user = auth::user();

        if ($user) {
            $user->update($validatedData);
        }


        // 4. Rediriger l'utilisateur vers une autre page (généralement la page d'affichage du profil)
        // avec un message de succès flashé dans la session.
        return redirect()->route('profile.show')->with('status', 'Votre profil a été mis à jour avec succès !');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

     public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'role' => 'required|in:user,admin',
        ]);

        // Logique de stockage de la photo si présente
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('agents_photos', 'public');
            $validated['document'] = $path;
        }

        // Création de l'entrée en base de données
        // User::create($validated);

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Le profil a été créé avec succès.');
    }


     public function create()
    {
        // On retourne la vue située dans resources/views/profil/create.blade.php
        return view('profile.create');
    }


        public function updatePassword(Request $request)
    {
        // 1. Validation stricte
        $request->validate([
            'current_password' => ['required', 'current_password'], // Vérifie l'ancien MDP
            'password' => ['required', 'confirmed', 'min:8'],       // Nouveau + Confirmation
        ]);

        // 2. Mise à jour sécurisée
        $user = $request->user();
        $user->update([
            'password' => Hash::make($request->password),
            'password_changed_at' => now(), // Assurez-vous que cette colonne existe
        ]);

        return back()->with('status', 'Votre mot de passe a été mis à jour avec succès !');
    }



    public function updateSignature(Request $request)
    {
        // 1. Validation avec messages personnalisés
        $request->validate([
            'signature_data' => 'required_without:signature_file',
            'signature_file' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ], [
            'signature_file.mimes' => 'Le fichier doit être au format PNG, JPG ou JPEG.',
            'signature_file.image' => 'Le fichier sélectionné doit être une image.',
            'signature_file.max'   => 'L’image est trop lourde (maximum 2 Mo).',
            'signature_data.required_without' => 'Veuillez soit dessiner votre signature, soit importer un fichier.',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();
        $oldSignature = $user->signature_path;
        $fileName = null;
        $destinationPath = public_path('signatures');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // 2. Traitement selon l'option choisie
        if ($request->hasFile('signature_file')) {
            // CAS A : Fichier scanné (Prioritaire si les deux sont remplis)
            $file = $request->file('signature_file');
            $fileName = 'scan_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
        }
        elseif ($request->filled('signature_data')) {
            // CAS B : Dessin sur Canvas
            $data = $request->signature_data;
            $image = str_replace(['data:image/png;base64,', ' '], ['', '+'], $data);
            $fileName = 'pad_' . $user->id . '_' . time() . '.png';
            file_put_contents($destinationPath . '/' . $fileName, base64_decode($image));
        }

        // 3. Enregistrement et Log
        if ($fileName) {
            // Optionnel : supprimer l'ancien fichier physique pour libérer de l'espace
            if ($oldSignature && file_exists($destinationPath . '/' . $oldSignature)) {
                @unlink($destinationPath . '/' . $oldSignature);
            }

            $user->update(['signature_path' => $fileName]);

            \App\Models\AuditLog::create([
                'user_id'        => $user->id,
                'event'          => $request->hasFile('signature_file') ? 'Upload signature scannée' : 'Mise à jour signature pad',
                'auditable_type' => 'User',
                'auditable_id'   => $user->id,
                'old_values'     => json_encode(['path' => $oldSignature]),
                'new_values'     => json_encode(['path' => $fileName]),
                'url'            => $request->fullUrl(),
                'ip_address'     => $request->ip(),
                'user_agent'     => $request->userAgent(),
                'method'         => $request->method(),
            ]);

            return back()->with('success', 'Signature enregistrée avec succès.');
        }

        return back()->with('error', 'Erreur : Aucune donnée de signature reçue.');
    }


    /**
     * Affiche la vue pour capturer la signature.
     */
    public function editSignature()
    {
        // On récupère l'utilisateur connecté pour passer ses infos à la vue
        $user = auth::user();

        return view('profile.signature', compact('user'));
    }


}

