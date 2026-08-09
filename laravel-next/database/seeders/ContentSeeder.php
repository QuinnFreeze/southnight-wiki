<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\ResearchTopic;
use App\Models\Project;

class ContentSeeder extends Seeder
{
 public function run(): void {
  $members=[['display_name'=>'小琪','real_name'=>null,'role'=>'第一任站长','sort_order'=>1],['display_name'=>'蔡哲宇','real_name'=>'蔡哲宇','role'=>'第二任站长','sort_order'=>2],['display_name'=>'殇秋','real_name'=>'李秋易','role'=>'第三任站长','sort_order'=>3],['display_name'=>'终局','real_name'=>'王伟鹏','role'=>'第四任站长','sort_order'=>4],['display_name'=>'林少','real_name'=>null,'role'=>'第五任站长','sort_order'=>5],['display_name'=>'LS','real_name'=>'刘星华','role'=>'第六任站长','sort_order'=>6]];
  foreach($members as $m) Member::updateOrCreate(['display_name'=>$m['display_name']],$m);
  $topics=[['slug'=>'ai-agents','title_zh'=>'AI 智能体实践','title_en'=>'AI Agent Practice','summary_zh'=>'探索智能体在真实场景中的有效利用，关注它们如何承担任务、连接工具并协助人类。','sort_order'=>1],['slug'=>'internet-technology','title_zh'=>'互联网技术研究','title_en'=>'Internet Technology','summary_zh'=>'研究网络技术、互联网基础设施与开放生态，通过实践和知识分享，理解网络系统如何运行、协作与持续演进。','sort_order'=>2],['slug'=>'cyber-security','title_zh'=>'网络安全维护','title_en'=>'Cybersecurity','summary_zh'=>'关注网络空间中的风险、责任和韧性，维护更加稳定、可信的数字环境。','sort_order'=>3]];
  foreach($topics as $t) ResearchTopic::updateOrCreate(['slug'=>$t['slug']],$t);
  $projects=[['slug'=>'ai-agent-practice','title_zh'=>'AI Agent 实践','title_en'=>'AI Agent Practice','summary_zh'=>'围绕个人 AI Agent、自动化工具、智能设备协同与真实使用场景进行探索。','status'=>'in_progress'],['slug'=>'open-internet','title_zh'=>'开放互联网实验','title_en'=>'Open Internet Experiments','summary_zh'=>'探索网站、域名、互联网基础设施及开放 Web 技术。','status'=>'exploring'],['slug'=>'cybersecurity-privacy','title_zh'=>'网络安全与隐私','title_en'=>'Cybersecurity & Privacy','summary_zh'=>'关注网站安全、基础设施维护、用户隐私保护及互联网安全实践。','status'=>'maintained']];
  foreach($projects as $p) Project::updateOrCreate(['slug'=>$p['slug']],$p);
 }
}
