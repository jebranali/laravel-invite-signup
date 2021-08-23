<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationRequest;
use App\Mail\SendInvite;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    /**
     * @param InvitationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendInvitation(InvitationRequest $request)
    {
        $invitation = new Invitation($request->all());
        $invitation->generateInvitationToken();
        $invitation->save();
        $data = $invitation->toArray();

        Mail::to($data['email'])->send(new SendInvite($data));

        return response()->json("Invitation sent successfully", 200);
    }
}
