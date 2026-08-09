<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Support\Audit;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index() { return view('announcements.index', ['announcements' => Announcement::published()->latestPublished()->paginate(20)]); }
    public function show(Announcement $announcement) { abort_unless(auth()->user()?->isAdmin() || $announcement->status === 'published', 404); return view('announcements.show', compact('announcement')); }
    public function create() { return view('admin.announcements.form', ['announcement' => new Announcement]); }
    public function store(Request $request) { $data=$this->validated($request); $data['author_id']=auth()->id(); $data['published_at']=$data['status']==='published'?now():null; $a=Announcement::create($data); Audit::record('announcement.create','announcement',(string)$a->id); return redirect()->route('admin.announcements.edit',$a)->with('status','公告已创建。'); }
    public function edit(Announcement $announcement) { return view('admin.announcements.form', compact('announcement')); }
    public function update(Request $request, Announcement $announcement) { $data=$this->validated($request); if ($data['status']==='published' && !$announcement->published_at) $data['published_at']=now(); $announcement->update($data); Audit::record('announcement.update','announcement',(string)$announcement->id); return redirect()->route('admin.announcements.edit',$announcement)->with('status','公告已更新。'); }
    public function destroy(Announcement $announcement) { $announcement->delete(); Audit::record('announcement.delete','announcement',(string)$announcement->id); return redirect()->route('admin.announcements.index')->with('status','公告已删除。'); }
    private function validated(Request $request): array { return $request->validate(['title_zh'=>'required|string|max:200','body_zh'=>'required|string|max:10000','title_en'=>'required|string|max:200','body_en'=>'required|string|max:10000','status'=>'required|in:draft,published','pinned'=>'nullable|boolean']); }
}
