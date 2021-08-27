<?php


namespace App\Services;

class ArrayService
{
  public function sex()
  {
    return array('男性', '女性', 'その他');
  }
  public function service()
  {
    return array('正社員', '契約社員', '業務委託', '派遣社員');
  }
  public function type()
  {
    return array(0 => '出勤', 1 => '退勤', 2 => 'エリア移動');
  }

  public function master()
  {
    return array(0 => '一般', 1 => '管理者');
  }

  public function y()
  {
    return array(2020, 2021, 2023, 2024, 2025, 2026, 2027, 2028, 2029, 2030);
  }
  public function m()
  {
    return array('01' => 1, '02' => 2, '03' => 3, '04' => 4, '05' => 5, '06' => 6, '07' => 7, '08' => 8, '09' => 9, '10' => 10, '11' => 11, '12' => 12);
  }
}
