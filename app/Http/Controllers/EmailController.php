<?php

namespace App\Http\Controllers;

use App\Mail\MeetingAsesor;
use App\Models\User;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    static public function sendMeetingAsesor($meeting){
        $meeting->bcAsesor = Users::find($meeting->created_by);
        $meeting->asesorComercial = Users::find($meeting->assigned_user_id);


        $mail = Mail::to('mart_rt@hotmail.com')->send(new MeetingAsesor($meeting));
        return $mail;
    }
}
