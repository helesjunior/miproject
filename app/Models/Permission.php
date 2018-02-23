<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Role;

class Permission extends \Spatie\Permission\Models\Permission
{
    protected $fillable = [
        'name', 'description', 'guard_name'
    ];
}
