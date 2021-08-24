<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\VerifyPinRequest;
use App\Mail\PinCode;
use App\Models\Invitation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
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

    /**
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if($user && $user->pin_code != null){
            throw ValidationException::withMessages([
                'pin_code' => ['Kindly verify pin code'],
            ]);
        }

        return $user->createToken('token')->plainTextToken;
    }

    /**
     * @param VerifyPinRequest $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function verifyPin(VerifyPinRequest $request)
    {
        $user = User::where('email', $request->email)
            ->where('pin_code', $request->pin_code)
            ->first();

        if($user){
            Invitation::where('email', $request->email)->delete();

            $user->registered_at = Carbon::now();
            $user->email_verified_at = Carbon::now();
            $user->pin_code = null;
            $user->save();

            return response()->json("Pin code verified successfully", 200);
        }
    }
}
