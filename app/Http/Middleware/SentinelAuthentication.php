<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Hashing\BcryptHasher;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Models\Permission;

class SentinelAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Sentinel::setHasher( new BcryptHasher() );

        $allow_url = array('/', app('router')->getRoutes()->getByName('admin.user.login.form')->uri,
            app('router')->getRoutes()->getByName('admin.user.logout')->uri,
            'password/reset','password/email','password/reset/{token}');

        // Check if white-list URLs Then continue to load page
        if(in_array($request->route()->uri, $allow_url)){
            return $next( $request );
        }

        // If user not Loged redirect to Login page
        $user = Sentinel::check();
        view()->share(['userDetail' => $user]);

        if ( ! $user || $user->deleted_at != null) {
            return redirect()->route('admin.user.login.form');
        }
        $request->merge(array("bsLoginUser" => $user));

        if($request->route()->uri == 'temporary_password'){
            # if User has changed Temp. Password redirect to Profile page.
            if( $user->is_olduser ){
                return redirect()->route( 'general.profile.form' );
            }
            return $next( $request );
        }

        # Check if User not change temporary Password redirect to change password page
        /*if( ! $user->is_olduser ){
            return redirect()->route( 'change.temppassword.form' );
        }*/
        if($request->route()->uri == 'login' &&  $user){
            return redirect()->route( 'admin.user.login.form' );
        }

        if($request->route()->uri == 'dashboard'){
            return $next( $request );
        }
        if($request->route()->uri == 'changepassword'){
            return $next( $request );
        }
        if( $request->route()->uri == 'company/order/download_IPC_template' || $request->route()->uri == 'company/order/download_ordersheet_file/{production_month}'  || $request->route()->uri == 'order/download_missing_ipc/{missing_ipc_id}' || $request->route()->uri == 'system/shippingsheet/download_report/{month?}' || $request->route()->uri == 'sales/shippingsheet/download_report/{month?}' || $request->route()->uri == 'company/shippingsheet/download_report/{month?}' ||$request->route()->uri == 'company/company_preference' || $request->route()->uri == 'company/shippingsheet/download_invoice/{filepath}' || $request->route()->uri == 'company/shippingsheet/invoice_list' || $request->route()->uri == 'system/shippingsheet/invoice_list' ){
            return $next( $request );
        }
        if($request->route()->uri == 'sales/order/view_orders/{production_month}' || $request->route()->uri == 'sales/order/download_order_sheet/{production_month}'){
            return $next( $request );
        }
        #This Is Master User? Have a Full permission
        $roles = Sentinel::getRoles()->pluck('slug')->all();
        if ( is_array($roles) ) {
            if ( in_array('master', $roles) ) {
                return $next( $request );
            }
        }

        // Check Access When User Is Not Master
        // First check what permission require when access by URL
        $requiredPermission = Permission::select('permissions_name')->where(['route' => $request->route()->uri])->first();
        $permission = ($requiredPermission) ? $requiredPermission->permissions_name : '';

        // Check if user have permission to access the page
        if ( $user->hasAccess( $permission ) ) {
            return $next( $request );
        }

        if ( $request->ajax() || $request->wantsJson() ) {
            return $next( $request );
        }

        return abort(401, 'Unauthorized action.');
    }
}
