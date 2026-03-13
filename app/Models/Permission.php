<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasUuids, SoftDeletes;

    protected $fillable = ['name', 'guard_name', 'description'];

    public function getGroupAttribute()
    {
        $parts = explode('-', $this->name);
        return $parts[count($parts) - 1];
    }

    public static function getGroupedPermissions($guardName = 'admin')
    {
        return self::where('guard_name', $guardName)
            ->get()
            ->groupBy(function ($permission) {
                $parts = explode('-', $permission->name);
                return $parts[0];
            });
    }
}
