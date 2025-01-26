<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
    'required',
    'string',
    'email',
    'max:255',
    'lowercase', 
    'unique:'.User::class,
    function ($attribute, $value, $fail) {
        if (!str_contains($value, '.com')) {
            $fail('L\'email doit contenir ".com".');
        }
    },
],

            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'regex:/^[0-9]*$/', 'size:8', 'unique:utilisateur,telephone'],
            'birthdate' => 'required|date|before:today',
        ],
        [
            'name.required' => 'Entrez votre nom.',
            'name.string' => 'Le nom doit être une chaîne de charactère',
            'name.max' => 'Le nom ne peut pas dépasser 255 caractères.',
            'email.required' => 'Entrez votre adresse email.',
            'email.email' => "L'adresse email n'est pas valide.",
            'email.max' => "L'adresse email ne peut pas dépasser 255 caractères.",
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.required' => 'Entrez votre mot de passe.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'email.string' => "L'adresse email doit être une chaîne de caractères.",
            'email.lowercase' => "L'adresse email doit être en minuscule.",
            'password.password' => 'Votre mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.',
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'phone.regex' => 'Le format du numéro de téléphone est invalide. Il doit contenir uniquement des chiffres.',
            'phone.size' => 'Le numéro de téléphone doit être exactement de 8 chiffres.',
            'phone.unique' => 'Ce numéro de téléphone est déjà utilisé.',
            'birthdate.required' => 'La date de naissance est obligatoire.',
            'birthdate.date' => 'La date de naissance doit être une date valide.',
            'birthdate.before' => 'La date de naissance doit être antérieure à aujourd\'hui.',
        ]
    );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'date_naiss' => $request->birthdate,
            'telephone' => $request->phone,
            
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('welcome', absolute: false));
    }
}
