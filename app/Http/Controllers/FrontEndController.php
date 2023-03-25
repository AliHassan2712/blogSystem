<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FrontEndController extends Controller
{
    public function addPost(){
        return view('frontEnd.addpost');
    }

    public function home(){
        $posts=Post::all();
        return view('home',compact('posts'));
    }


    public function deletePost(Post $post){
              
        $deleted = $post->delete();

        return response()->json(
            [
                'message' => $deleted ? 'Post Deleted Successfully' : 'Post Deleted failed'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );

    }


    public function storePost(Request $request){
        
        $validator = validator($request->all(), [
            'content' => 'required|string|min:3'
        ]);
        if (!$validator->fails()) {
            $post = new Post();
            $post->content = $request->get('content');
            $post->likes_no = 0;
            $post->coments_no = count($post->comments);
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


    public function updatePost(Request $request, $id){
        $validator = validator($request->all(), [
            'content' => 'required|string|min:3'
        ]);
        if (!$validator->fails()) {

            $post=Post::find($id);
            $post->content = $request->get('content');
            $post->likes_no = 0;
            $post->coments_no =count($post->comments);
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

    public function editPost($id){
        $post = Post::find($id);
        return view('frontEnd.editpost',compact('post'));
    }


    //////////////////////////////////////////////////////


    public function storeComment(Request $request)  {
        $validator = validator($request->all(), [
            'post_id' => 'required|integer',
            'user_id' => 'required|integer'
        ]);
        if (!$validator->fails()) {
            $comment = new Comment();
            $comment->content = $request->get('content');
            $comment->post_id = $request->get('post_id');
            $comment->user_id = $request->get('user_id');

            $saved = $comment->save();
            if ($saved) {
                return response()->json(
                    [
                        'message' => $saved ? 'Coment Created Successfully' : 'Coment Created failed'
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

        

}

