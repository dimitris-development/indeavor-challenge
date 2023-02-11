<?php

namespace App\Services;

use App\Models\Company;
use App\Repositories\CompanyRepository;

class CompanyService
{
    /**
     * Create a new service instance.
     *
     * @param  CompanyRepository  $companyRepository
     * @return void
     */
    public function __construct(private CompanyRepository $companyRepository)
    {
        //
    }

    /**
     * Store a new company.
     *
     * @param  array  $data
     * @return User
     */
    public function storeCompany(array $data): User
    {
        return $this->companyRepository->create($data);
    }

    /**
     * Get all companies.
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->companyRepository->all();
    }
}
