<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function me() { $u=auth()->user(); return response()->json(['user'=>$u?['uid'=>$u->uid,'username'=>$u->username,'email'=>$u->email,'role'=>$u->role]:null]); }
    public function announcements(Request $request) {
        $u=$request->user();
        $q=Announcement::with('author')->when(!$u || !$u->isAdmin(), fn($q)=>$q->published())->latestPublished();
        $items=$q->limit($u?100:20)->get()->map(fn($a)=>['id'=>$a->id,'title_zh'=>$a->title_zh,'body_zh'=>$a->body_zh,'title_en'=>$a->title_en,'body_en'=>$a->body_en,'status'=>$a->status,'pinned'=>(bool)$a->pinned,'published_at'=>$a->published_at,'created_at'=>$a->created_at,'author'=>$a->author?->username]);
        return response()->json(['success'=>true,'results'=>$items]);
    }
    public function login(Request $request) {
        $data=$request->validate(['identity'=>'required|string','password'=>'required|string']);
        $u=User::where('username',$data['identity'])->orWhere('email',$data['identity'])->first();
        if(!$u || $u->status!=='active' || !$u->verifyPassword($data['password'])) return response()->json(['error'=>'用户名、邮箱或密码不正确。'],401);
        auth()->login($u,true); $request->session()->regenerate(); $u->forceFill(['last_login_at'=>now()])->save();
        return response()->json(['ok'=>true,'user'=>['username'=>$u->username,'role'=>$u->role]]);
    }
    public function register(Request $request) {
        $data=$request->validate(['username'=>'required|string|min:3|max:24|unique:users,username','email'=>'required|email|max:255|unique:users,email','password'=>'required|string|min:10']);
        $u=User::createWithUniqueUid(['name'=>$data['username'],'username'=>$data['username'],'email'=>$data['email'],'password'=>password_hash($data['password'],PASSWORD_DEFAULT),'role'=>User::count()===0?'admin':'user','status'=>'active']);
        return response()->json(['ok'=>true,'message'=>'注册成功。','uid'=>$u->uid,'role'=>$u->role],201);
    }
    public function logout(Request $request) { auth()->logout(); $request->session()->invalidate(); $request->session()->regenerateToken(); return response()->json(['ok'=>true]); }
}
