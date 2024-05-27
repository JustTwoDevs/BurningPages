<?php

namespace App\Http\Resources\api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpKernel\Profiler\Profile;
use App\Http\Resources\api\ProfileResource;

class BookReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'code' => $this->id,
            'user' => $this->reviewRate->user->user,
            'bookReview' => $this->load('bookReview')->bookReview->review,
           'value' => $this->reviewRate->value,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at, 
        ];
    }
}
