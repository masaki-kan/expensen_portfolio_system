<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Calendar_admin;
use App\Models\User;
use App\Models\Company;
use App\Models\Relationtrain;
use App\Models\Train;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\ArrayService;
use App\Http\Requests\ValidateRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Line;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse; //csvが大量でもダウンロードできる


use App\Http\Requests\CompanyRequeset;
use App\Http\Requests\UsercreateRequeset;
use App\Models\Subject;
use ArrayAccess;
use Doctrine\Inflector\Rules\Ruleset;

class AdminController extends Controller
{
    //
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(ArrayService $arrayservices)
    {
        //現在の初月
        $startMonth = Carbon::now()->startOfMonth()->toDateString();
        //現在の月末
        $endMonth = Carbon::now()->endOfMonth()->toDateString();
        $ym =  Carbon::now()->format('Y-m');
        $explode = explode('-', $ym);
        $explode_y = $explode[0];
        $explode_m = $explode[1];

        $sex = $arrayservices->sex();
        $service = $arrayservices->service();
        $master = $arrayservices->master();
        $ys = $arrayservices->y();
        $ms = $arrayservices->m();
        $company = Company::all();

        $users = User::where('flag', 1)->orderBy('id', 'asc')->paginate(50);
        $trains_money = Train::whereBetween('date', [$startMonth, $endMonth])->where('user_id', Auth::user()->id)->whereNotIn('subject', [1])->where('status', 2)->sum('money');
        $trains2_money = Train::whereBetween('date', [$startMonth, $endMonth])->where('user_id', Auth::user()->id)->whereIn('subject', [2])->where('status', 2)->sum('money');
        $trains3_money = Train::whereBetween('date', [$startMonth, $endMonth])->where('user_id', Auth::user()->id)->whereIn('subject', [3])->where('status', 2)->sum('money');
        $trains4_money = Train::whereBetween('date', [$startMonth, $endMonth])->where('user_id', Auth::user()->id)->whereIn('subject', [4])->where('status', 2)->sum('money');
        $trains5_money = Train::whereBetween('date', [$startMonth, $endMonth])->where('user_id', Auth::user()->id)->whereIn('subject', [5])->where('status', 2)->sum('money');
        $trains6_money = Train::whereBetween('date', [$startMonth, $endMonth])->where('user_id', Auth::user()->id)->whereIn('subject', [6])->where('status', 2)->sum('money');
        $relations_money = Relationtrain::whereBetween('date', [$startMonth, $endMonth])->where('user_id', Auth::user()->id)->where('status', 1)->sum('money');
        return view('admin.top', compact('trains_money', 'trains2_money', 'trains3_money', 'trains4_money', 'trains5_money', 'trains6_money', 'relations_money', 'sex', 'service', 'master', 'users', 'ym', 'ys', 'ms', 'explode_y', 'explode_m', 'company'));
    }

    public function user_search(Request $request, ArrayService $arrayservices)
    {
        //現在の初月
        $startMonth = Carbon::now()->startOfMonth()->toDateString();
        //現在の月末
        $endMonth = Carbon::now()->endOfMonth()->toDateString();
        $ym =  Carbon::now()->format('Y-m');
        $explode = explode('-', $ym);
        $explode_y = $explode[0];
        $explode_m = $explode[1];

        $sex = $arrayservices->sex();
        $service = $arrayservices->service();
        $master = $arrayservices->master();
        $ys = $arrayservices->y();
        $ms = $arrayservices->m();
        $company = Company::all();

        $trains_money = Train::whereBetween('date', [$startMonth, $endMonth])->where('user_id', Auth::user()->id)->whereNotIn('subject', [1])->where('status', 2)->sum('money');
        $trains2_money = Train::whereBetween('date', [$startMonth, $endMonth])->where('user_id', Auth::user()->id)->whereIn('subject', [2])->where('status', 2)->sum('money');
        $trains3_money = Train::whereBetween('date', [$startMonth, $endMonth])->where('user_id', Auth::user()->id)->whereIn('subject', [3])->where('status', 2)->sum('money');
        $trains4_money = Train::whereBetween('date', [$startMonth, $endMonth])->where('user_id', Auth::user()->id)->whereIn('subject', [4])->where('status', 2)->sum('money');
        $trains5_money = Train::whereBetween('date', [$startMonth, $endMonth])->where('user_id', Auth::user()->id)->whereIn('subject', [5])->where('status', 2)->sum('money');
        $trains6_money = Train::whereBetween('date', [$startMonth, $endMonth])->where('user_id', Auth::user()->id)->whereIn('subject', [6])->where('status', 2)->sum('money');
        $relations_money = Relationtrain::whereBetween('date', [$startMonth, $endMonth])->where('user_id', Auth::user()->id)->where('status', 1)->sum('money');
        $userdate = User::query();
        if (isset($request->user_name)) {
            $userdate->where('name', 'LIKE', '%' . $request->user_name . '%');
        }
        if (isset($request->user_service)) {
            $userdate->where('service', $request->user_service);
        }

        $users = $userdate->where('flag', 1)->orderBy('id', 'asc')->paginate(50);

        $user_name = $request->user_name;
        $user_service = $request->user_service;

        return view('admin.top_search', compact('trains_money', 'relations_money', 'sex', 'service', 'master', 'users', 'trains2_money', 'trains3_money', 'trains4_money', 'trains5_money', 'trains6_money', 'user_name', 'user_service', 'ym', 'ys', 'ms', 'explode_y', 'explode_m', 'company'));
    }

    public function expensenForm()
    {
        return view('admin.expensenform');
    }

    public function expensen_input(Request $request)
    {
    }


    public function usernew(ArrayService $arrayservices)
    {
        $sex = $arrayservices->sex();
        $master = $arrayservices->master();
        $service = $arrayservices->service();
        $companies = Company::all();
        return view('admin.userNew', compact('sex', 'service', 'master', 'companies'));
    }

    public function user_input(ValidateRequest $request)
    {

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->tel = $request->tel;
        $user->sex = $request->sex;
        $user->service = $request->service;
        $md5 = substr(str_shuffle('123456789abcdefghijklmnopqrstuvwxyz'), 0, '12');
        $user->md5 = $md5;
        if ($request->service == 2 || $request->service == 3) {
            $user->company = 0;
        }
        if (isset($request->company)) {
            $user->company = $request->company;
        } else {
            $user->company = null;
        }
        $pass = substr(str_shuffle('123456789abcdefghijklmnopqrstuvwxyz'), 0, '8');
        $user->password = password_hash($pass, PASSWORD_DEFAULT);
        $user->master_flag = $request->master_flag;
        $user->flag = 0;
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'md5' => $md5,
            'pass' => $pass
        ];

        Mail::to($request->email)->send(new SendMail($data));
        $user->save();
        return redirect()->back()->with('massege', '登録完了しました。メールアドレス宛に初期設定案内のメールを送信しました。');
    }


    public function usercreate(UsercreateRequeset $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->tel = $request->tel;
        $user->sex = $request->sex;
        $user->service = $request->service;
        if (isset($request->company)) {
            $user->company = $request->company;
        } else {
            $user->company = 0;
        }
        $user->save();
        return redirect()->back()->with('message', '修正が完了しました。');
    }

    public function userlist(ArrayService $arrayService)
    {

        $sex = $arrayService->sex();
        $service = $arrayService->service();
        $master = $arrayService->master();

        $users = User::where('flag', 1)->orderBy('id', 'asc')->paginate(50);
        return view('admin.userlist', compact('users', 'sex', 'service', 'master'));
    }

    public function userdetail($id, ArrayService $arrayservices)
    {
        $users = User::find($id);
        $company = Company::all();
        $sex = $arrayservices->sex();
        $service = $arrayservices->service();
        return view('admin.userdetail', compact('users', 'sex', 'service', 'company'));
    }

    public function company_new()
    {
        return view('admin.companynew');
    }

    public function company_input(CompanyRequeset $request)
    {
        $company = new Company;
        $company->name = $request->name;
        $company->tel = $request->tel;
        $company->email = $request->email;
        $company->zip = $request->zip;
        $company->address = $request->address;
        $company->save();
        return redirect()->back()->with('message', '登録が完了しました。');
    }

    public function companylist()
    {
        $company = Company::all();
        return view('admin.companylist', compact('company'));
    }

    public function company_detail($id)
    {
        $company = Company::find($id);
        return view('admin.companydetail', compact('company'));
    }


    public function admintrans($id, $ym, ArrayService $arrayService)
    {
        # code...
        $lines = Line::all();
        $type_array = $arrayService->type();
        $userdate = User::where('id', $id)->first();
        $relationtrains = Relationtrain::Where('user_id', $id)->where('date', 'LIKE', $ym . '%')->where('status', 1)->orderBy('list_order', 'ASC')->get();
        return view(
            'admin.trans',
            compact('relationtrains', 'ym', 'id', 'lines', 'type_array', 'userdate'),
            [
                // 'weeks'         => $this->service->getWeeks(),
                // 'weeks'         => Calendar_admin::getWeeks($id),
                'month'         => Calendar_admin::getMonth($ym),
                'prev'          => Calendar_admin::getPrev($ym),
                'next'          => Calendar_admin::getNext($ym),
            ]
        );
    }

    public function adminother($id, $ym, ArrayService $arrayService)
    {
        # code...
        $subjects = Subject::whereNotIN('subject', ['交通費'])->get();
        $userdate = User::where('id', $id)->first();
        $relationtrains = Train::Where('user_id', $id)->where('date', 'LIKE', $ym . '%')->whereNotIn('subject', [0])->whereNotIn('status', [0])->paginate(50);
        return view(
            'admin.other',
            compact('relationtrains', 'ym', 'id', 'subjects', 'userdate'),
            [
                // 'weeks'         => $this->service->getWeeks(),
                // 'weeks'         => Calendar_admin::getWeeks($id),
                'month'         => Calendar_admin::getMonth($ym),
                'prev'          => Calendar_admin::getPrev($ym),
                'next'          => Calendar_admin::getNext($ym),
            ]
        );
    }

    public function csvexp(Request $request, ArrayService $arrayService)
    {
        $d = now();

        //一般の人

        $user = User::where('name', $request->user_name)->where('id', $request->user_id)->first();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="交通費データ_"' . $user->name . $d . '.csv',
        ];
        $csvdata = new StreamedResponse(
            function () use ($request, $arrayService) {
                //postデータから作成
                $line_array = [1 => 'JR', 2 => '地下鉄', 3 => '阪神', 4 => '阪急', 5 => '近鉄', 6 => '南海', 7 => '京阪', 8 => '神戸電鉄', 9 => 'その他'];
                $train_array = [0 => '出勤', 1 => '退勤', 2 => 'エリア移動'];
                $user = User::where('name', $request->user_name)->where('id', $request->user_id)->first();
                $month = str_replace('/', '-', $request->ym);
                $user_name = $user->name;
                $user_id = $user->id;

                $relationtrain = Relationtrain::query();
                //年月 社員名
                $relationtrain->where('date', 'LIKE', $month . '%')
                    ->where('user_id', 'LIKE', "%{$user_id}%")->where('status', 1);

                //ヘッダー項目
                $kuuhaku = [''];
                $user_name =
                    // ['', '', '', '', '', '', '', '', '社員番号', $user->num, '', '', '名前', $user->name, '', '', '', '', '', ''];
                    ['', '', '', '', '', '', '', '', '', '名前', $user->name, '', '', '', '', '', ''];
                $koutuhi_syuosai =
                    ['', '', 'No.', '日付', '沿線', '自（駅名）', '至（駅名）', '片道', '金額', '出退勤', '備考'];

                $stream = fopen('php://output', 'w');
                // ExcelでUTF-8と認識させるためにBOMを付ける(変更部分)
                fwrite($stream, pack('C*', 0xEF, 0xBB, 0xBF));
                // paypay交通費
                // ヘッダー行を追加
                fputcsv($stream, $kuuhaku);
                fputcsv($stream, $user_name);
                fputcsv($stream, $kuuhaku);

                fputcsv($stream, $koutuhi_syuosai);
                // chunkではなくcursorを使用(変更部分)
                $trains = $relationtrain->orderBy("list_order", 'asc')->get();

                foreach ($trains as $key => $train) {
                    fputcsv($stream, ['', '', $key + 1, $train->date, $line_array[$train->line], $train->ride, $train->getoff, '片道', $train->money, $train_array[$train->type], $train->memo]);
                }

                fclose($stream);
            },
            200,
            $headers
        );
        return $csvdata;
    }

    public function updateItems(Request $request)
    {
        $tasks = Relationtrain::all();
        foreach ($tasks as $task) {

            $id = $task->id;

            foreach ($request->order as $order) {
                if ($order['id'] == $id) {
                    $task->list_order = $order['position'];
                    $task->update();
                }
            }
        }
        return response()->json(['status' => 'success']);
    }

    public function other_change(Request $request)
    {
        $user = User::where('id', $request['user_id'])->first();
        $user_id = $user->id;
        $ym = $request->ym;
        $subjects = Subject::whereNotIN('subject', ['交通費'])->get();
        if ($request->other_select_op == 0) {

            $relationtrains = Train::whereNotIn('subject', [0])->where('user_id', $user_id)->where('date', 'LIKE', $ym . '%')->whereNotIn('status', [0])->orderBy('date', 'asc')->get();
            return response()->json([
                'val' => $request->other_select_op,
                'formdata' => view(
                    'admin_select_expensen.other_change',
                    compact(
                        'relationtrains',
                        'subjects'
                    )
                )->render()
            ]);
        } else {

            $relationtrains = Train::where('subject', $request->other_select_op)->where('user_id', $user_id)->where('date', 'LIKE', $ym . '%')->whereNotIn('status', [0])->orderBy('date', 'asc')->get();
            return response()->json([
                'val' => $request->other_select_op,
                'formdata' => view(
                    'admin_select_expensen.other_change',
                    compact(
                        'relationtrains',
                        'subjects'
                    )
                )->render()
            ]);
        }
    }

    public function sum_change(Request $request, ArrayService $arrayservices)
    {

        // dd($request->all());
        $user = User::where('id', $request['user_id'])->first();
        $ys = $arrayservices->y();
        $ms = $arrayservices->m();
        $ym = $request['change_y'] . '-' . $request['change_m'];
        $explode_y = $request['change_y'];
        $explode_m = $request['change_m'];
        $trains_money = Train::where('date', 'LIKE', $request['change_y'] . '-' . $request['change_m'] . '%')->where('user_id', $request['user_id'])->whereNotIn('subject', [1])->where('status', 2)->sum('money');
        $trains2_money = Train::where('date', 'LIKE', $request['change_y'] . '-' . $request['change_m'] . '%')->where('user_id', $request['user_id'])->whereIn('subject', [2])->where('status', 2)->sum('money');
        $trains3_money = Train::where('date', 'LIKE', $request['change_y'] . '-' . $request['change_m'] . '%')->where('user_id', $request['user_id'])->whereIn('subject', [3])->where('status', 2)->sum('money');
        $trains4_money = Train::where('date', 'LIKE', $request['change_y'] . '-' . $request['change_m'] . '%')->where('user_id', $request['user_id'])->whereIn('subject', [4])->where('status', 2)->sum('money');
        $trains5_money = Train::where('date', 'LIKE', $request['change_y'] . '-' . $request['change_m'] . '%')->where('user_id', $request['user_id'])->whereIn('subject', [5])->where('status', 2)->sum('money');
        $trains6_money = Train::where('date', 'LIKE', $request['change_y'] . '-' . $request['change_m'] . '%')->where('user_id', $request['user_id'])->whereIn('subject', [6])->where('status', 2)->sum('money');
        $relations_money = Relationtrain::where('date', 'LIKE', $request['change_y'] . '-' . $request['change_m'] . '%')->where('user_id', $request['user_id'])->where('status', 1)->sum('money');

        return response()->json([
            'explode_y' => $request['change_y'],
            'explode_m' => $request['change_m'],
            'formdata' => view(
                'top_sum_change.sum_change',
                compact(
                    'explode_y',
                    'explode_m',
                    'trains_money',
                    'trains2_money',
                    'trains3_money',
                    'trains4_money',
                    'trains5_money',
                    'trains6_money',
                    'relations_money',
                    'ym',
                    'ys',
                    'ms'
                )
            )->render()
        ]);
    }

    public function myprofile(ArrayService $arrayservices)
    {
        $users = User::where('id', Auth::user()->id)->first();
        $sex = $arrayservices->sex();
        $service = $arrayservices->service();
        $masters = $arrayservices->master();
        return view('admin.myprofile', compact('users', 'sex', 'service', 'masters'));
    }

    public function profimage(Request $request)
    {
        $login_user = User::where('id', Auth::user()->id)->first();
        if ($request->file('image')) {
            $imageData = $request->file('image');
            $path = $imageData->store('public/profile');
            $filename = str_replace('public/profile/', '', $path);
            $login_user->image = $filename;
        } else {
            $login_user->image = null;
        }
        $login_user->update();
        return response()->json();
    }

    public function admin_myprofile($id, ArrayService $arrayservices)
    {
        $users = User::where('id', $id)->first();
        $sex = $arrayservices->sex();
        $service = $arrayservices->service();
        $masters = $arrayservices->master();
        $company = Company::all();
        return view('admin.user_profile', compact('users', 'sex', 'service', 'masters', 'company'));
    }
}
