<?php

namespace App\Http\Controllers;
use App\Models\Website;
use App\Models\Post;
use Illuminate\Http\Request;



class postController extends Controller
{
    public function store(Request $request)
    {
        $websiteId = $request->website;

        $validator = validator($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors(), 'errorCode' => Response::HTTP_UNPROCESSABLE_ENTITY], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = $validator->validated();
        $post = new Post($data);
        $post->website_id = $websiteId; // Set the website_id explicitly
        $post->save();

        return response()->json(['message' => 'Post created successfully'], Response::HTTP_CREATED);
    }
}
