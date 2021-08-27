<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\CalendarOtherService;

class Calendar_other extends Facade
{
  protected static function getFacadeAccessor()
  {
    return CalendarOtherService::class;
  }
}
