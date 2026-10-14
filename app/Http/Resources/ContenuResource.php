<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'categorie' => $this->categorie,
            'description' => $this->description,
            'auteur' => $this->whenLoaded('auteur', fn () => [
                'id' => $this->auteur->id,
                'nom' => $this->auteur->nom,
            ]),
            'categories' => $this->whenLoaded('categories', fn () => $this->categories->pluck('nom')),
        ];
    }
}
