<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\ExpressCheckout as PayPalClient;
use Illuminate\Support\Facades\Storage;
use App\Models\{User, Country, State, UserPayment, Chapter, Role};

class UserController extends Controller
{
    /**
     * Show the membership for Register form.
     *
     */
    public function register() {
        
        $page_title = 'User Registration';
        $page_description = 'This is user registration page';
        $countries = Country::get();
        $states = State::get();
        $chapterList = Chapter::get();
        
        return view('user.register', compact('page_title', 'page_description', 'countries', 'states', 'chapterList') );
    }

    public function processRegistration(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $user = User::where('email', strtolower($value))->first();
                    if( !$user ){
                        return true;
                    }else{
                        if ( $user->trashed()) {
                            return true;
                        }
                        elseif( !$user->is_active ){ 
                            $fail("Email address is exist with us, But is inactive.");
                        }else{
                            $fail("Email address is exist");
                        }
                    }
                },
            ],
            'address' => 'required',
            'postcode' => 'required',
        ]);
        $memberType = ($request->membership_option == 2)? 2 : 1;

        $uploadProfileFilename = '';
        if($request->hasFile('profile_avatar')){
            $uploadProfileImage = $request->file('profile_avatar');
            $systemFileName = preg_replace('/\s+/', '-', $uploadProfileImage->getClientOriginalName());
            $systemFileName = preg_replace('/-+/', '-', $systemFileName);
    
            $uploadProfileFilename = time()."-".$systemFileName;
    
            $uploadProfileImage->storeAs('public/userProfile/', $uploadProfileFilename);
        }

        $user_data = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email'    => strtolower($request->email),
            'password' => 'Test@Abcd_1234',
            'address' => $request->address,
            'phone' => $request->phone,
            'post_code' => $request->postcode,
            'country' => $this->getCountryId($request->country),
            'state' => $this->getstateId($request->state),
            'gender' => $request->gender,
            'user_type' => $memberType,
            'chapter' => ($request->chapter_from != '') ? decode_url($request->chapter_from) : 0,
            'profile_img' => $uploadProfileFilename,
        );
        return DB::transaction(function() use ($request,$user_data) {
            try {
                $user = User::where('email', strtolower($request->email))->withTrashed()->first();
                if( $user && $user->trashed() ){
                    $user->restore();
                    if( !$user->is_active ){
                        $user_data['is_active'] = 1;
                    }

                    Sentinel::update($user, $user_data);
                    if( !$user->is_active )
                    {
                        $activation = Activation::create($user);
                        Activation::complete($user, $activation->code);
                    }
                    $old_role = Sentinel::findUserById($user->id)->getRoles();
                    if($old_role[0]->id != $request->role_id)
                    {
                        $role = Sentinel::findRoleById($old_role[0]->id);
                        $role->users()->detach($user);
                        Sentinel::findRoleById( $request->role_id)
                        ->users()
                        ->attach( $user );
                    }

                    
                    /*$user->actionOn = 'System';
                    $user->actionTitle = 'User-Revived';
                    $user->message = 'User: :subject.first_name, Restore by :';
                    \Event::dispatch('updated.event', $user);*/
                }
                else{
                    $created_user = Sentinel::registerAndActivate( $user_data );
                    Sentinel::findRoleById(1)
                    ->users()
                    ->attach( $created_user );
                    /*$created_user->actionOn = 'System';
                    $created_user->actionTitle = 'User-Created';
                    $created_user->message = 'User: :subject.first_name, Created by :';
                    \Event::dispatch('created.event', $created_user);*/
                }
                //WelcomeUserEmailJob::dispatch($user_data);
                if($request->membership_option == 2){
                    $provider = new PayPalClient;
                    $data = [];
                    $data['items'] = [
                        [
                            'name' => $request->first_name . ' ' . $request->last_name,
                            'price' => config('paypal.membership_fees'),
                            'desc'  => 'Membership fee for ' . $request->first_name . ' ' . $request->last_name . '#@!' . strtolower($request->email),
                            'qty' => 1,
                            'email' => strtolower($request->email)
                        ]
                    ];
    
                    $data['invoice_id'] = 1;
                    $data['invoice_description'] = 'UDP membership fee for ' . $request->first_name . ' ' . $request->last_name . '( ' . strtolower($request->email) . ' ).';
                    $data['return_url'] = route('user.payPal.Payment.success');
                    $data['cancel_url'] = route('user.payPal.Payment.cancel');
                    $data['total'] = config('paypal.membership_fees'); 
    
                    $response = $provider->setExpressCheckout($data);
                    //$response = $provider->setExpressCheckout($data, true);
                    return redirect($response['paypal_link']);
                }else{
                    Session::flash('successwithwarning', 'Registered successfully! But we need to verify your payment');
                    return redirect()->route('user.registration.form');
                }
                
            } catch (\Exception $e) {
                DB::rollback();
                $message = (config('app.env') == 'production') ? "Something went wrong, please try after sometime" : $e->getMessage();
                Session::flash('error', $message);

                return redirect()->route('user.registration.form');
            }
        });
    }

    /**
     * Responds from Paypal cancle redirect with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelPaypalPayment(Request $request)
    {
        $message = "You cancle your payment for membership fee, Please pay manually!";
        Session::flash('failed', $message);
        return redirect()->route('user.registration.form');
    }

    /**
     * Responds from Paypal after successfull payment
     *
     * @return \Illuminate\Http\Response
     */
    public function successPaypalPayment(Request $request)
    {
        $provider = new PayPalClient;
        $response = $provider->getExpressCheckoutDetails($request->token);
        //dd($request->all(), $provider, $response);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            $get_UserEmail = explode('#@!', $response['L_DESC0']);
            $userDetails = User::where('email', $get_UserEmail[1])->get();
            $paymentUserDetails = [
                'user_id' => $userDetails[0]->id,
                'payment_ammount' => $response['L_AMT0'],
                'payment_currency' => $response['CURRENCYCODE'],
                'payment_status' => $response['ACK'],
                'payment_message' => json_encode([ "TOKEN" => $response['TOKEN'], "CHECKOUTSTATUS" => $response['CHECKOUTSTATUS'], "CORRELATIONID" => $response['CORRELATIONID']]),
                'payment_payer_email' => $response['EMAIL'],
                'payment_payer_firstname' => $response['FIRSTNAME'],
                'payment_payer_lastname' => $response['LASTNAME'],
                'payment_payer_id' => $response['PAYERID'],
                'payment_datetime' => $response['TIMESTAMP'],
            ];
            
            UserPayment::create($paymentUserDetails);
            Session::flash('success', 'Registered and fees paid successfully!');
            return redirect()->route('user.registration.form');
        }
        dd('Something is wrong.');

    }

    /**
     * Show the form for logging.
     *
     */
    public function login() {
        if(Sentinel::guest() == false){
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param loginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function processLogin(Request $request) {
        $request->validate([
            'username'    => 'required|email',
            'password' => 'required|min:8'
        ],[], [
            'username' => 'email address',
            'password' => 'password',
        ]);

        $credentials = array(
            'email'    => strtolower($request->username),
            'password' => $request->password,
        );

        $remember = $request->remember == 'On' ? true : false;

        try {
            if ($user = Sentinel::authenticate($credentials, $remember)) {

                if($user->deleted_at == null){

                    /*$actionTitle = ($user->deleted_at == null) ? 'UserLogin-Success' : 'UserLogin-revoke';
                    $actionMessage = ($user->deleted_at == null) ? 'Successfull login attempt by :' : 'Revoke login attempt by :';
                    $user->actionOn = 'System';
                    $user->actionTitle = $actionTitle;
                    $user->message = $actionMessage;
                    \Event::dispatch('created.event', $user);*/

                    return redirect()->route('admin.dashboard');
                }else {
                    Session::flash('failed', 'Access grant is revoked, Contact Admin.');
                    Sentinel::logout(null, true);
                    return redirect()->route('admin.user.login.form');
                }
                //return redirect()->intended();
            } else {
                Session::flash('error', 'Invalid Email address or password.');

                return redirect()->route('admin.user.login.form');
            }
        } catch (ThrottlingException $ex) {
            Session::flash('failed',\Lang::get('userMessages.user_blocked',['delay_sec'=>$ex->getDelay()]));

            return redirect()->route('admin.user.login.form');

        } catch (NotActivatedException $ex) {
            Session::flash('failed', \Lang::get('userMessages.user_inactive'));

            return redirect()->route('admin.user.login.form');
        }
    }    

    public function logout()
    {
        Sentinel::logout(null, true);
        session()->flush();
        return redirect()->route('admin.user.login.form');
    }

    /**
     * Membership User List, edit, delete and PrintID.
     *
     */
    public function userlist(Request $request)
    {
        if($request->ajax())
        {
            $findUserData = User::whereHas('role', function($q){
                $q->where('slug','=','user');
            })->with(['countryDetail', 'stateDetail', 'paymentDetails'])->where('deleted_at',null);
            if($request->get('bsLoginUser')->chapter != 0){
                $userData = $findUserData->where('chapter', $request->get('bsLoginUser')->chapter)->orderByDesc('id')->get();
            }else{
                $userData = $findUserData->orderByDesc('id')->get();
            }
            $userInfos = [];
            $finalUserData = $userData->map(function($userDetail, $userInfos){
                //foreach($userData as $userDetail){ 
                $profileImg = ($userDetail->profile_img != '' ) ? Storage::disk('public')->url('userProfile/' . $userDetail->profile_img) : Storage::disk('public')->url('userProfile/blank.png');
                    return $userInfos = [
                        'userDetail' => encode_url( $userDetail->id ),
                        'userName' => $userDetail->first_name . ' ' . $userDetail->last_name,
                        'userEmail' => $userDetail->email,
                        'profileImage' => '<img src="'.$profileImg.'" style="max-width: 125px">',
                        'userCountry' => $this->getCountryName($userDetail->country),
                        'userState' => $this->getstateName($userDetail->state),
                        'userStatus' => $userDetail->status,
                        'userType' => $userDetail->user_type
                    ];
                //}
            });

            return DataTables::of($finalUserData)
            ->addColumn('useCheckbox', function($finalUserData) use($request){
                return '<label class="checkbox checkbox-single">
                        <input type="checkbox" value="'.$finalUserData['userDetail'].'" class="checkable"/>
                        <span></span>
                    </label>';
            })
            ->addColumn('action', function($finalUserData) use($request){
                $actionHTML = (checkPermission([app('router')->getRoutes()->getByName('admin.member.Card.Print')->uri])) ? '<div class="dropdown dropdown-inline">
                    <a href="javascript:;" class="btn btn-sm btn-clean btn-icon mr-2" data-toggle="dropdown">
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M5,8.6862915 L5,5 L8.6862915,5 L11.5857864,2.10050506 L14.4852814,5 L19,5 L19,9.51471863 L21.4852814,12 L19,14.4852814 L19,19 L14.4852814,19 L11.5857864,21.8994949 L8.6862915,19 L5,19 L5,15.3137085 L1.6862915,12 L5,8.6862915 Z M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000"/>
                                </g>
                            </svg>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <ul class="navi flex-column navi-hover py-2">
                            <li class="navi-header font-weight-bolder text-uppercase font-size-xs text-primary pb-2">
                                Choose an action:
                            </li>
                            <li class="navi-item">
                                <a href="'.route('admin.member.Card.Print', [$finalUserData['userDetail']]).'" class="navi-link" target="_blank">
                                    <span class="navi-icon"><i class="la la-print"></i></span>
                                    <span class="navi-text">Print</span>
                                </a>
                            </li>
                            <li class="navi-item">
                                <a href="#" class="navi-link">
                                    <span class="navi-icon"><i class="la la-file-excel-o"></i></span>
                                    <span class="navi-text">Excel</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>' : '' ;
                $actionHTML .= (checkPermission([app('router')->getRoutes()->getByName('admin.user.edit.form')->uri])) ? '<a href="'.route('admin.user.edit.form', [$finalUserData['userDetail']]).'" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">
                    <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                            </g>
                        </svg>
                    </span>
                </a>' : '';
                $actionHTML .= (checkPermission([app('router')->getRoutes()->getByName('admin.user.destroy')->uri])) ? '
                    <button data-deleteURL="'.route('admin.user.destroy', [$finalUserData['userDetail']]).'" class="btn btn-sm btn-clean btn-icon" title="Delete" data-alertMessage="Member User deleted won\'t be reveret back!" data-dataTableReloadid="#user_datatable" onclick="showcommonDeleteAlert(this)">
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
                                    <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
                                </g>
                            </svg>
                        </span>
                    </button>' : '';
                return $actionHTML;
            })
            ->addIndexColumn()
            ->rawColumns(['profileImage','useCheckbox','action'])
            ->make(true);
        }
        
        $page_title = 'Members';
        $page_description = 'This is members list page';
        return view('user.datatables', compact('page_title', 'page_description'));
    }

    public function userEdit(Request $request, $userId)
    {
        $page_title = 'User Edit';
        $page_description = 'This is custom page';
        
        $editUserDetail = User::where('id',decode_url($userId))->with(['paymentDetails', 'chapterDetail'])->get();
        $countries = Country::get();
        $states = State::get();
        $chapterList = Chapter::get();

        $profileImg = ($editUserDetail[0]->profile_img != '' ) ? Storage::disk('public')->url('userProfile/' . $editUserDetail[0]->profile_img) : Storage::disk('public')->url('userProfile/blank.png');
        $userStatus = [1 => 'Active', 2 => 'In-active', 3 => 'Suspended', 4 => 'Terminated', 5 => 'Membership Expired', 6 => 'Death'];
        //dd($editUserDetail);
        return view('user.edit', compact('page_title', 'page_description', 'editUserDetail', 'countries', 'states', 'chapterList', 'profileImg', 'userStatus' ));
    }

    public function userUpdateUser(Request $request, $userId)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) use($userId) {
                    $user = User::where('id', '!=',decode_url($userId))->where('email', strtolower($value))->first();
                    if( !$user ){
                        return true;
                    }else{
                        if ( $user->trashed()) {
                            return true;
                        }
                        elseif( !$user->is_active ){ 
                            $fail("Email address is exist with us, But is inactive.");
                        }else{
                            $fail("Email address is exist");
                        }
                    }
                },
            ],
            'address' => 'required',
            'postcode' => 'required',
        ]);


        $uploadProfileFilename = $request->old_profile_name;
        if($request->hasFile('profile_avatar')){
            //$existingPofile = explode('.', $request->old_profile_name);

            $uploadProfileImage = $request->file('profile_avatar');
            $systemFileName = preg_replace('/\s+/', '-', $uploadProfileImage->getClientOriginalName());
            $systemFileName = preg_replace('/-+/', '-', $systemFileName);
    
            $uploadProfileFilename = time()."-".$systemFileName;
    
            $uploadProfileImage->storeAs('public/userProfile/', $uploadProfileFilename);
        }

        $updateUserDetail = User::find(decode_url($userId));
        
        $updateUserDetail->first_name = $request->first_name;
        $updateUserDetail->last_name = $request->last_name;
        $updateUserDetail->email = strtolower($request->email);
        $updateUserDetail->password = 'Test@Abcd_1234';
        $updateUserDetail->address = $request->address;
        $updateUserDetail->phone = $request->phone;
        $updateUserDetail->post_code = $request->postcode;
        $updateUserDetail->country = $this->getCountryId($request->country);
        $updateUserDetail->state = $this->getstateId($request->state);
        $updateUserDetail->gender = $request->gender;
        $updateUserDetail->status = $request->status_from;
        $updateUserDetail->chapter = ($request->chapter_from != '') ? decode_url($request->chapter_from) : 0;
        $updateUserDetail->profile_img = $uploadProfileFilename;

        $updateUserDetail->save();
        if($request->has('manual_ammount') && $request->has('manual_receipt')){
            
            $paymentUserDetails = [
                'user_id' => decode_url($userId),
                'payment_ammount' => $request->manual_ammount,
                'payment_currency' => $request->manual_currency,
                'payment_status' => 'Success',
                'payment_message' => json_encode([ "TOKEN" => $request->manual_receipt, "CHECKOUTSTATUS" => 'Manual Payment', "CORRELATIONID" => '']),
                'payment_payer_email' => $request->EMAIL,
                'payment_payer_firstname' => $request->bsLoginUser->first_name,
                'payment_payer_lastname' => $request->bsLoginUser->last_name,
                'payment_payer_id' => $request->bsLoginUser->id,
                'payment_datetime' => date('Y-m-d H:i:s'),
            ];
            
            UserPayment::create($paymentUserDetails);
        }
        return redirect()->route('admin.user.edit.action', [$userId])->with('success', 'User Update Successfully!');
    }

    public function printIdCards(Request $request, $userId)
    {
        $userDetail = User::where('id',decode_url($userId))->with(['countryDetail', 'stateDetail', 'paymentDetails'])->get();
        Storage::disk('public')->put('example.txt', 'Contents');
        //dd(Storage::disk('public')->path('udpCardDefault/udpcrdTemplate2.jpg'), $request->all(), decode_url($userId), $userDetail[0], $userDetail[0]->countryDetail->name);
        $defaultFront = Storage::disk('public')->path('udpCardDefault/udpcrdTemplate2.jpg');
        $defaultBack = Storage::disk('public')->url('udpCardDefault/backofthecard.jpg');
        $defaultFontColor = Storage::disk('public')->path('udpCardDefault/font/arial-black.ttf');
        $profileImg = ($userDetail[0]->profile_img != '' ) ? Storage::disk('public')->path('userProfile/' . $userDetail[0]->profile_img) : Storage::disk('public')->path('userProfile/blank.png');

        $CountryOfResidence = $this->getCountryName($userDetail[0]->country);
        switch($CountryOfResidence)
        {
            case "USA":
                $CountryPrefix = "USA" . "1000";
                break;
            case "Canada":
                $CountryPrefix = "CAD" . "1000";
                break;
            default:
                $CountryPrefix = "THEGAMBIA" . "1000";
                break;
        }
        $MembershipID = $CountryPrefix . $userDetail[0]->id;
        $Name = $userDetail[0]->first_name . ' ' . $userDetail[0]->last_name;
        $Gender = $userDetail[0]->gender;
        $Constituency = $this->getstateName($userDetail[0]->state);

        generateCardId($defaultFront, $profileImg, $defaultFontColor, $Name, $Gender, $CountryOfResidence, $Constituency, $MembershipID);

        $membershipCardFront = Storage::disk('public')->url('udpCardId/' . $MembershipID . '.jpg');
        return view('user.memberCard', compact('defaultBack', 'membershipCardFront'));
        //
    }

    public function userDestroy(Request $request, $userId)
    {
        $deleteMemberUser = User::find(decode_url($userId));
        $deleteMemberUser->delete();
        return response()->json(['message' => 'Member User has been deleted.','status'=>1]);
    }

    /**
    * functions for the SYSTEM user registration, edit, update and delete.
    *
    * @return \Illuminate\View\View
    */
    public function systemUserRegister() {
        $page_title = 'System-User Registration';
        $page_description = 'This is system user registration page';
        $roles = Role::where('slug','!=', 'master')->get();
        $countries = Country::get();
        $states = State::get();
        $chapters = Chapter::all();

        return view('system_user.create',compact('page_title', 'page_description', 'countries', 'states', 'roles', 'chapters') );
    }

    public function systemUserProcessRegistration(Request $request)
    {
        $request->validate([
           'first_name' => 'required',
           'last_name' => 'required',
           'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $user = User::where('email', strtolower($value))->first();
                    if( !$user ){
                        return true;
                    }else{
                        if ( $user->trashed()) {
                            return true;
                        }
                        elseif( !$user->is_active ){ 
                            $fail("Email address is exist with us, But is inactive.");
                        }else{
                            $fail("Email address is exist");
                        }
                    }
                },
            ],
            'role_id' => 'required',
        ], [], [
            'role_id' => 'Role',
        ]);
        $memberType = ($request->membership_option == 2)? 2 : 1;

        $uploadProfileFilename = '';
        if($request->hasFile('profile_avatar')){
            $uploadProfileImage = $request->file('profile_avatar');
            $systemFileName = preg_replace('/\s+/', '-', $uploadProfileImage->getClientOriginalName());
            $systemFileName = preg_replace('/-+/', '-', $systemFileName);
   
            $uploadProfileFilename = time()."-".$systemFileName;
            
            $uploadProfileImage->storeAs('public/userProfile/', $uploadProfileFilename);
        }

        $user_data = array(
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email'    => strtolower($request->email),
            'password' => $request->password,
            'address' => '-',
            'post_code' => '-',
            'country' => 1,
            'state' => 1,
            'user_type' => $memberType,
            'chapter' => ($request->chapter_from != '') ? decode_url($request->chapter_from) : 0,
            'profile_img' => $uploadProfileFilename,
        );
        return DB::transaction(function() use ($request,$user_data) {
            try {
                $user = User::where('email', strtolower($request->email))->withTrashed()->first();
                if( $user && $user->trashed() ){
                    $user->restore();
                    if( !$user->is_active ){
                        $user_data['is_active'] = 1;
                    }

                    Sentinel::update($user, $user_data);
                    if( !$user->is_active )
                    {
                        $activation = Activation::create($user);
                        Activation::complete($user, $activation->code);
                    }
                    $old_role = Sentinel::findUserById($user->id)->getRoles();
                    if($old_role[0]->id != $request->role_id)
                    {
                        $role = Sentinel::findRoleById($old_role[0]->id);
                        $role->users()->detach($user);
                        Sentinel::findRoleById( $request->role_id)
                        ->users()
                        ->attach( $user );
                    }

                    
                    /*$user->actionOn = 'System';
                    $user->actionTitle = 'User-Revived';
                    $user->message = 'User: :subject.first_name, Restore by :';
                    \Event::dispatch('updated.event', $user);*/
                }
                else{
                    $created_user = Sentinel::registerAndActivate( $user_data );
                    Sentinel::findRoleById($request->role_id)
                    ->users()
                    ->attach( $created_user );
                    /*$created_user->actionOn = 'System';
                    $created_user->actionTitle = 'User-Created';
                    $created_user->message = 'User: :subject.first_name, Created by :';
                    \Event::dispatch('created.event', $created_user);*/
                }
                //WelcomeUserEmailJob::dispatch($user_data);
                if($request->membership_option == 2){
                    $provider = new PayPalClient;
                    $data = [];
                    $data['items'] = [
                        [
                            'name' => $request->first_name . ' ' . $request->last_name,
                            'price' => config('paypal.membership_fees'),
                            'desc'  => 'Membership fee for ' . $request->first_name . ' ' . $request->last_name . '#@!' . strtolower($request->email),
                            'qty' => 1,
                            'email' => strtolower($request->email)
                        ]
                    ];
    
                    $data['invoice_id'] = 1;
                    $data['invoice_description'] = 'UDP membership fee for ' . $request->first_name . ' ' . $request->last_name . '( ' . strtolower($request->email) . ' ).';
                    $data['return_url'] = route('user.payPal.Payment.success');
                    $data['cancel_url'] = route('user.payPal.Payment.cancel');
                    $data['total'] = config('paypal.membership_fees'); 
    
                    $response = $provider->setExpressCheckout($data);
                    //$response = $provider->setExpressCheckout($data, true);
                    return redirect($response['paypal_link']);
                }else{
                    Session::flash('successwithwarning', 'system User added successfully!');
                    return redirect()->route('systemuser.index');
                }
               
            } catch (\Exception $e) {
                DB::rollback();
                $message = (config('app.env') == 'production') ? "Something went wrong, please try after sometime" : $e->getMessage();
                Session::flash('error', $message);

                return redirect()->route('systemuser.index');
            }
        });
    }

   public function systemUserList(Request $request)
   {
        if($request->ajax())
        {
            $userData = User::whereHas('role', function($q){
                $q->where('slug','!=','user');
                $q->where('slug','!=','master');
            })->with(['chapterDetail', 'role'])->where('deleted_at',null)->orderByDesc('id')->get();
            $userInfos = [];
            $finalUserData = $userData->map(function($userDetail, $userInfos){//dd($userDetail->role);
                //foreach($userData as $userDetail){ 
                $profileImg = ($userDetail->profile_img != '' ) ? Storage::disk('public')->url('userProfile/' . $userDetail->profile_img) : Storage::disk('public')->url('userProfile/blank.png');
                    return $userInfos = [
                        'userDetail' => encode_url( $userDetail->id ),
                        'first_name' => $userDetail->first_name,
                        'last_name' => $userDetail->last_name,
                        'userEmail' => $userDetail->email,
                        'role' => $userDetail->role[0]->name,
                        'chapterName' => $userDetail->chapterDetail->chapter_name,
                    ];
                //}
            });

            return DataTables::of($finalUserData)
            ->addColumn('useCheckbox', function($finalUserData) use($request){
                return '<label class="checkbox checkbox-single">
                        <input type="checkbox" value="'.$finalUserData['userDetail'].'" class="checkable"/>
                        <span></span>
                    </label>';
            })
            ->addColumn('action', function($finalUserData) use($request){
                
                $actionHTML = (checkPermission([app('router')->getRoutes()->getByName('systemuser.edit.form')->uri])) ? '<a href="'.route('systemuser.edit.form', [$finalUserData['userDetail']]).'" class="btn btn-sm btn-clean btn-icon mr-2" title="Edit details">
                    <span class="svg-icon svg-icon-md">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="#000000" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                <rect fill="#000000" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                            </g>
                        </svg>
                    </span>
                </a>' : '';
                $actionHTML .= (checkPermission([app('router')->getRoutes()->getByName('systemuser.destroy')->uri])) ? '
                    <button data-deleteURL="'.route('systemuser.destroy', [$finalUserData['userDetail']]).'" class="btn btn-sm btn-clean btn-icon" title="Delete" data-alertMessage="System User deleted won\'t be reveret back!" data-dataTableReloadid="#systemUser_list" onclick="showcommonDeleteAlert(this)">
                        <span class="svg-icon svg-icon-md">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"/>
                                    <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/>
                                </g>
                            </svg>
                        </span>
                    </button>' : '';
                return $actionHTML;
            })
            ->addIndexColumn()
            ->rawColumns(['profileImage','useCheckbox','action'])
            ->make(true);
        }
        
        $page_title = 'Members';
        $page_description = 'This is members list page';
        return view('system_user.list', compact('page_title', 'page_description'));
   }

   public function systemUserEdit(Request $request, $userId)
    {
        $page_title = 'System User Edit';
        $page_description = 'This is custom page';
        
        $editUserDetail = User::where('id',decode_url($userId))->with(['chapterDetail'])->get();
        $roles = Role::where('slug','!=', 'master')->get();
        $countries = Country::get();
        $states = State::get();
        $chapters = Chapter::all();
        $canEditPassword = true;

        return view('system_user.edit', compact('page_title', 'page_description', 'editUserDetail', 'roles', 'countries', 'states', 'chapters', 'canEditPassword' ));
    }

    public function systemUserUpdate(Request $request, $userId)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                    'required',
                    'email',
                    function ($attribute, $value, $fail) use ($userId) {
                        $user = User::where('id', '!=',decode_url($userId))->where('email', strtolower($value))->first();
                        if( !$user ){
                            return true;
                        }else{
                            if ( $user->trashed()) {
                                return true;
                            }
                            elseif( !$user->is_active ){ 
                                $fail("Email address is exist with us, But is inactive.");
                            }else{
                                $fail("Email address is exist");
                            }
                        }
                    },
                ],
                'role_id' => 'required',
            ], [], [
                'role_id' => 'Role',
        ]);

        $user = User::find(decode_url($userId));
        
        $user_data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'chapter' => ($request->chapter_from != '') ? decode_url($request->chapter_from) : 0,
        ];
        if($request->has('new_password') && $request->new_password != ''){
            $user_data['password'] = $request->new_password;
        }
        $credentials = [
            'email' => $user->email,
        ];
        if(Sentinel::validForUpdate($user, $credentials)){
            $update_user = Sentinel::update($user, $user_data);
            $old_role = Sentinel::findUserById($user->id)->getRoles();
            if($old_role[0]->id != $request->role_id)
            {
                $role = Sentinel::findRoleById($old_role[0]->id);
                $role->users()->detach($user);
                Sentinel::findRoleById( $request->role_id)
                ->users()
                ->attach( $user );
            }

            /*$user->actionOn = 'System';
            $user->actionTitle = 'User-Updated';
            $user->message = 'User: :subject.first_name, Updated by :';
            \Event::dispatch('updated.event', $user);*/

        }else{
            Session::flash('failed', 'User Not Found');
            return redirect()->route('systemuser.index');
        }
        return redirect()->route('systemuser.index')->with('success', 'System User Update Successfully!');
    }    

    public function systemUserDestroy(Request $request, $userId)
    {
        $deleteMemberUser = User::find(decode_url($userId));
        $deleteMemberUser->delete();
        return response()->json(['message' => 'System User has been deleted.','status'=>1]);
    }
}
