<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreContenuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'titre' => 'required|string|max:255',
            'categorie' => 'required|string',
            'description' => 'nullable|string',
        ];

        if ($this->isMethod('post')) {
            $rules['auteur_id'] = 'required|integer|exists:auteurs,id';
        } else {
            $rules['auteur_id'] = 'sometimes|integer|exists:auteurs,id';
        }

        return $rules;
    }
}
