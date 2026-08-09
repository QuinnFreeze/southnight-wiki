<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Announcement;
use App\Models\Member;
use App\Models\Project;
use App\Models\ResearchTopic;

class AdminController extends Controller
{
 public function index() { return view('admin.index',['users'=>User::count(),'announcements'=>Announcement::count(),'published'=>Announcement::where('status','published')->count(),'members'=>Member::count(),'projects'=>Project::count(),'research'=>ResearchTopic::count()]); }
 public function users() { return view('admin.users',['users'=>User::orderBy('id')->get()]); }
 public function updateUser(\Illuminate\Http\Request $request, User $user) { $data=$request->validate(['role'=>'required|in:user,admin','status'=>'required|in:active,blocked']); $user->update($data); \App\Support\Audit::record('user.update','user',(string)$user->id); return back()->with('status','用户权限已更新。'); }
}
