<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Review;

class BookSagaResource extends JsonResource
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
                 } else if ($newReview->user->verified === 0) {
                     $totalUnverifiedRates += $newReview->rate; 
                     $unverifiedRatesCount++;
                 }
         }
 
         $burningmeter = $verifiedRatesCount > 0 ? $totalVerifiedRates / $verifiedRatesCount : 0;
         $readerScore = $unverifiedRatesCount > 0 ? $totalUnverifiedRates / $unverifiedRatesCount : 0;
         
        return [
            'Code' => $this->id,
            'Name' => $this->name,
            'Synopsis' => $this->sinopsis,
            'Burningmeter' => $burningmeter,
            'Reader_Score' => $readerScore,
            'Creation_date' => $this->created_at,
            'Last_update' => $this->updated_at,
            'Books' => BookResource::collection($this->whenLoaded('books')),
            'Genres' => GenreResource::collection($this->genres),
            'Authors' => AuthorResource::collection($this->authors),
            'Cover' => $this->image_path,
        ];
    }
}
