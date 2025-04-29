# Laravel Roles & Permissions (commacodes/laravel-roles-permissions)

This Laravel package provides a simple role and permission system using JSON-based permissions.

## Installation

```bash
composer require commacodes/laravel-roles-permissions
```

> Publish config and migration files:
```bash
php artisan vendor:publish --provider="Commacodes\RolesPermissions\RolesPermissionsServiceProvider"
php artisan migrate
```

## Configuration

Edit `config/global.php` to define your available permissions:

```php
return [
    'permissions' => [
        'dashboard' => 'لوحة التحكم',
        'settings' => 'الإعدادات',
        // ...
    ],
];
```

## Usage

### Role Model

- Permissions are stored as a JSON array in the `permissions` column (nullable).

### User Model

Add the following method:

```php
public function hasAbility($permissions)
{
    $role = $this->role;
    if (!$role) return false;

    foreach ($role->permissions as $permission) {
        if (is_array($permissions) && in_array($permission, $permissions)) {
            return true;
        } elseif (is_string($permissions) && strcmp($permission, $permissions) === 0) {
            return true;
        }
    }

    return false;
}
```

### AuthServiceProvider

```php
use Illuminate\Support\Facades\Gate;

public function boot()
{
    $this->registerPolicies();

    foreach (config('global.permissions') as $ability => $label) {
        Gate::define($ability, function ($auth) use ($ability) {
            return $auth->hasAbility($ability);
        });
    }
}
```

### Blade Usage

```blade
@can('dashboard')
    <li><a href="/dashboard">Dashboard</a></li>
@endcan
```

### Route Middleware

```php
Route::middleware(['can:dashboard'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
```

## License

MIT © Commacodes
