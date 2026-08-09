<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ResearchTopic extends Model { protected $fillable=['slug','title_zh','title_en','summary_zh','summary_en','body_zh','body_en','status','sort_order']; }
