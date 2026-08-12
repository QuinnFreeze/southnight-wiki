<?php

namespace App\Models;

use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name','username','email','email_verified_at','password','password_hash','password_salt','role','status','last_login_at'];
    protected $hidden = ['password','password_hash','password_salt','remember_token'];
    protected $casts = ['last_login_at'=>'datetime', 'email_verified_at'=>'datetime'];

    protected static function booted(): void
    {
        static::creating(function (User $user): void {
            if (!$user->uid) {
                $user->uid = self::generateUniqueUid();
            }
        });
    }

    private static function generateUniqueUid(): string
    {
        do {
            $uid = (string) random_int(10000000, 99999999);
        } while (self::query()->where('uid', $uid)->exists());

        return $uid;
    }

    public static function createWithUniqueUid(array $attributes): self
    {
        for ($attempt = 0; $attempt < 5; $attempt++) {
            try {
                return self::query()->create($attributes);
            } catch (QueryException $exception) {
                if (!str_contains(strtolower($exception->getMessage()), 'uid')) {
                    throw $exception;
                }
            }
        }

        throw new \RuntimeException('无法分配唯一 UID，请稍后重试。');
    }

    public function getAuthPassword() { return $this->password_hash ?: $this->password; }
    public function isAdmin(): bool { return $this->role === 'admin' && $this->status === 'active'; }
    public function verifyPassword(string $plain): bool {
        if ($this->password_salt && $this->password_hash) {
            $salt = base64_decode(strtr($this->password_salt, '-_', '+/').'===');
            $derived = hash_pbkdf2('sha256', $plain, $salt, 10000, 32, true);
            $candidate = rtrim(strtr(base64_encode($derived), '+/', '-_'), '=');
            return hash_equals($this->password_hash, $candidate);
        }
        return $this->password_hash ? password_verify($plain, $this->password_hash) : password_verify($plain, $this->password);
    }
}
