<?php
namespace App\Http\Controllers;
use App\Models\Announcement;
use App\Models\Member;
use App\Models\ResearchTopic;
use App\Models\Project;
use Illuminate\View\View;
class SiteController extends Controller {
 public function home(): View { return view('pages.home',['announcements'=>Announcement::published()->latestPublished()->limit(3)->get(),'projects'=>Project::latest()->limit(3)->get()]); }
 public function about(): View { return view('pages.about'); }
 public function research(): View { return view('pages.research',['topics'=>ResearchTopic::where('status','published')->orderBy('sort_order')->get()]); }
 public function leadership(): View { return view('pages.leadership',['members'=>Member::where('is_public',true)->orderBy('sort_order')->get()]); }
 public function principles(): View { return view('pages.principles'); }
 public function privacy(): View { return view('pages.privacy'); }
 public function transparency(): View { return view('pages.transparency'); }
 public function sitemap() { return response()->view('sitemap')->header('Content-Type','application/xml'); }
}
