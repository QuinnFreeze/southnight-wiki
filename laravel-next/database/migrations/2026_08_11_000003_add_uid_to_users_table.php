<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('uid', 8)->nullable()->unique();
        });

        User::query()->whereNull('uid')->orderBy('id')->each(function (User $user): void {
            do {
                $uid = (string) random_int(10000000, 99999999);
            } while (DB::table('users')->where('uid', $uid)->exists());

            DB::table('users')->where('id', $user->id)->update(['uid' => $uid]);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['uid']);
            $table->dropColumn('uid');
        });
    }
};
