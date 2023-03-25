<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $likes = Like::all();
        return view('admin.likes.index', compact('likes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.likes.create');
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
            'post_id' => 'required|integer',
            'user_id' => 'required|integer'
        ]);
        if (!$validator->fails()) {
            $like = new Like();
            $like->post_id = $request->get('post_id');
            $like->user_id = $request->get('user_id');

            $saved = $like->save();
            if ($saved) {
                return response()->json(
                    [
                        'message' => $saved ? 'Like Created Successfully' : 'Like Created failed'
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
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function edit(Like $like)
    {
        return view('admin.likes.edit', compact('like'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like)
    {
        $validator = validator($request->all(), [
            'post_id' => 'required|integer',
            'user_id' => 'required|integer'
        ]);
        if (!$validator->fails()) {
            $like->post_id = $request->get('post_id');
            $like->post_id = $request->get('user_id');

            $saved = $like->save();
            if ($saved) {
                return response()->json(
                    [
                        'message' => $saved ? 'Like Created Successfully' : 'Like Created failed'
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
     * @param  \App\Models\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Like $like)
    {
        $deleted = $like->delete();

        return response()->json(
            [
                'message' => $deleted ? 'Like Deleted Successfully' : 'Like Deleted failed'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
