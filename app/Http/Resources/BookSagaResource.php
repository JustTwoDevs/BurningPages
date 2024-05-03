<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookSagaResource extends JsonResource
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
            'Name' => $this->name,
            'Synopsis' => $this->sinopsis,
            'Burningmeter' => $this->burningmeter,
            'Reader_Score' => $this->readerScore,
            'Creation_date' => $this->created_at,
            'Last_update' => $this->updated_at,
            'Books' => BookResource::collection($this->whenLoaded('books')),
            'Genres' => GenreResource::collection($this->whenLoaded('genres')),
            'Authors' => AuthorResource::collection($this->whenLoaded('authors')),
            'Cover' => $this->image_path,
        ];
    }
}
