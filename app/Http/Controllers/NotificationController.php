<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\{User};
use Illuminate\Support\Facades\Session;
use App\Jobs\AdminSendEmailJob;

class NotificationController extends Controller
{
    public function openMailform()
    {
        $userData = User::whereHas('role', function($q){
            $q->where('slug','=','user');
        })->with(['countryDetail', 'stateDetail', 'paymentdetails'])->where('deleted_at',null)->get();
        $userInfos = [];
        $i=0;
        foreach($userData as $userDetail){
            $profileImage = ($userDetail->profile_img != '' ) ? Storage::disk('public')->url('userProfile/' . $userDetail->profile_img) : Storage::disk('public')->url('userProfile/blank.png');
            $userInfos[$i] = [
                'id' => $userDetail->email,
                'text' => $userDetail->first_name . ' ' . $userDetail->last_name,
                'htmlMarkup' => '<div class="tagify__dropdown__item"><div class="d-flex align-items-center"><span class="symbol sumbol-danger mr-2"><span class="symbol-label" style="background-image: url(\''.$profileImage.'\')"></span></span><div class="d-flex flex-column"><a href="#" class="text-dark-75 text-hover-primary font-weight-bold">'.$userDetail->first_name . ' ' . $userDetail->last_name.'</a><span class="text-muted font-weight-bold">'.$userDetail->email.'</span></div></div></div>',
                'title' => $userDetail->email,
            ];
            $i++;
        }
        $page_title = 'Send Notification';
        $page_description = 'This is email notification page.';

        return view('notification.sendmail', ['page_title' => $page_title, 'page_description' => $page_description, 'emailUserLists' => json_encode($userInfos)]);
    }
    public function sendMail(Request $request)
    {
        $jobData = [
            'listOfEmails' => $request->useremails,
            'emailSubject' => $request->adminemail_subject,
            'emailContent' => $request->adminemail_content,
        ];
        AdminSendEmailJob::dispatch($jobData);
        Session::flash('success', 'Emails sending in Process, this will take some time!');
        return redirect()->route('admin.mail.notification.form');
    }
}
