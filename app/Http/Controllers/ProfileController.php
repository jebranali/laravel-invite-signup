<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getUser(Request $request)
    {
        return $request->user();
    }

    public function profileUpdate(ProfileUpdateRequest $request)
    {
        $user = $request->user();
        $user->name = $request->name;
        $user->user_name = $request->user_name;

        if($request->hasFile('avatar')){

            $image_name = time().'.'.$request->image->extension();
            $request->image->move(public_path('avatars'), $image_name);
            $user->avatar = $image_name;
            $user->save();
        }

        return response()->json("Image saved successfully", 200);
    }
}
