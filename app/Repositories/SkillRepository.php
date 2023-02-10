<?php

namespace App\Repositories;

use App\Models\Skill;

class SkillRepository extends BaseRepository
{
    /**
     * Create a new repository instance.
     *
     * @param Skill $skill
     * @return void
     */
    public function __construct(Skill $skill)
    {
        $this->model = $skill;
    }
}
