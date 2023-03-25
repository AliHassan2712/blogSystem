<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
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
            'name' => 'required|string|min:3',
            'email' => 'required|string|unique:users,email',
            'cover' => 'nullable|image',
        ]);
        if (!$validator->fails()) {
            $user = new User();
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = Hash::make($request->get('password'));
            if ($request->has('cover')) {
                $image = $request->file('cover');
                $imgeName = time() . $user->name . '.' . $image->getClientOriginalExtension();
                $image->storePubliclyAs('users', $imgeName, ['disk' => 'public']);
                $user->cover = $imgeName;
            }
            $saved = $user->save();
            if ($saved) {
                return response()->json(
                    [
                        'message' => $saved ? 'User Created Successfully' : 'User Created failed'
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $validator = validator($request->all(), [
            'name' => 'required|string|min:3',
            'email' => 'required|string|unique:users,email',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user)],
            'cover' => 'nullable|image',
        ]);
        if (!$validator->fails()) {
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = Hash::make($request->get('password'));

            if ($request->has('cover')) {
                $image = $request->file('cover');
                $imgeName = time() . $user->name . '.' . $image->getClientOriginalExtension();
                $image->storePubliclyAs('users', $imgeName, ['disk' => 'public']);
                $user->cover = $imgeName;
            }
            $saved = $user->save();
            if ($saved) {
                return response()->json(
                    [
                        'message' => $saved ? 'User Updated Successfully' : 'User Updated failed'
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        Storage::disk('public')->delete("users/$user->cover");
        $deleted = $user->delete();

        return response()->json(
            [
                'message' => $deleted ? 'user Deleted Successfully' : 'user Deleted failed'
            ],
            $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }
}
