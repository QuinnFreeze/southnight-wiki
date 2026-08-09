<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 24)->nullable()->unique();
            $table->string('password_hash')->nullable();
            $table->string('password_salt')->nullable();
            $table->string('role', 20)->default('user');
            $table->string('status', 20)->default('active');
            $table->timestamp('last_login_at')->nullable();
        });
        Schema::create('announcements', function (Blueprint $table) {
            $table->id(); $table->string('title_zh', 200); $table->text('body_zh');
            $table->string('title_en', 200); $table->text('body_en');
            $table->string('status', 20)->default('draft')->index(); $table->boolean('pinned')->default(false);
            $table->foreignId('author_id')->nullable()->index(); $table->timestamps(); $table->timestamp('published_at')->nullable()->index();
        });
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id(); $table->foreignId('user_id')->nullable(); $table->string('action');
            $table->string('target_type')->nullable(); $table->string('target_id')->nullable(); $table->text('detail')->nullable(); $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('activity_logs'); Schema::dropIfExists('announcements');
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['username']);
            foreach (['username','password_hash','password_salt','role','status','last_login_at'] as $column) $table->dropColumn($column);
        });
    }
};
