<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Invite;

class InviteController extends Controller
{
    /**
     * @method getInvitee - Check database for existing confirmation code and return the data related to that invitee
     * @param [Request] $request - The GET request is passed to the function
     */
    public function getInvitee(Request $request)
    {
        $code = $request->input("confirmationCode");
        if ($code) {
            $invite = Invite::where('confirmationCode', $code)->firstOrFail();
            return $invite;
        } 
        return null;
    }
    
    /**
     * @method rsvp - Update Invite model with RSVP information. 
     */
    public function rsvp(Request $request) 
    {
        $code = $request->input("confirmationCode");
        if ($code) {
            $invite = Invite::where('confirmationCode', $code)->firstOrFail();
            $this->updateRSVP($invite, $request->all());
        }
    }
     
    private function updateRSVP($invitee, $data) {
        $invitee->name = $data["name"];
        $invitee->email = $data["email"];
        $invitee->attending = $data["attending"];
        $invitee->address = $data["address"];
        $invitee->plusOne = $data["plusOne"];
        $invitee->plusOneName = $data["plusOneName"];
        $invitee->message = $data["message"];
        $invitee->save();
    }
     
}
