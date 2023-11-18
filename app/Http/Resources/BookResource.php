<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'Title' => $this->title,
            'Synopsis' => $this->sinopsis,
            'Publication_Date' => $this->publication_date,
            'Original_language' => $this->original_language,
            'Purchase_link' => $this->buyLink,
            'Creation_date' => $this->created_at,
            'Last_update' => $this->updated_at,
            'Burningmeter' => $this->burningmeter,
            'Reader_Score' => $this->readerScore,
            'Authors' => AuthorResource::collection($this->whenLoaded('authors')),
            'Genres' => GenreResource::collection($this->whenLoaded('genres')),
            'BookSagas' => BookSagaResource::collection($this->whenLoaded('bookSagas')),
            'Order_Saga' => $this->whenPivotLoaded('bookCollections', function () {
                return $this->pivot->order;
            }),
        ];
    }
}
