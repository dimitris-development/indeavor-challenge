<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param Role $role
     * @return void
     */
    public function __construct(Role $role)
    {
        $this->model = $role;
    }
}
