<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param Employee $employee
     * @return void
     */
    public function __construct(Employee $employee)
    {
        $this->model = $employee;
    }
}
