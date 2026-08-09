<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Project;
use App\Models\ResearchTopic;
use App\Support\Audit;
use Illuminate\Http\Request;

class AdminContentController extends Controller
{
    private array $map = ['members'=>Member::class, 'research'=>ResearchTopic::class, 'projects'=>Project::class];
    public function index(string $type) { $model=$this->model($type); $query=$model::query(); if($type !== 'projects') $query->orderBy('sort_order'); return view('admin.content', ['type'=>$type,'items'=>$query->orderBy('id')->get()]); }
    public function store(Request $request, string $type) { $model=$this->model($type); $data=$this->validated($request,$type); $item=$model::create($data); Audit::record('content.create',$type,(string)$item->id); return back()->with('status','内容已创建。'); }
    public function update(Request $request, string $type, int $id) { $model=$this->model($type); $item=$model::findOrFail($id); $item->update($this->validated($request,$type,$id)); Audit::record('content.update',$type,(string)$id); return back()->with('status','内容已更新。'); }
    public function destroy(string $type, int $id) { $model=$this->model($type); $model::findOrFail($id)->delete(); Audit::record('content.delete',$type,(string)$id); return back()->with('status','内容已删除。'); }
    private function model(string $type): string { abort_unless(isset($this->map[$type]),404); return $this->map[$type]; }
    private function validated(Request $r,string $type,?int $id=null): array {
        if($type==='members') return $r->validate(['display_name'=>'required|string|max:100','real_name'=>'nullable|string|max:100','role'=>'nullable|string|max:150','term'=>'nullable|string|max:100','bio'=>'nullable|string|max:5000','avatar'=>'nullable|string|max:255','sort_order'=>'nullable|integer|min:0','is_public'=>'nullable|boolean']);
        if($type==='research') return $r->validate(['slug'=>'required|string|max:100','title_zh'=>'required|string|max:200','title_en'=>'required|string|max:200','summary_zh'=>'nullable|string|max:5000','summary_en'=>'nullable|string|max:5000','body_zh'=>'nullable|string|max:20000','body_en'=>'nullable|string|max:20000','status'=>'required|in:draft,published','sort_order'=>'nullable|integer|min:0']);
        return $r->validate(['slug'=>'required|string|max:100','title_zh'=>'required|string|max:200','title_en'=>'required|string|max:200','summary_zh'=>'nullable|string|max:5000','summary_en'=>'nullable|string|max:5000','body_zh'=>'nullable|string|max:20000','body_en'=>'nullable|string|max:20000','status'=>'required|string|max:50','cover'=>'nullable|string|max:255','tags'=>'nullable|string|max:1000']);
    }
}
