<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Member extends Model { protected $fillable=['display_name','real_name','role','term','bio','avatar','sort_order','is_public']; protected $casts=['is_public'=>'boolean']; }
