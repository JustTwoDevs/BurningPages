<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Resources\api\GReviewResource;
use App\Http\Requests\api\v1\ReviewUpdateRequest;
use App\Models\RegisteredUser;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   

        $reviews = Review::with('user')->orderBy('user_id', 'asc')->get();
        $publishedReviews = $reviews->filter(function ($review) {
            return $review->state === 'published';
        });
        $query = request()->query();
       
        if (isset($query['content'])) {
           
            $search = str_replace('-', ' ', $query['content']);
           
            $publishedReviews = $publishedReviews->where(function ($query) use ($search) {
                $query->where('content', 'like', '%' . $search . '%');
            });
            
        }
        
        if (isset($query['rate'])) {
            $rate = explode(',', $query['rate']);
            $publishedReviews = $publishedReviews->whereBetween($rate, $rate);
          
        }

        if (isset($query['state'])) {
            $search = str_replace('-', ' ', $query['state']);
        
            $publishedReviews = $publishedReviews->where(function ($q) use ($search) {
                $q->where('state', 'like',  $search );
            });
        }

    
        

        return response()->json(['reviews' => GReviewResource::collection($publishedReviews)], 200);
    }

    public function indexMyReviews()
    {
        $user = auth()->user();
        $registeredUser = RegisteredUser::query()->where('user_id', $user['id'])->first();
        if (!$registeredUser) {
            return response()->json(['message' => 'user not found'], 404);
        }
        $registeredUser->load('reviews');
        
        return response()->json(['reviews' =>  GReviewResource::collection($registeredUser->reviews)], 200);
    }

    public function indexAdmin(){
        $reviews = Review::with('user')->orderBy('user_id', 'asc')->get();
        return response()->json(['reviews' => GReviewResource::collection($reviews)], 200);
    }

    public function publishAdmin(Request $request, Review $review)
    {
        if ($review->state === 'occult') {
            $review->state = 'published';
            $review->save();
            return response()->json(['review' => new GReviewResource($review)]);
        }
        return response()->json(['message' => 'review is not occult'], 400);
    }

    public function publishRegistered(Review $review)
    {
        if ($review->state === 'draft') {
            $review->state = 'published';
            $review->save();
            return response()->json(['review' => new GReviewResource($review)]);
        }
        return response()->json(['message' => 'review is not a draft'], 400);
    }

    public function occult( Review $review)
    {
        if ($review->state === 'published') {
            $review->state = 'hidden';
            $review->save();
            return response()->json(['review' => new GReviewResource($review)]);
        }
        return response()->json(['message' => 'review is not published'], 400);
    }

    public function draft( Review $review)
    {
        if ($review->state === 'published') {
            $review->state = 'draft';
            $review->save();
            return response()->json(['review' => new GReviewResource($review)]);
        }
        return response()->json(['message' => 'review is not published'], 400);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return response(null, 204);
    }

   


    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        $review->load([ 'user']);
        if ($review->state === 'published') {
            return response()->json(['review' => new GReviewResource($review)], 200);
        } else {
            return response()->json(['message' => 'review not found'], 404);
        }
       
    }

    public function showRegistered(Review $review)
    {
        $user = auth()->user();
        $registeredUser = RegisteredUser::query()->where('user_id', $user['id'])->first();

        $review->load([ 'user']);
        if ($review->state === 'published'|| $review->user->id === $registeredUser->id) {
            return response()->json(['review' => new GReviewResource($review)], 200);
        } else {
            
            return response()->json(['message' => 'review not found'], 404);
        }
       
    }
    public function showAdmin(Review $review)
    {
        $review->load([ 'user']);
    
        return response()->json(['review' => new GReviewResource($review)], 200);
    }

   

    public function indexByUser( string $user)
    {
        $user = RegisteredUser::find($user);
        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }

        $user->load( 'reviews.user');

        $publishedReviews = $user->reviews->filter(function ($review) {
            return $review->state === 'published';
        });

        return response()->json(['reviews' => $publishedReviews], 200);
    }

    public function indexByUserAdmin( string $user)
    {
        $user = RegisteredUser::find($user);
        if (!$user) {
            return response()->json(['message' => 'user not found'], 404);
        }

        $user->load('reviews');
       
     
        return response()->json(['reviews' => GReviewResource::collection($user->reviews)], 200);
    }


   
}
