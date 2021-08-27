<?php

namespace App\Http\Controllers;

use App\Facades\Calendar;
use App\Facades\Calendar_other;
use App\Models\Relationtrain;
use App\Models\Train;
use App\Models\Line;
use App\Services\CalendarService;
use App\Services\CalendarOtherService;
use App\Http\Requests\CalenderDetailCreate;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ArrayService;

class CalenderController extends Controller
{
    private $service;

    public function __construct(CalendarService $service)
    {
        $this->service = $service;
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.calendar', [
            // 'weeks'         => $this->service->getWeeks(),
            'weeks'         => Calendar::getWeeks(Auth::user()->id),
            'month'         => Calendar::getMonth(),
            'prev'          => Calendar::getPrev(),
            'next'          => Calendar::getNext(),
        ]);
    }


    public function calendar_other()
    {
        # code...
        return view('admin.calendar_other', [
            // 'weeks'         => $this->service->getWeeks(),
            'weeks'         => Calendar_other::getWeeks(Auth::user()->id),
            'month'         => Calendar_other::getMonth(),
            'prev'          => Calendar_other::getPrev(),
            'next'          => Calendar_other::getNext(),
        ]);
    }

    public function caldender_detail($ymd, ArrayService $arrayService)
    {
        # code...
        $lines = Line::all();
        $trains_array = Train::where('date', 'LIKE', $ymd . '%')->where('user_id', Auth::user()->id)->get();
        $relationtrains = Relationtrain::where('user_id', Auth::user()->id)->get();
        $type_array = $arrayService->type();
        return view('admin.calender_detail', compact('ymd', 'trains_array', 'relationtrains', 'lines', 'type_array'));
    }

    public function caldender_other_detail($ymd, ArrayService $arrayService)
    {
        # code...
        $subjects = Subject::whereNotIn('subject', ['交通費'])->get();
        $trains_array = Train::where('date', 'LIKE', $ymd . '%')->where('user_id', Auth::user()->id)->whereNotIn('subject', [1])->orderBy('date', 'asc')->paginate(50);
        return view('admin.caldender_other_detail', compact('ymd', 'trains_array', 'subjects'));
    }


    public function applicant(Request $request)
    {
        if ($request) {
            foreach ($request['applicant'] as $app_id) {
                $result = Train::where('id', $app_id)->where('user_id', $request->user_id)->first();
                $result->status = 1;
                $result->save();
            }
            return response()->json([
                'format' => '成功'
            ]);
        } else {
            return response()->json([
                'format' => '失敗'
            ]);
        }
    }

    public function admin_app_no(Request $request)
    {
        if ($request) {
            foreach ($request['applicant'] as $app_id) {
                $result = Train::where('id', $app_id)->where('user_id', $request->user_id)->first();
                $result->status = 3;
                $result->save();
            }
            return response()->json([
                'format' => '成功'
            ]);
        } else {
            return response()->json([
                'format' => '失敗'
            ]);
        }
    }

    public function admin_app_ok(Request $request)
    {
        if ($request) {
            foreach ($request['applicant'] as $app_id) {
                $result = Train::where('id', $app_id)->where('user_id', $request->user_id)->first();
                $result->status = 2;
                $result->save();
            }
            return response()->json([
                'format' => '成功'
            ]);
        } else {
            return response()->json([
                'format' => '失敗'
            ]);
        }
    }

    public function caldender_delete($id)
    {
        # code...
        $train = Train::where('id', $id)->first();
        $relations = Relationtrain::where('train_id', $train->id)->get();

        foreach ($relations as $relation) {
            $data = Relationtrain::where('id', $relation->id)->first();
            if ($data != null) {
                $data->delete();
            }
        }
        $train->delete();
        return redirect()->back();
    }

    public function caldender_relation_delete($id)
    {
        $data = Relationtrain::where('id', $id)->first();
        $data->delete();
        return redirect()->back();
    }
    public function calendar_detail_create(CalenderDetailCreate $request)
    {

        # code...

        $formdate = $request->all();
        $createdate = Relationtrain::where('id', $formdate['id'])->first();
        if ($formdate['line']) {
            $createdate->line = intval($formdate['line']);
        }
        if ($formdate['ride']) {
            $createdate->ride = $formdate['ride'];
        }
        if ($formdate['getoff']) {
            $createdate->getoff = $formdate['getoff'];
        }
        if ($formdate['money']) {
            $createdate->money = intval($formdate['money']);
        }
        if ($formdate['type']) {
            $createdate->type = intval($formdate['type']);
        }
        if ($formdate['visit']) {
            $createdate->visit = $formdate['visit'];
        }
        $createdate->save();
        return redirect()->back();
    }
}
