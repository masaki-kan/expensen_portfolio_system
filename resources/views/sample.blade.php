<?php

$nums = [9, 1, 8, 2, 7, 3, 6, 4, 5, 11];
function array_sort($nums)
{
  // 要素数の繰り返し
  for ($i = 0; $i < count($nums); $i++) {
    // 要素数-1回の繰り返し
    for ($j = $i + 1; $j < count($nums) - 1; $j++) {
      // 隣同士を比較して順番に入れ替える
      if ($nums[$i] > $nums[$j]) {
        $num = $nums[$i];
        $nums[$i] = $nums[$j];
        $nums[$j] = $num;
      }
    }
  }
  return $nums;
}
