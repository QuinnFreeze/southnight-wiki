<?php
namespace App\Support;
use App\Models\ActivityLog;
class Audit {
 public static function record(string $action,?string $type=null,?string $id=null,?string $detail=null): void { ActivityLog::create(['user_id'=>auth()->id(),'action'=>$action,'target_type'=>$type,'target_id'=>$id,'detail'=>$detail]); }
}
