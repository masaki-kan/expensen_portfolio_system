<?php

namespace App\Services;

class CsvInportCheckService
{
  public static function checkCsv($date)
  {
    if ($date === date('Y/m/d', strtotime(mb_convert_encoding($date, 'UTF-8', 'SJIS')))) {

      $check = true;
    } elseif ($date === date('m/d/Y', strtotime(mb_convert_encoding($date, 'UTF-8', 'SJIS')))) {

      $check = true;
    } elseif ($date === date('Y-m-d', strtotime(mb_convert_encoding($date, 'UTF-8', 'SJIS')))) {

      $check = true;
    } elseif ($date === date('m-d-Y', strtotime(mb_convert_encoding($date, 'UTF-8', 'SJIS')))) {

      $check = true;
    } elseif ($date === date('Y:m:d', strtotime(mb_convert_encoding($date, 'UTF-8', 'SJIS')))) {

      $check = true;
    } elseif ($date === date('m:d:Y', strtotime(mb_convert_encoding($date, 'UTF-8', 'SJIS')))) {

      $check = true;
    } elseif ($date === date('Y/m/d', strtotime(mb_convert_encoding($date, 'UTF-8', 'SJIS')))) {

      $check = true;
    } else {

      $check = false;
    }

    return $check;
  }
}
