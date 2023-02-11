<?php

namespace App\Enums;

use OpenApi\Attributes as OAT;

#[OAT\Schema()]
enum UserRoleEnum:string {
    case Admin = 'admin';
    case CompanyAdmin = 'company_admin';
    case Scheduler = 'scheduler';
}