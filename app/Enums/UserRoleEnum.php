<?php

namespace App\Enums;

use OpenApi\Attributes as OAT;

#[OAT\Schema()]
enum UserRoleEnum:string {
    case Admin = 'admin';
    case Scheduler = 'scheduler';
}