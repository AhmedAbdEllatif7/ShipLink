<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\Auth\SendVerificationCode;
use Carbon\Carbon;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'type' => UserType::class,
        ];
    }

    public function merchant()
    {
        return $this->hasOne(Merchant::class);
    }

    public function driver()
    {
        return $this->hasOne(Driver::class);
    }

    public function verificationCodes()
    {
        return $this->hasMany(UserVerificationCode::class);
    }

    public function generateVerificationCode()
    {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $this->verificationCodes()->create([
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(15),
        ]);

        return $code;
    }

    public function sendEmailVerificationNotification()
    {
        $code = $this->generateVerificationCode();
        $this->notify(new SendVerificationCode($code));
    }
}
