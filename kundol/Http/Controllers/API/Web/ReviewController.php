<?php

namespace App\Http\Controllers\API\Web;

use App\Contract\Web\ReviewInterface;
use App\Http\Controllers\Controller as Controller;
use App\Http\Requests\ReviewRequest;
use App\Http\Requests\ReviewStatusRequest;
use App\Models\Web\Review;
use App\Repository\Web\ReviewRepository;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    private $ReviewRepository;

    public function __construct(ReviewInterface $ReviewRepository)
    {
        $this->ReviewRepository = $ReviewRepository;
    }

    public function index()
    {
        return $this->ReviewRepository->all();
    }

    public function store(ReviewRequest $request)
    {
        $parms = $request->all();
        return $this->ReviewRepository->store($parms);
    }

    public function status(ReviewStatusRequest $request)
    {
        $parms = $request->all();
        return $this->ReviewRepository->status($parms);
    }


    public function Update(Request $request,Review $review)
    {
        $request->validate([
            'title'=>'required',
            'comment'=>'required',
            'rating'=>'required'
        ]);

        $parms = $request->all();
        return $this->ReviewRepository->update($parms,$review);
    }
}
