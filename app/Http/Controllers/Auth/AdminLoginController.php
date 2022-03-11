<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    public function check()
    {
        $authorizationurl = "https://sso.egov.uz/sso/oauth/Authorization.do";
        $clientid = "test.epmty.uz";
        $clientsecret = "As9d1Gu6fa/0q5yw+Zwfgw==";
        $scope = "legal";
        $authCode = $_GET["code"];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $authorizationurl);
        curl_setopt($ch, CURLOPT_POST, true);

        $param = "grant_type=" . rawurlencode('one_authorization_code');
        $param = $param . "&client_id=" . rawurlencode($clientid);
        $param = $param . "&client_secret=" . rawurlencode($clientsecret);
        $param = $param . "&code=" . rawurlencode($authCode);
        $param = $param . "&scope=" . rawurlencode($scope);
        $param = $param . "&redirect_uri=" . rawurlencode(config('app.redirect_admin'));

        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        curl_close($ch);


        $obj = json_decode($result);

        $access_token = $obj->{'access_token'};


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $authorizationurl);
        curl_setopt($ch, CURLOPT_POST, true);

        $param = "grant_type=" . rawurlencode('one_access_token_identify');
        $param = $param . "&client_id=" . rawurlencode($clientid);
        $param = $param . "&client_secret=" . rawurlencode($clientsecret);
        $param = $param . "&scope=" . rawurlencode($scope);
        $param = $param . "&access_token=" . rawurlencode($access_token);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $results = curl_exec($ch);
        curl_close($ch);

        $userInfo = json_decode($results, true);

        $userData = UserData::query()
            ->where([
                'user_id' => $userInfo['user_id'],
                'pin' => $userInfo['pin']
            ])->first();

        if ($userData) {

            $user = User::query()
                ->where('name', $userData['user_id'])
                ->where('password', $userData['pin'])
                ->first();

            Auth::login($user);

        } else {
            $user = User::query()
                ->create([
                    'name' => $userInfo['user_id'],
                    'email' => $userInfo['email'],
                    'password' => $userInfo['pin'],
                ]);

            UserData::query()
                ->create([
                    'userid' => $user->id,
                    'birth_date' => $userInfo['birth_date'],
                    'ctzn' => $userInfo['ctzn'],
                    'per_adr' => $userInfo['per_adr'],
                    'pport_issue_place' => $userInfo['pport_issue_place'],
                    'sur_name' => $userInfo['sur_name'],
                    'gd' => $userInfo['gd'],
                    'natn' => $userInfo['natn'],
                    'pport_issue_date' => $userInfo['pport_issue_date'],
                    'pport_expr_date' => $userInfo['pport_expr_date'],
                    'pport_no' => $userInfo['pport_no'],
                    'pin' => $userInfo['pin'],
                    'mob_phone_no' => $userInfo['mob_phone_no'],
                    'user_id' => $userInfo['user_id'],
                    'email' => $userInfo['email'],
                    'birth_place' => $userInfo['birth_place'],
                    'mid_name' => $userInfo['mid_name'],
                    'valid' => $userInfo['valid'],
                    'user_type' => $userInfo['user_type'],
                    'ret_cd' => $userInfo['ret_cd'],
                    'first_name' => $userInfo['first_name'],
                    'full_name' => $userInfo['full_name'],
                ]);

            Auth::login($user);
        }
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Welcome to the Dashboard');
    }

    public function oneId()
    {
        $authorizationurl = "https://sso.egov.uz/sso/oauth/Authorization.do";
        $clientid = "test.epmty.uz";
        $response_type = "one_code";
        $redirect_uri = config('app.redirect_admin');
        $scope = "legal";
        $redirect_url = $authorizationurl . "?response_type=" . $response_type . "&client_id=" . $clientid . "&redirect_uri=" . $redirect_uri . "&scope=" . $scope . "&state=testState";
        return redirect($redirect_url);
    }
//
//    public function login(Request $request)
//    {
//        dd('s');
//        $this->validate($request, [
//            'email' => 'required|email',
//            'password' => 'required|min:6'
//        ]);
//
//        if (Auth::guard('admin')->attempt([
//            'email' => $request->email,
//            'password' => $request->password
//        ], $request->remember)) {
//            return redirect()->intended(route('admin.dashboard'));
//        }
//
//        return redirect()
//            ->back()
//            ->withInput($request->only('email', 'remember'));
//    }

//    public function logout()
//    {
//        Auth::guard('admin')->logout();
//        return redirect('/');
//    }
}
