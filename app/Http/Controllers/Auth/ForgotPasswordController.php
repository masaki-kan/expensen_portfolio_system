<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SetMail;
use App\Models\User;
use App\Http\Requests\PasssetRequeset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;


    public function passreset()
    {
        return view('admin.passreset');
    }

    public function reset(Request $request)
    {
        $rule = [
            'email' => ['required', 'email']
        ];
        $message = [
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '正しいメールアドレスを入力してください。',
        ];

        $validate = Validator::make($request->all(), $rule, $message);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        } else {

            $userdate = User::where('email', $request->email)->first();
            if ($userdate == null) {
                return redirect()->back()->with('massege', '入力されたメールアドレスは未登録です。');
            }
            $useremail = $userdate->email;
            $username = $userdate->name;
            $md5 = substr(str_shuffle('123456789abcdefghijklmnopqrstuvwxyz'), 0, '12');
            $userdate->md5 = $md5;
            $pass = substr(str_shuffle('123456789abcdefghijklmnopqrstuvwxyz'), 0, '8');
            $userdate->password = password_hash($pass, PASSWORD_DEFAULT);
            $userdate->update();
            $data = [
                'name' => $username,
                'email' => $useremail,
                'md5' => $md5,
                'pass' => $pass
            ];
            Mail::to($useremail)->send(new SetMail($data));
            return redirect()->back()->with('massege', 'メールアドレス宛に初期設定案内のメールを送信しました。');
        }
    }

    public function userset($md5)
    {

        $user = User::where('md5', $md5)->first();
        $now = Carbon::createFromTimeStamp(strtotime($user->created_at))->diffForHumans();
        if ($now == "1日前") {
            return view('login.timeerr');
        } else {

            if ($user->md5 == $md5 && $user->flag == 0) {
                return view('login.top', compact('user'));
            } elseif ($user->md5 == $md5 && $user->flag == 1) {
                return view('auth.login');
            } else {
                return App::abort(404);
            }
        }
    }

    public function userreset($md5)
    {

        $user = User::where('md5', $md5)->first();
        if ($user == null) {
            return view('admin.passreset');
        }
        $now = Carbon::createFromTimeStamp(strtotime($user->created_at))->diffForHumans();
        if ($now == "1日前") {
            return view('login.timeerr');
        } else {

            if ($user->md5 == $md5 && $user->flag == 1) {

                if ($user->md5 == $md5 && $user->flag == 1) {
                    return view('login.top', compact('user'));
                } else {
                    return view('auth.login');
                }
            }
        }
    }


    public function passset(PasssetRequeset $request)
    {

        $user = User::where('id', $request->id)->first();
        if (password_verify($request->password_first, $user->password)) {
            $user->password =  password_hash($request->password, PASSWORD_DEFAULT);
            $user->flag = 1;
            $user->save();
            return redirect()->back()->with('sucssesmassege', 'パスワード更新をしました。ログインしてください。');
        } else {
            return redirect()->back()->with('massege', 'パスワード更新に失敗しました。再度入力してください。');
        }
    }
}
