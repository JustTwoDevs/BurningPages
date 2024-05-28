<?php

namespace App\Http\Resources;

use App\Models\Review;
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

        $totalVerifiedRates = 0;
        $verifiedRatesCount = 0;
        $totalUnverifiedRates = 0;
        $unverifiedRatesCount = 0;
 
         foreach ($this->reviews as $review) {
            $newReview = Review::with(['user'])->findOrFail($review->review_id);
                 if ($newReview->user->verified === 1) {
                     $totalVerifiedRates += $newReview->rate; 
                     $verifiedRatesCount++;
                 } else if ($newReview->user->verified === 0){
                     $totalUnverifiedRates += $newReview->rate; 
                     $unverifiedRatesCount++;
                 }
         }
 
         $burningmeter = $verifiedRatesCount > 0 ? $totalVerifiedRates / $verifiedRatesCount : 0;
         $readerScore = $unverifiedRatesCount > 0 ? $totalUnverifiedRates / $unverifiedRatesCount : 0;
         
        return [
            'Code' => $this->id,
            'Title' => $this->title,
            'Synopsis' => $this->sinopsis,
            'Publication_Date' => $this->publication_date,
            'Original_language' => $this->original_language,
            'Purchase_link' => $this->buyLink,
            'Creation_date' => $this->created_at,
            'Last_update' => $this->updated_at,
            'Burningmeter' => $burningmeter,
            'Reader_Score' => $readerScore,
            'reviews' => $this->reviews,
            'Authors' => AuthorResource::collection($this->whenLoaded('authors')),
            'Genres' => GenreResource::collection($this->whenLoaded('genres')),
            'BookSagas' => BookSagaResource::collection($this->whenLoaded('bookSagas')),
            'Order_Saga' => $this->whenPivotLoaded('bookCollections', function () {
                return $this->pivot->order;
            }),
            'Cover' => $this->image_path,
        ];
    }
}
