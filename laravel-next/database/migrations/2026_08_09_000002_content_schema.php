<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
 public function up(): void {
  Schema::create('members', function(Blueprint $t){$t->id();$t->string('display_name');$t->string('real_name')->nullable();$t->string('role')->nullable();$t->string('term')->nullable();$t->text('bio')->nullable();$t->string('avatar')->nullable();$t->unsignedInteger('sort_order')->default(0);$t->boolean('is_public')->default(true);$t->timestamps();});
  Schema::create('research_topics', function(Blueprint $t){$t->id();$t->string('slug')->unique();$t->string('title_zh');$t->string('title_en');$t->text('summary_zh')->nullable();$t->text('summary_en')->nullable();$t->longText('body_zh')->nullable();$t->longText('body_en')->nullable();$t->string('status')->default('published');$t->unsignedInteger('sort_order')->default(0);$t->timestamps();});
  Schema::create('projects', function(Blueprint $t){$t->id();$t->string('slug')->unique();$t->string('title_zh');$t->string('title_en');$t->text('summary_zh')->nullable();$t->text('summary_en')->nullable();$t->longText('body_zh')->nullable();$t->longText('body_en')->nullable();$t->string('status')->default('exploring');$t->string('cover')->nullable();$t->json('tags')->nullable();$t->timestamps();});
  Schema::create('site_settings', function(Blueprint $t){$t->id();$t->string('key')->unique();$t->text('value')->nullable();$t->timestamps();});
 }
 public function down(): void {foreach(['site_settings','projects','research_topics','members'] as $t) Schema::dropIfExists($t);}
};
