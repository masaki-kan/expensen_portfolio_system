<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Train;
use Illuminate\Http\Request;
use Auth;

class CalendarOtherService
{
  /**
   * カレンダーデータを返却する
   *
   * @return array
   */
  public function getWeeks($user_id)
  {
    $weeks = [];
    $week = '';

    $dt = new Carbon(self::getYm_firstday()); //carbonインスタンス生成
    //CarbonはPHPに標準実装されているDateTimeクラスを継承した日時を扱うクラス。
    $day_of_week = $dt->dayOfWeek;     // 曜日
    $days_in_month = $dt->daysInMonth; // その月の日数


    // 第 1 週目に空のセルを追加
    $week .= str_repeat('<td></td>', $day_of_week);
    for ($day = 1; $day <= $days_in_month; $day++, $day_of_week++) {
      $date = self::getYm() . '-' . $day;
      $train_date = date('Y-m-d', strtotime($date)); //フォーマットをRealtrainに合わせる
      $user = Train::where('user_id', $user_id)->where('date', 'LIKE', $train_date . '%')->whereNotIn('subject', [0])->exists();
      //カレンダーの日付がデータベースにあるかないか
      if ($user == true) {
        //あったら●
        $week .= '<td style="background: #fdfb9c;">' . $day . '<br><a href="/caldender_other_detail/' . $train_date . '"><i class="far fa-circle"></i></a>';
      } else {
        //なかったら✖️
        $week .= '<td>' . $day . '<br><i class="fas fa-times"></i>';
      }

      $week .= '</td>';

      // 週の終わり、または月末
      if (($day_of_week % 7 === 6) || ($day === $days_in_month)) {
        if ($day === $days_in_month) {
          $week .= str_repeat('<td></td>', 6 - ($day_of_week % 7));
        }
        $weeks[] = '<tr>' . $week . '</tr>';
        $week = '';
      }
    }
    return $weeks;
  }

  /**
   * month 文字列を返却する
   *
   * @return string
   */
  public function getMonth()
  {
    return Carbon::parse(self::getYm_firstday())->format('Y年n月');
  }

  /**
   * prev 文字列を返却する
   *
   * @return string
   */
  public function getPrev()
  {
    return Carbon::parse(self::getYm_firstday())->subMonthsNoOverflow()->format('Y-m');
  }

  /**
   * next 文字列を返却する
   *
   * @return string
   */
  public function getNext()
  {
    return Carbon::parse(self::getYm_firstday())->addMonthNoOverflow()->format('Y-m');
  }

  /**
   * GET から Y-m フォーマットを返却する
   *
   * @return string
   */
  private static function getYm()
  {

    if (isset($_GET['ym'])) {
      return $_GET['ym'];
    }
    return Carbon::now()->format('Y-m');
  }

  /**
   * 2019-09-01 のような月初めの文字列を返却する
   *
   * @return string
   */
  private static function getYm_firstday()
  {
    return self::getYm() . '-01';
  }
}
