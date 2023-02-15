<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OAT;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    #[OAT\Schema(
        schema: 'UpdateEmployeeRequest',
        required: ['first_name', 'last_name'],
        properties: [
            new OAT\Property(
                property: 'first_name',
                type: 'string',
                example: 'John'
            ),
            new OAT\Property(
                property: 'last_name',
                type: 'string',
                example: 'Doe'
            ),
        ]
    )]
    public function rules()
    {
        return [
            'first_name' => 'required|max:100',
            'last_name' => 'required|max:100'
        ];
    }
}
