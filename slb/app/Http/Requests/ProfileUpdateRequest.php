<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'telephone' => ['regex:/^\d{8}$/','unique:utilisateur,telephone,'. $this->user()->id],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            
            [
                'name.required'=>'Veuillez entrer votre nom',
                'name.string'=>'Le nom doit être une chaîne de caractères',
                'name.max'=>'Le nom ne doit pas dépasser 255 caractères',
                'email.required'=>'Veuillez entrer votre adresse email',
                'email.string'=>"L'adresse email doit être une chaîne de caractères",
                'email.lowercase'=>'L\'adresse email doit être en minuscules',
                'email.email'=>'L\'adresse email n\'est pas valide',
                'email.max'=>'L\'adresse email ne doit pas dépasser 255 caractères',
                'email.unique'=>'Cette adresse email est déjà utilisée',
                'telephone.regex'=>'Le numéro de téléphone doit contenir seulement des chiffres',
                'telephone.size'=>'Le numéro de téléphone doit avoir une taille de 8 caractères',
                'telephone.unique'=>'Ce numéro de téléphone est déjà utilisé'  // Add custom message for unique
                
            ]
        ];
    }
}
