<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_verification_challenges', function (Blueprint $table): void {
            $table->id();
            $table->string('email')->index();
            $table->string('purpose', 32)->index();
            $table->string('code_hash');
            $table->timestamp('expires_at')->index();
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('consumed_at')->nullable();
            $table->timestamps();

            $table->index(['email', 'purpose', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_verification_challenges');
    }
};
