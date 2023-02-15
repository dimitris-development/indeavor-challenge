<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OAT;
use Illuminate\Validation\Rule;

class DetachSkillRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[OAT\Schema(
        schema: 'DetachSkillRequest',
        required: ['skills'],
        properties: [
            new OAT\Property(
                property: 'skills',
                type: 'array',
                items: new OAT\Items(type:'string', format: 'uuid', example: '717f46a9-1d19-4527-af39-ae872c951f17'),
            ),
        ],
    )]
    public function rules()
    {
        return [
            'skills' => 'required|max:1000|array',
            'skills.*' => 'uuid|exists:skills,uuid',
        ];
    }
}
