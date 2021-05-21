# Laravel8 user roles and permission

## Project setup

1. composer install
```
composer install
```

2. configration
```
cp -n .env.example .env
```

3. database setup
```
php artisan migrate:fresh --seed
```

## Running the project
```
php artisan serve
```

## development guide

### Basic
First, add the Spatie\Permission\Traits\HasRoles trait to your User model(s):
```
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    // ...
}
```
Every role is associated with multiple permissions. A Role and a Permission are regular Eloquent models. They require a name and can be created like this:
```
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

$role = Role::create(['name' => 'Berichtswesen 1']);
$permission = Permission::create(['name' => 'article-view']);
```
A permission can be assigned to a role using 1 of these methods:
```
$role->givePermissionTo($permission);
$permission->assignRole($role);
```
Multiple permissions can be synced to a role using 1 of these methods:
```
$role->syncPermissions($permissions);
$permission->syncRoles($roles);
```
A permission can be removed from a role using 1 of these methods:
```
$role->revokePermissionTo($permission);
$permission->removeRole($role);
```

### Using middleware
This package comes with RoleMiddleware, PermissionMiddleware and RoleOrPermissionMiddleware middleware. You can add them inside your app/Http/Kernel.php file.
```
protected $routeMiddleware = [
    // ...
    'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
    'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
    'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
];
```

Then you can protect your routes using middleware rules:
```
Route::group(['middleware' => ['permission:article-submit']], function () {
    //
});
```

You can protect your controllers similarly, by setting desired middleware in the constructor:
```
public function __construct()
{
  $this->middleware('permission:article-submit', ['only' => ['create','store']]);
}
```
### Using in blade view

Permission
```
@can('article-submit')
    <a class="btn btn-success" href="{{ route('articles.create') }}"> Create New Article</a>
@endcan
```
or
```
@if(auth()->user()->can('article-edit') && $some_other_condition)
    <a class="btn btn-primary" href="{{ route('articles.edit',$article->id) }}">Edit</a>
@endif
```

Role
```
@role('Vertragswesen 2')
    //
@else
    //
@endrole
```