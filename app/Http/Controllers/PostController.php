<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $posts = Post::all();
         return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            'content' => 'required|string|min:3'
        ]);
        if (!$validator->fails()) {
            $post = new Post();
            $post->content = $request->get('content');
            $post->likes_no = 0;
            $post->coments_no = 0;
            $post->user_id = $request->get('user_id');

            $saved = $post->save();
            if ($saved) {
                return response()->json(
                    [
                        'message' => $saved ? 'Post Created Successfully' : 'Post Created failed'
                    ],
                    $saved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST

                );
            }
        } else {
            return response()->json(
                [
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('frontEnd.editpost', compact('post'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validator = validator($request->all(), [
            'content' => 'required|string|min:3'
        ]);
        if (!$validator->fails()) {

            $post->content = $request->get('content');
            $post->likes_no = 0;
            $post->coments_no = 0;
            $post->user_id = $request->get('user_id');

            $saved = $post->save();
            if ($saved) {
                return response()->json(
                    [
                        'message' => $saved ? 'Post Updated Successfully' : 'Post Updated failed'
                    ],
                    $saved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST

                );
            }
        } else {
            return response()->json(
                [
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

       
        $deleted = $post->delete();

        return response()->json(
            [
                'message' => $deleted ? 'Post Deleted Successfully' : 'Post Deleted failed'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );

        
    }
}
