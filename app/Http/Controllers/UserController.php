<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Mail\PinCode;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * @param RegistrationRequest $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function register(RegistrationRequest $request)
    {
        $invitation = Invitation::where('invitation_token', $request->invitation_token)->first();

        if($invitation){

            $user = new User([
                'name' => $request->name,
                'user_name' => $request->user_name,
                'user_role' => User::USER,
                'email' => $invitation->email,
                'password' => Hash::make($request->password),
            ]);

            $user->generatePinCode();
            $user->save();

            $data = $user->toArray();

            Mail::to($data['email'])->send(new PinCode($data));

            return response()->json("Kindly verify your pin code", 200);
        }
    }
}
