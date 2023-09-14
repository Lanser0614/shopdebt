<?php

namespace App\Models;

use App\Constants\RolesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'role_id',
        'google_id',
        'google_token',
        'google_refresh_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function shops():HasMany
    {
        return $this->hasMany(Shop::class);
    }
    public function seller():HasOne
    {
        return $this->hasOne(Seller::class);
    }
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function debts(): HasMany
    {
        return $this->hasMany(Debt::class);
    }

    public function checkShopId(array $shop_id): bool
    {
        if ($this->hasRole(RolesEnum::OWNER->value)){
            $shops_ids = $this->shops->pluck('id');
            return in_array($shops_ids, $shop_id);
        }
        return $this->seller->shop_id === $shop_id;
    }
}
