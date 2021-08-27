<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\CalendarAdminService;

class Calendar_admin extends Facade
{
  protected static function getFacadeAccessor()
  {
    return CalendarAdminService::class;
  }
}
