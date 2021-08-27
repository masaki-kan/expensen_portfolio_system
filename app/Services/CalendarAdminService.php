<?php

namespace App\Services;

use Carbon\Carbon;
use Auth;

class CalendarAdminService
{
  /**
   * month 文字列を返却する
   *
   * @return string
   */
  public function getMonth($ym)
  {
    // dd(Carbon::parse($ym)->format('Y年n月'));
    return Carbon::parse($ym)->format('Y年n月');
  }

  /**
   * prev 文字列を返却する
   *
   * @return string
   */
  public function getPrev($ym)
  {
    return Carbon::parse($ym)->subMonthsNoOverflow()->format('Y-m');
  }

  /**
   * next 文字列を返却する
   *
   * @return string
   */
  public function getNext($ym)
  {
    return Carbon::parse($ym)->addMonthNoOverflow()->format('Y-m');
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
  private static function getYm_firstday($ym)
  {
    return self::getYm($ym) . '-01';
  }
}
