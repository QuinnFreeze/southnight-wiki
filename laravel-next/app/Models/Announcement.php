<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Announcement extends Model
{
    protected $fillable = ['title_zh','body_zh','title_en','body_en','status','pinned','author_id','published_at'];
    protected $casts = ['pinned' => 'boolean', 'published_at' => 'datetime'];
    public function author() { return $this->belongsTo(User::class, 'author_id'); }
    public function scopePublished(Builder $q): void { $q->where('status', 'published'); }
    public function scopeLatestPublished(Builder $q): void { $q->orderByDesc('pinned')->orderByDesc('published_at'); }
}
