<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    use ApiResponse;

    public function store(Request $request)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'min:3', 'max:2000'],
        ]);

        $feedback = Feedback::create([
            'user_id' => $request->user()->id,
            'message' => $data['message'],
        ]);

        return $this->created([
            'id' => $feedback->id,
        ], 'Thanks for your feedback.');
    }
}
