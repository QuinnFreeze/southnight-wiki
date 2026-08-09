<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    protected $fillable = ['name','username','email','password','password_hash','password_salt','role','status','last_login_at'];
    protected $hidden = ['password','password_hash','password_salt','remember_token'];
    protected $casts = ['last_login_at'=>'datetime'];
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
