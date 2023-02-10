<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param Company $company
     * @return void
     */
    public function __construct(Company $company)
    {
        $this->model = $company;
    }
}
