<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Models\{LiveMembers, UserPayment, User, Voter, Ethnicity};

class PagesController extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'Dashboard';
        $page_description = 'Some description for the page';
        $dashboard_data['membercount'] = User::whereHas('role', function($q){
            $q->where('slug','=','user');
        })->where('deleted_at',null)->count();
        $dashboard_data['votercount'] = Voter::where('deleted_at',null)->count();
        $dashboard_data['ethnicity'] = Ethnicity::select('ename')->get()->pluck('ename');

        $findDateFrom = Carbon::today()->subMonth(11)->startOfMonth()->toDateString();
        $findDateTo = Carbon::today()->endOfMonth()->toDateString();

        $period = CarbonPeriod::create($findDateFrom, '1 month', $findDateTo);

        $memberUserCountByMonth = User::whereHas('role', function($q){
            $q->where('slug','=','user');
        })
        ->where('deleted_at',null)
        ->select(DB::raw("count(*) as count, DATE_FORMAT(created_at, '%b %Y') as yearmonth"))
        ->groupBy('yearmonth')
        ->whereBetween('created_at', [$findDateFrom, $findDateTo])
        ->orderBy('yearmonth', 'DESC')
        ->get();
        $member_chart_year = [];
        $member_chart_count = [];
        foreach ($period as $dt) {
            $member_chart_year[] = $dt->format("M Y");
            $memberCount = 0;
            foreach ($memberUserCountByMonth->toArray() as $key => $userCntMnt) {
                if($userCntMnt['yearmonth'] == $dt->format("M Y")){
                    $memberCount = $userCntMnt['count'];
                }
            }
            $member_chart_count[] = $memberCount;
        }
        $dashboard_data['member_chart_year'] = implode(',', $member_chart_year);
        $dashboard_data['member_chart_count'] = implode(',', $member_chart_count);

        $voterCountByMonth = Voter::where('deleted_at',null)
        ->select(DB::raw("count(*) as count, DATE_FORMAT(created_at, '%b %Y') as yearmonth"))
        ->groupBy('yearmonth')
        ->whereBetween('created_at', [$findDateFrom, $findDateTo])
        ->orderBy('yearmonth', 'DESC')
        ->get();

        $voter_chart_year = [];
        $voter_chart_count = [];
        foreach ($period as $dt) {
            $memberCount = 0;
            foreach ($voterCountByMonth->toArray() as $key => $voterCntMnt) {
                if($voterCntMnt['yearmonth'] == $dt->format("M Y")){
                    $memberCount = $voterCntMnt['count'];
                }
            }
            $voter_chart_count[] = $memberCount;
        }
        $dashboard_data['voter_chart_year'] = implode(',', $member_chart_year);
        $dashboard_data['voter_chart_count'] = implode(',', $voter_chart_count);

        $findUserData = User::whereHas('role', function($q){
            $q->where('slug','=','user');
        })->with(['countryDetail', 'stateDetail', 'paymentDetails'])->where('deleted_at',null);
        if($request->get('bsLoginUser')->chapter != 0){
            $userData = $findUserData->where('chapter', $request->get('bsLoginUser')->chapter)->orderByDesc('id')->limit(5)->get();
        }else{
            $userData = $findUserData->orderByDesc('id')->limit(5)->get();
        }
        $dashboard_data['userData'] = $userData->map(function($userDetail){
            $profileImg = ($userDetail->profile_img != '' ) ? Storage::disk('public')->url('userProfile/' . $userDetail->profile_img) : Storage::disk('public')->url('userProfile/blank.png');
            return [
                'userDetail' => encode_url( $userDetail->id ),
                'userName' => $userDetail->first_name . ' ' . $userDetail->last_name,
                'userEmail' => $userDetail->email,
                'profileImage' => '<img src="'.$profileImg.'" class="h-50 align-self-center">',
                'userCountry' => $this->getCountryName($userDetail->country),
                'userState' => $this->getstateName($userDetail->state),
                'userStatus' => $userDetail->status,
                'userType' => $userDetail->user_type
            ];
        });

        $voterList = Voter::orderByDesc('id')->limit(5)->get();
        if($voterList->isNotEmpty()){
            $dashboard_data['voterData'] = $voterList->map(function($voterDetail){
                return [
                    'voterName' => $voterDetail->first_name . ' ' . $voterDetail->last_name,
                    'voterEmail' => $voterDetail->email,
                    'voterCity' => $this->getCityName($voterDetail->city),
                    'voterRegion' => $this->getRegionName($voterDetail->region),
                    'voterEthnic' => $this->getEthnicityName($voterDetail->ethnicity),
                    'voterState' => $this->getstateName($voterDetail->state),
                ];

            });
        }else{
            $dashboard_data['voterData'] = 'No Data available';
        }        
        //dd($dashboard_data);
        return view('pages.dashboard', compact('page_title', 'page_description', 'dashboard_data'));
    }
    public function index1()
    {
        $secondDB = LiveMembers::with('memberCardDetail')->where('isprocessed', 0)->orderBy('MembershipID', 'asc')->limit(10)->get();
        $fileDetail = new \Illuminate\Http\File( ( Storage::disk('download')->path('0A4CBC5E-D289-4FE7-B827-8C8B3CF3B139.jpeg') ) );
        foreach ($secondDB as $key => $importUser) {
            switch ( strtolower($importUser->CountryOfResidence) ){
                case 'usa':
                    $chapter = 1;
                    $currency = 'USD';
                    break;
                case 'united kingdom':
                    $chapter = 2;
                    $currency = 'GBP';
                    break;
                case 'uk':
                    $chapter = 2;
                    $currency = 'GBP';
                    break;                    
                case 'spain':
                    $chapter = 3;
                    $currency = 'RUE';
                    break;
                default:
                    $chapter = 0;
                    $currency = 'GMD';
                    break;
            }

            $uploadProfileFilename = '';
            if($importUser->memberCardDetail){
                $UserPhoto = $importUser->memberCardDetail->PhotoDir;
                if($UserPhoto != '' && $UserPhoto != 'no image'){
                    $imgName = explode('/home/udpthegambia/public_html/udpadmintest/img/', $UserPhoto);
                    $finalUserImage = $imgName[1];
                    if (file_exists( Storage::disk('download')->path($finalUserImage) ) ){
                        $systemFileName = preg_replace('/\s+/', '-', $finalUserImage);
                        $systemFileName = preg_replace('/-+/', '-', $systemFileName);
                
                        $uploadProfileFilename = time()."-".$systemFileName;
                        Storage::putFileAs( 
                            'public/userProfile',
                            Storage::disk('download')->path($finalUserImage), 
                            $uploadProfileFilename
                        );
                    }                
                }
            }
            

            $user_data = array(
                'first_name' => $importUser->Firstname,
                'last_name' => $importUser->Lastname,
                'email'    => strtolower($importUser->Email),
                'password' => 'Test@Abcd_1234',
                'address' => $importUser->Address,
                'phone' => $importUser->phone,
                'post_code' => $importUser->PostCode,
                'country' => $this->getCountryId($importUser->CountryOfResidence),
                'state' => $this->getstateId($importUser->constituency),
                'gender' => ($importUser->Position != '' && $importUser->Position == 'Female') ? $importUser->Position : 'Male',
                'user_type' => 1,
                'chapter' => $chapter,
                'profile_img' => $uploadProfileFilename,
            );

            $created_user = Sentinel::registerAndActivate( $user_data );
            Sentinel::findRoleById(1)
            ->users()
            ->attach( $created_user );

            $paymentUserDetails = [
                'user_id' => $created_user->id,
                'payment_ammount' => rand(20, 100),
                'payment_currency' => $currency,
                'payment_status' => 'Success',
                'payment_message' => json_encode([ "TOKEN" => "Abcd1234", "CHECKOUTSTATUS" =>'CHECKOUTSTATUS', "CORRELATIONID" => 'CORRELATIONID']),
                'payment_payer_email' => 'mrbrijp-buyer@gmail.com',
                'payment_payer_firstname' => 'test',
                'payment_payer_lastname' => 'buyer',
                'payment_payer_id' => 'BBM9V53WC5TML',
                'payment_datetime' => date('Y-m-d H:i:s', time()),
            ];
            
            UserPayment::create($paymentUserDetails);

            LiveMembers::where('MembershipID', $importUser->MembershipID)->update(['isprocessed' => 1]);
        }
        dd($secondDB);
        // dd($secondDB, $fileDetail, $fileDetail->getMTime(), $fileDetail->getPathname(), $fileDetail->getRealPath(), $fileDetail->getFilename(), $fileDetail->getMimeType(), $fileDetail->getPath(), $fileDetail['extension']);
        $page_title = 'Dashboard';
        $page_description = 'Some description for the page';

        return view('pages.dashboard1', compact('page_title', 'page_description'));
    }

    /**
     * Demo methods below
     */

    // Datatables
    public function datatables()
    {
        $page_title = 'Datatables';
        $page_description = 'This is datatables test page';

        return view('pages.datatables', compact('page_title', 'page_description'));
    }

    // KTDatatables
    public function ktDatatables()
    {
        $page_title = 'KTDatatables';
        $page_description = 'This is KTdatatables test page';

        return view('pages.ktdatatables', compact('page_title', 'page_description'));
    }

    // Select2
    public function select2()
    {
        $page_title = 'Select 2';
        $page_description = 'This is Select2 test page';

        return view('pages.select2', compact('page_title', 'page_description'));
    }

    // jQuery-mask
    public function jQueryMask()
    {
        $page_title = 'jquery-mask';
        $page_description = 'This is jquery masks test page';

        return view('pages.jquery-mask', compact('page_title', 'page_description'));
    }

    // custom-icons
    public function customIcons()
    {
        $page_title = 'customIcons';
        $page_description = 'This is customIcons test page';

        return view('pages.icons.custom-icons', compact('page_title', 'page_description'));
    }

    // flaticon
    public function flaticon()
    {
        $page_title = 'flaticon';
        $page_description = 'This is flaticon test page';

        return view('pages.icons.flaticon', compact('page_title', 'page_description'));
    }

    // fontawesome
    public function fontawesome()
    {
        $page_title = 'fontawesome';
        $page_description = 'This is fontawesome test page';

        return view('pages.icons.fontawesome', compact('page_title', 'page_description'));
    }

    // lineawesome
    public function lineawesome()
    {
        $page_title = 'lineawesome';
        $page_description = 'This is lineawesome test page';

        return view('pages.icons.lineawesome', compact('page_title', 'page_description'));
    }

    // socicons
    public function socicons()
    {
        $page_title = 'socicons';
        $page_description = 'This is socicons test page';

        return view('pages.icons.socicons', compact('page_title', 'page_description'));
    }

    // svg
    public function svg()
    {
        $page_title = 'svg';
        $page_description = 'This is svg test page';

        return view('pages.icons.svg', compact('page_title', 'page_description'));
    }

    // Quicksearch Result
    public function quickSearch()
    {
        return view('layout.partials.extras._quick_search_result');
    }
}
