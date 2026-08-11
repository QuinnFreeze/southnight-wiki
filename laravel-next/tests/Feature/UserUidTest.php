<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserUidTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_users_receive_distinct_eight_digit_uids(): void
    {
        $first = User::createWithUniqueUid($this->attributes('one'));
        $second = User::createWithUniqueUid($this->attributes('two'));

        $this->assertMatchesRegularExpression('/^[1-9][0-9]{7}$/', $first->uid);
        $this->assertMatchesRegularExpression('/^[1-9][0-9]{7}$/', $second->uid);
        $this->assertNotSame($first->uid, $second->uid);
    }

    public function test_uid_cannot_be_changed_through_mass_assignment(): void
    {
        $user = User::createWithUniqueUid($this->attributes('fixed'));
        $uid = $user->uid;

        $user->update(['uid' => '12345678']);

        $this->assertSame($uid, $user->fresh()->uid);
    }

    private function attributes(string $suffix): array
    {
        return [
            'name' => $suffix,
            'username' => $suffix,
            'email' => $suffix.'@example.com',
            'password' => password_hash('password-for-tests', PASSWORD_DEFAULT),
            'role' => 'user',
            'status' => 'active',
        ];
    }
}
