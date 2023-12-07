<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasTenants
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
        'password',
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
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    //the only user can access to admin
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(['Admin', 'Product Manager', 'Moderator', 'Customer', 'Report Manager']);
//        return str_ends_with($this->email, '@gmail.com') && $this->hasVerifiedEmail();
    }

    //The getTenants() method returns the teams that the user belongs to
    public function getTenants(Panel $panel): Collection
    {
        return $this->teams;
    }
    //one to many.  Users belong to many teams
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }


    //For security, you also need to implement the canAccessTenant() method of the HasTenants interface to prevent users from accessing the data of other tenants by guessing their tenant ID and putting it into the URL.
    public function canAccessTenant(Model $tenant): bool
    {
        return $this->teams->contains($tenant);
    }

    public function hasPermission(string $permission): bool
    {
        return $this->hasPermissionTo($permission);
    }
}
