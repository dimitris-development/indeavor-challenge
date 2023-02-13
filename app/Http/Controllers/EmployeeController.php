<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\EmployeeResource;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    #[OAT\Get(
        tags: ['employees'],
        path: '/api/employees',
        summary: 'Show employees',
        operationId: 'EmployeeController.index',
        security: [['BearerToken' => []]],
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
    public function index()
    {
        return Response::json(EmployeeResource::collection(Employee::all()));
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
        return Response::json(new EmployeeResource($employee));
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
}
