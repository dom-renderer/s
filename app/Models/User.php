<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Passport\Contracts\OAuthenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements OAuthenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where( 'status', 1 );
    }

    public function scopeInactive($query)
    {
        return $query->where( 'status', 0 );
    }

    public function scopePending($query)
    {
        return $query->where( 'approved', 0 );
    }

    public function scopeApproved($query)
    {
        return $query->where( 'approved', 1 );
    }

    public function setPasswordAttribute($value)
    {
       $this->attributes['password'] = bcrypt($value);
    }   
    
    public function getUserProfileAttribute() {
        if (!empty(trim($this->profile)) && file_exists(public_path("storage/users/profile/{$this->profile}"))) {
            return asset("storage/users/profile/{$this->profile}");
        }

        return asset('assets/images/profile.png');
    }

    public static function isAdmin() {
        return boolval(auth()->user()->roles->where('name', 'admin')->count());
    }

    public function countryr () {
        return $this->belongsTo(Country::class, 'country');
    }

    public function stater () {
        return $this->belongsTo(State::class, 'state');
    }
    
    public function cityr () {
        return $this->belongsTo(City::class, 'city');
    }
}
