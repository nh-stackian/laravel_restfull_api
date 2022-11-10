<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
// use Image;
// use Intervention\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      return new UserCollection(User::paginate(5));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {




        // $formFields = $request->validate([
        //     'name'   => 'required|required|max:255',
        //     'email'  => 'required|email|max:255',
        //     //'image'  => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        //     'image' => '',
        //     'gender' => 'required',
        //     'skills' => 'required',

        // ]);


        // if($request->hasFile('image')) {
        //     $formFields['image'] = $request->file('image')->store('images', 'public');
        // }





        // if($request->image!=""){
        //     // $strpos = str($request->image, ';');
        //     // $sub = substr($request->image,0,$strpos);
        //     // $ex = explode('/',$sub)[1];
        //     // $name = time().".".$ex;
        //     // $img = Image::make($request->image)->resize(200,200);
        //     $upload_path = public_path()."/images/";
        //     $img->save($upload_path.$name);
        //     $request->image = $name;
        // }else{
        //     $request->image = "image.png";
        // }





         $request->validated();

        $image_path = $request->file('image')->store('images', 'public');

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $image_path,
            'gender' => $request->gender,
            'skills' => $request->skills,
        ]);

        //User::create();

        return response()->json('user created');



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $formFields = $request->validate([
            'name'   => 'required|required|max:255',
            'email'  => 'required|email|max:255',
            'image'  => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'gender' => 'required',
            'skills' => 'required',
            'password' => 'required',
        ]);


        if($request->hasFile('image')) {
            $formFields['image'] = $request->file('image')->store('images', 'public');
        }

        $user->update($formFields);

        return response()->json('user created');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json("user deleted");
    }
}
