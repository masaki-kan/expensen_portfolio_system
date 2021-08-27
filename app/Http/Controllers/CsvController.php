<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pitapa;
use App\Models\Relationtrain;
use App\Models\Line;
use App\Services\CsvInportCheckService;
use App\Http\Requests\CsvpitapaRequest;
use App\Models\Train;
use App\Services\ArrayService;
use \SplFileObject;
use Carbon\Carbon;
use Auth;

class CsvController extends Controller
{
    //

    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function index()
    {
        return view('pitapa.csv');
    }

    public function pitapacsvup(CsvpitapaRequest $request)
    {
        // setlocaleを設定
        setlocale(LC_ALL, 'ja_JP.UTF-8');

        // アップロードしたファイルを取得
        // 'pitapacsv' はCSVファイルインポート画面の inputタグのname属性
        $uploaded_file = $request->file('pitapacsv');

        // アップロードしたファイルの絶対パスを取得
        $file_path = $request->file('pitapacsv')->path($uploaded_file);
        $file = new SplFileObject($file_path);
        $file->setFlags(\SplFileObject::READ_CSV | // CSVとして行を読み込み
            \SplFileObject::READ_AHEAD | // 先読み／巻き戻しで読み込み
            \SplFileObject::SKIP_EMPTY | // 空行を読み飛ばす
            \SplFileObject::DROP_NEW_LINE); // 行末の改行を読み飛ばす
        $row_count = 1;
        foreach ($file as $row) {
            // 1行目のヘッダーまでは取り込まない
            if ($row_count > 1) {
                // encodings 引数を配列で指定
                $encodings = [
                    "SJIS",
                    "UTF-8",
                ];
                //pitapaのcsvはエンコードされてない。
                $rowdate = mb_convert_encoding($row[0], 'UTF-8', 'SJIS');
                $result = CsvInportCheckService::checkCsv($rowdate);
                if ($result === true) {
                    //pitapa以外がアップされた時
                    //pitapaのcsvファイルを文字をutf-8にエンコード
                    $row_date = $rowdate;
                    $date = date('Y-m-d', strtotime($row_date));

                    $row_3 = mb_convert_encoding($row[3], 'UTF-8', 'SJIS');
                    $money = mb_convert_encoding($row[4], 'UTF-8', 'SJIS');

                    $betweendata[] = $date; //csv交通利用日付を配列に格納 突合用に使う

                    if (preg_match('/ＩＣ定期券/', $row_3)) {

                        return redirect()->back()->with('pitapamessase', 'アップロードに失敗しました。');
                    } else {

                        if (preg_match('/バス/', $row_3)) {
                            $ride = null;
                            $getoff = null;
                        } else {
                            $content = preg_replace("/( |　)/", "", $row_3); //全角スペースを消す
                            $arg = explode("−", $content); // -で分割
                            $ride = mb_substr($arg[0], "2",); //日本語ならmb_substr 英数字ならsubstr
                            $getoff = mb_substr($arg[1], "2",); //日本語ならmb_substr 英数字ならsubstr
                        }
                        if (Pitapa::where('user_id', Auth::user()->id)->where('user_name', Auth::user()->name)->where('date', $date)->where('ride', $ride)->where('getoff', $getoff)->where('money', $money)->exists()) {
                            $icdata = Pitapa::where('user_id', $request->user_id)->where('user_name', $request->user_name)->where('date', $date)->where('ride', $ride)->where('getoff', $getoff)->where('money', $money)->first();
                            $icdata->user_id = $request->user_id;
                            $icdata->user_name = $request->user_name;
                            $icdata->date = $date;
                            $icdata->ride = $ride;
                            $icdata->getoff = $getoff;
                            $icdata->money = $money;
                            $icdata->update();
                        } else {
                            // ここで値をデータベースに保存する
                            $icdata = new Pitapa;
                            $icdata->user_id = $request->user_id;
                            $icdata->user_name = $request->user_name;
                            $icdata->date = $date;
                            $icdata->ride = $ride;
                            $icdata->getoff = $getoff;
                            $icdata->money = $money;
                            $icdata->save();
                        }
                    }
                } elseif ($result === false) {
                    //日付が日付フォーマットではない時はその行はスキップする
                    continue;
                }
            }
            $row_count++;
        }

        if (isset($betweendata) == false) {
            return redirect()->back()->with('pitapamessase', 'アップロードに失敗しました。');
        } else {
            //Realtrain ログインしてるユーザーIDとcsvの日付配列で絞り込む
            $startdate = $betweendata[0];
            $enddate = end($betweendata);
            return redirect('/csv_complete/start=' . $startdate . '&end=' . $enddate);
        }
    }


    public function pitapacomplete($ymd1, $ymd2, ArrayService $arrayService)
    {
        if (Relationtrain::where('user_id', Auth::user()->id)->whereBetween('date', [$ymd1, $ymd2])->exists()) {
            $transfers = Relationtrain::where('user_id', Auth::user()->id)->whereBetween('date', [Carbon::parse($ymd1)->startOfDay(), Carbon::parse($ymd2)->endOfDay()])->orderBy('date', 'asc')->get();
            $icdatas = Pitapa::where('user_id', Auth::user()->id)->whereBetween('date', [$ymd1, $ymd2])->get();
            foreach ($transfers as $tsransvalue) {
                $comp[$tsransvalue->id] = array();
                $comp[$tsransvalue->id]['id'] = $tsransvalue->id;
                $comp[$tsransvalue->id]['date'] = $tsransvalue->date;
                $comp[$tsransvalue->id]['line'] = $tsransvalue->line;
                $comp[$tsransvalue->id]['ride'] = $tsransvalue->ride;
                $comp[$tsransvalue->id]['getoff'] = $tsransvalue->getoff;
                $comp[$tsransvalue->id]['money'] = intval($tsransvalue->money);
                $comp[$tsransvalue->id]['type'] = $tsransvalue->type;
                $comp[$tsransvalue->id]['memo'] = $tsransvalue->memo;
                $comp[$tsransvalue->id]['err'] = "";
                $comp[$tsransvalue->id]['statuscount'] = 0;

                if ($tsransvalue->status == 1) {
                    $comp[$tsransvalue->id]['statuscount'] = 1;
                } elseif ($tsransvalue->status == 0) {
                    $comp[$tsransvalue->id]['statuscount'] = 0;
                }

                if (Pitapa::where('date', '=', $tsransvalue->date)->where('ride', '=', $tsransvalue->ride)->exists()) {
                    $comp[$tsransvalue->id]['errride'] = true;
                } else {
                    $comp[$tsransvalue->id]['errride'] = false;
                }

                if (Pitapa::where('date', '=', $tsransvalue->date)->where('getoff', '=', $tsransvalue->getoff)->exists()) {
                    $comp[$tsransvalue->id]['errgetoff'] = true;
                } else {
                    $comp[$tsransvalue->id]['errgetoff'] = false;
                }

                if (Pitapa::where('date', '=', $tsransvalue->date)->where('money', '=', $tsransvalue->money)->exists()) {
                    $comp[$tsransvalue->id]['errmoney'] = true;
                } else {
                    $comp[$tsransvalue->id]['errmoney'] = false;
                }

                if (Pitapa::where('date', '=', $tsransvalue->date)->where('ride', '=', $tsransvalue->ride)->where('getoff', '=', $tsransvalue->getoff)->where('money', '=', $tsransvalue->money)->exists()) {
                    $comp[$tsransvalue->id]['err'] = true;
                } else {
                    $comp[$tsransvalue->id]['err'] = false;
                }
            }
            $type_array = $arrayService->type();
            $line_array = Line::all();
            return view(
                'pitapa.csv_complete',
                compact('transfers', 'comp', 'icdatas', 'type_array', 'line_array', 'ymd1', 'ymd2')
            );
        } else {
            return redirect()->back()->with('errmessage', '突合できるデータがありません。');
        }
    }

    public function csv_appli(Request $request)
    {
        foreach ($request["memo"] as $value) {
            foreach ($value as $key => $val) {
                if ($key == 0 && $val[0] == null) {
                    return redirect()->back()->with('message', "判定が✖️の項目には必ず備考の記入,もしくは修正して判定を○にして下さい。");
                }
            }
        }

        foreach ($request["id"] as $item) {
            $relationtrain_status = Relationtrain::where('id', $item[0])->first();
            foreach ($request["err"][$relationtrain_status->id] as $arg) {
                if ($arg[0] == "1") {
                    $relationtrain_status->hantei = 1;
                } elseif ($arg[0] == "0") {
                    $relationtrain_status->hantei = 0;
                }

                if ($relationtrain_status->status == 0) {
                    $relationtrain_status->status = 1;
                } else {
                    $relationtrain_status->status = 1;
                }
            }

            $train_status = Train::where('id', $relationtrain_status->train_id)->first();
            if ($train_status->status == 0) {
                $train_status->status = 1;
            } else {
                $train_status->status = 1;
            }
            $relationtrain_status->save();
            $train_status->save();
        }
        return redirect()->back()->with('message', "申請完了しました。");
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $data = Relationtrain::where('id', $request->id)->first();
        if (isset($request->ride)) {
            $data->ride = $request->ride;
        }
        if (isset($request->getoff)) {
            $data->getoff = $request->getoff;
        }
        if (isset($request->money)) {
            $data->money = $request->money;
        }
        if (isset($request->type)) {
            $data->type = $request->type;
        }
        if (isset($request->line)) {
            $data->line = $request->line;
        }
        if (isset($request->memo)) {
            $data->memo = $request->memo;
        }
        $data->save();
        return redirect()->back();
    }
}
