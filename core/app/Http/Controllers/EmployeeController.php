<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Requests\DetachSkillRequest;
use App\Http\Requests\AttachSkillRequest;
use App\Models\Employee;
use App\Models\Skill;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\EmployeeResource;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Database\Eloquent\Builder;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    #[OAT\Get(
        tags: ['employees'],
        path: '/api/employees',
        summary: 'Show employees',
        operationId: 'EmployeeController.index',
        security: [['BearerToken' => []]],
        parameters: [
            new OAT\Parameter(
                name: 'page',
                in: 'query',
            ),
            new OAT\Parameter(
                name: 'sortType',
                in: 'query',
            )
        ],
        responses: [
            new OAT\Response(
                response: HttpResponse::HTTP_OK,
                description: 'Ok',
                content: new OAT\JsonContent(
                    type: 'array',
                    items: new OAT\Items(ref: '#/components/schemas/EmployeeResource')
                ) 
            ),
            new OAT\Response(
                response: HttpResponse::HTTP_UNAUTHORIZED,
                description: 'Unauthorized',
                content: new OAT\JsonContent(
                    properties: [
                        new OAT\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Invalid credentials.'
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(Request $request)
    {
        $sortType = $request->query('sortType');
        $employee = ($sortType === 'desc') 
            ? Employee::orderBy('last_name', 'desc')
            : Employee::orderBy('last_name', 'asc');

        return new ResourceCollection($employee->paginate(2));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    #[OAT\Post(
        tags: ['employees'],
        path: '/api/employees',
        summary: 'Create a employee',
        operationId: 'EmployeeController.store',
        security: [['BearerToken' => []]],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/StoreEmployeeRequest')
        ),
        responses: [
            new OAT\Response(
                response: HttpResponse::HTTP_OK,
                description: 'Ok',
                content: new OAT\JsonContent(ref: '#/components/schemas/EmployeeResource') 
            ),
            new OAT\Response(
                response: HttpResponse::HTTP_UNAUTHORIZED,
                description: 'Unauthorized',
                content: new OAT\JsonContent(
                    properties: [
                        new OAT\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Invalid credentials.'
                        ),
                    ]
                )
            ),
        ]
    )]
    public function store(StoreEmployeeRequest $request)
    {
        $validated = $request->safe()->only(['first_name', 'last_name']);
        $employee = Employee::create([
            'uuid' => (string) Str::uuid(),
            'first_name' => $validated['first_name'],
            'last_name' =>  $validated['last_name'],
        ]);

        return Response::json(new EmployeeResource($employee));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    #[OAT\Get(
        tags: ['employees'],
        path: '/api/employees/{employee_uuid}',
        summary: 'Show a specific employee',
        operationId: 'EmployeeController.show',
        security: [['BearerToken' => []]],
        parameters: [
            new OAT\Parameter(
                name: 'employee_uuid',
                in: 'path',
                required: true
            )
        ],
        responses: [
            new OAT\Response(
                response: HttpResponse::HTTP_OK,
                description: 'Ok',
                content: new OAT\JsonContent(ref: '#/components/schemas/EmployeeResource') 
            ),
            new OAT\Response(
                response: HttpResponse::HTTP_UNAUTHORIZED,
                description: 'Unauthorized',
                content: new OAT\JsonContent(
                    properties: [
                        new OAT\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Invalid credentials.'
                        ),
                    ]
                )
            ),
        ]
    )]
    public function show(Employee $employee)
    {
        return Response::json(new EmployeeResource($employee->load('skills')));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    #[OAT\Put(
        tags: ['employees'],
        path: '/api/employees/{employee_uuid}',
        summary: 'Update a employee',
        operationId: 'EmployeeController.update',
        security: [['BearerToken' => []]],
        parameters: [
            new OAT\Parameter(
                name: 'employee_uuid',
                in: 'path',
                required: true
            )
        ],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/UpdateEmployeeRequest')
        ),
        responses: [
            new OAT\Response(
                response: HttpResponse::HTTP_OK,
                description: 'Ok',
                content: new OAT\JsonContent(ref: '#/components/schemas/EmployeeResource') 
            ),
            new OAT\Response(
                response: HttpResponse::HTTP_UNAUTHORIZED,
                description: 'Unauthorized',
                content: new OAT\JsonContent(
                    properties: [
                        new OAT\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Invalid credentials.'
                        ),
                    ]
                )
            ),
        ]
    )]
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $validated = $request->safe()->only(['first_name', 'last_name']);
        $employee->first_name = $validated['first_name'];
        $employee->last_name = $validated['last_name'];
        $employee->save();

        return Response::json(new EmployeeResource($employee));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    #[OAT\Delete(
        tags: ['employees'],
        path: '/api/employees/{employee_uuid}',
        summary: 'Delete a employee',
        operationId: 'EmployeeController.destroy',
        security: [['BearerToken' => []]],
        parameters: [
            new OAT\Parameter(
                name: 'employee_uuid',
                in: 'path',
                required: true
            )
        ],
        responses: [
            new OAT\Response(
                response: HttpResponse::HTTP_NO_CONTENT,
                description: 'No content'
            ),
            new OAT\Response(
                response: HttpResponse::HTTP_UNAUTHORIZED,
                description: 'Unauthorized',
                content: new OAT\JsonContent(
                    properties: [
                        new OAT\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Invalid credentials.'
                        ),
                    ]
                )
            ),
        ]
    )]
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->noContent();
    }

    /**
     * Attach skills to an employee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    #[OAT\Post(
        tags: ['employees'],
        path: '/api/employees/{employee_uuid}/skills',
        summary: 'Attach skills to an employee',
        operationId: 'EmployeeController.attachSkills',
        security: [['BearerToken' => []]],
        parameters: [
            new OAT\Parameter(
                name: 'employee_uuid',
                in: 'path',
                required: true
            )
        ],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/AttachSkillRequest')
        ),
        responses: [
            new OAT\Response(
                response: HttpResponse::HTTP_OK,
                description: 'Ok',
                content: new OAT\JsonContent(ref: '#/components/schemas/EmployeeResource') 
            ),
            new OAT\Response(
                response: HttpResponse::HTTP_UNAUTHORIZED,
                description: 'Unauthorized',
                content: new OAT\JsonContent(
                    properties: [
                        new OAT\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Invalid credentials.'
                        ),
                    ]
                )
            ),
        ]
    )]
    public function attachSkills(AttachSkillRequest $request, Employee $employee)
    {
        $skillsRequest = $request->safe()->only(['skills']);
        $skills = Skill::leftJoin('employee_skills', 'employee_skills.skill_id', 'skills.id')
                    ->where(function (Builder $query) use ($employee) {
                        $query->whereNot('employee_skills.employee_id', $employee->id)
                            ->orWhereNull('employee_skills.employee_id');
                    })
                    ->whereIn('uuid', $skillsRequest['skills'])->get();
        
        $employee->skills()->attach($skills);
        return Response::json(new EmployeeResource($employee->load('skills')));
    }

    /**
     * Remove skills from an employee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    #[OAT\Delete(
        tags: ['employees'],
        path: '/api/employees/{employee_uuid}/skills',
        summary: 'Remove skills from an employee',
        operationId: 'EmployeeController.removeSkills',
        security: [['BearerToken' => []]],
        parameters: [
            new OAT\Parameter(
                name: 'employee_uuid',
                in: 'path',
                required: true
            )
        ],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/AttachSkillRequest')
        ),
        responses: [
            new OAT\Response(
                response: HttpResponse::HTTP_OK,
                description: 'Ok',
                content: new OAT\JsonContent(ref: '#/components/schemas/EmployeeResource') 
            ),
            new OAT\Response(
                response: HttpResponse::HTTP_UNAUTHORIZED,
                description: 'Unauthorized',
                content: new OAT\JsonContent(
                    properties: [
                        new OAT\Property(
                            property: 'message',
                            type: 'string',
                            example: 'Invalid credentials.'
                        ),
                    ]
                )
            ),
        ]
    )]
    public function removeSkills(DetachSkillRequest $request, Employee $employee)
    {
        $skillsRequest = $request->safe()->only(['skills']);
        $skills = Skill::innerJoin('employee_skills', 'employee_skills.skill_id', 'skills.id')
                    ->where('employee_skills.employee_id', $employee->id)
                    ->whereIn('uuid', $skillsRequest['skills'])->get();

        $employee->skills()->detach($skills);
        return Response::json(new EmployeeResource($employee->load('skills')));
    }
}
