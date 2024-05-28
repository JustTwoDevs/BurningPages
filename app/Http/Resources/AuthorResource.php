<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Code' => $this->id,
            'Name' => $this->name . ' ' . $this->lastname,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'Pseudonym' => $this->pseudonym,
            'Birth' => $this->birth_date,
            'Death' => $this->whenNotNull($this->death_date),
            'Biography' => $this->biography,
            'Nationality' => new NationalityResource($this->nationality),
            'Creation_date' => $this->created_at,
            'Last_update' => $this->updated_at,
            'Written_Books' => BookResource::collection($this->whenLoaded('books')),
            'Book_Sagas' => $this->bookSagas,
            'Genres' => $this->genres,
            'Cover' => $this->image_path,
        ];
    }
}
