<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ArrayService;
use App\Models\Line;
use App\Models\Train;
use App\Models\Relationtrain;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransController extends Controller
{
    //
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function form(ArrayService $arrayService)
    {
        $type_array = $arrayService->type();
        $line_array = Line::all();
        return view('train.form', compact('type_array', 'line_array'));
    }

    public function other_form(ArrayService $arrayService)
    {
        $type_array = $arrayService->type();
        $line_array = Line::all();
        $subject_array = Subject::whereNotIn('subject', ['交通費'])->get();
        return view('train.other', compact('type_array', 'line_array', 'subject_array'));
    }

    public function input(Request $request)
    {
        // dd($request->all());
        $rules = [
            'date' => ['required'],
            'line.*' => ['required_with:line.*', 'required'],
            'ride.*' => ['required_with:line.*', 'required'],
            'getoff.*' => ['required_with:line.*', 'required'],
            'money.*' => ['required_with:line.*', 'required', 'numeric'],
            'visit' => ['required_with:line.*', 'required'],
            'type.*' => ['required_with:line.*', 'required'],
            'image' => ['file', 'mimes:pdf,jpg,png'],

        ];

        $messages = [
            'date.required' => '使用日は必須です。',
            'line.*.required' => '沿線は必須です。',
            'ride.*.required' => '乗車は必須です。',
            'getoff.*.required' => '降車は必須です。',
            'money.*.required' => '金額は必須です。',
            'type.*.required' => '使用理由は必須です。',
            'visit.*.required' => '訪問先は必須です。',
            'date.*.required_with' => '日付は必須です。',
            'ride.*.required_with' => '乗車名は必須です。',
            'getoff.*.required_with' => '降車名は必須です。',
            'money.*.required_with' => '金額は必須です。',
            'image.image' => 'ファイルをアップロードしてください。',
            'image.mimes' => 'pdf,jpg,pngでアップロードしてください。',
            'visit.required' => '訪問先は必須です。',
            'type.*.required_with' => '使用理由は必須です。',
        ];

        $validate = Validator::make($request->all(), $rules, $messages);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        } else {
            // dd($request->all());
            $realTrain = new Train;
            $realTrain->user_id = Auth::user()->id;
            $realTrain->date = $request->date;
            $realTrain->subject = 1;
            $realTrain->visit = $request->visit;
            $realTrain->reason = null;

            if ($request->file('image')) {
                $imagefile = $request->file('image');
                $temp_path = $imagefile->store('public/trans');
                $filename = str_replace('public/trans/', '', $temp_path);
                $realTrain->image = $filename;
            } else {
                $realTrain->image = null;
            }
            $realTrain->status = 0;
            $realTrain->applicant_flag = 0;
            $realTrain->save();

            $line_count = count($request->line);
            $ride_count = count($request->ride);
            $getoff_count = count($request->getoff);
            $money_count = count($request->money);
            $type_count = count($request->type);

            $arg = ($line_count + $ride_count + $getoff_count + $money_count + $type_count) / 5;

            for ($i = 0; $i < $arg; $i++) {
                $transfertrains = new Relationtrain;
                $transfertrains->train_id = $realTrain->id;
                $transfertrains->user_id = $realTrain->user_id;
                $transfertrains->date = $realTrain->date;

                $line = $request->line[$i];
                $ride = $request->ride[$i];
                $getoff = $request->getoff[$i];
                $money = $request->money[$i];
                $type = $request->type[$i];

                $transfertrains->line = $line;
                $transfertrains->ride = $ride;
                $transfertrains->getoff = $getoff;
                $transfertrains->money = $money;
                $transfertrains->type = $type;
                $transfertrains->hantei = 0;
                $transfertrains->status = 0;
                $transfertrains->save();
            }
            return redirect()->back()->with('massege', '登録完了しました。');
        }
    }

    public function other_input(Request $request)
    {
        // dd($request->all());
        $rules = [
            'date' => ['required'],
            'subject' => ['required'],
            'money' => ['required', 'numeric'],
            'image' => ['required', 'file', 'mimes:pdf,jpg,png,jpeg'],
            'reason' => ['required'],

        ];

        $messages = [
            'date.required' => '使用日は必須です。',
            'subject.required' => '項目を選択してください。',
            'reason.required' => '使用理由をしてください。',
            'money.required' => '金額は必須です。',
            'image.required' => '添付してください。',
            'image.file' => 'ファイルをアップロードしてください。',
            'image.mimes' => 'pdf,jpg,pngでアップロードしてください。',
            'reason.required' => '使用理由は必須です。',
        ];

        $validate = Validator::make($request->all(), $rules, $messages);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        } else {

            $realTrain = new Train;
            $realTrain->user_id = Auth::user()->id;
            $realTrain->date = $request->date;
            $realTrain->subject = $request->subject;
            $realTrain->money =  $request->money;
            $realTrain->visit =  null;
            $realTrain->reason =  $request->reason;

            if ($request->file('image')) {
                $imagefile = $request->file('image');
                $temp_path = $imagefile->store('public/other');
                $filename = str_replace('public/other/', '', $temp_path);
                $realTrain->image = $filename;
            }
            $realTrain->status = 0;
            $realTrain->applicant_flag = 0;
            $realTrain->save();
            return redirect()->back()->with('massege', '登録完了しました。');
        }
    }

    public function form_change(Request $request)
    {
        # code...
        if ($request->select == 0) {
            return redirect(route('trans_new'));
        } elseif ($request->select == 1) {
            return redirect(route('other_new'));
        }
    }
}
