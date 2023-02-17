<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Skill;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\SkillResource;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    #[OAT\Get(
        tags: ['skills'],
        path: '/api/skills',
        summary: 'Show skills',
        operationId: 'SkillController.index',
        security: [['BearerToken' => []]],
        responses: [
            new OAT\Response(
                response: HttpResponse::HTTP_OK,
                description: 'Ok',
                content: new OAT\JsonContent(
                    type: 'array',
                    items: new OAT\Items(ref: '#/components/schemas/SkillResource')
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
        // TODO : Refactor
        if ($request->exists('dontPaginate')) {
            return Response::json(SkillResource::collection(Skill::all())); 
        }
        return new ResourceCollection(Skill::paginate(2));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    #[OAT\Post(
        tags: ['skills'],
        path: '/api/skills',
        summary: 'Create a skill',
        operationId: 'SkillController.store',
        security: [['BearerToken' => []]],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/StoreSkillRequest')
        ),
        responses: [
            new OAT\Response(
                response: HttpResponse::HTTP_OK,
                description: 'Ok',
                content: new OAT\JsonContent(ref: '#/components/schemas/SkillResource') 
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
    public function store(StoreSkillRequest $request)
    {
        $validated = $request->safe()->only(['name', 'description']);
        $skill = Skill::create([
            'uuid' => (string) Str::uuid(),
            'name' => $validated['name'],
            'description' =>  $validated['description'],
        ]);

        return Response::json(new SkillResource($skill));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    #[OAT\Get(
        tags: ['skills'],
        path: '/api/skills/{skill_uuid}',
        summary: 'Show a specific skill',
        operationId: 'SkillController.show',
        security: [['BearerToken' => []]],
        parameters: [
            new OAT\Parameter(
                name: 'skill_uuid',
                in: 'path',
                required: true
            )
        ],
        responses: [
            new OAT\Response(
                response: HttpResponse::HTTP_OK,
                description: 'Ok',
                content: new OAT\JsonContent(ref: '#/components/schemas/SkillResource') 
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
    public function show(Skill $skill)
    {
        return Response::json(new SkillResource($skill));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    #[OAT\Put(
        tags: ['skills'],
        path: '/api/skills/{skill_uuid}',
        summary: 'Update a skill',
        operationId: 'SkillController.update',
        security: [['BearerToken' => []]],
        parameters: [
            new OAT\Parameter(
                name: 'skill_uuid',
                in: 'path',
                required: true
            )
        ],
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\JsonContent(ref: '#/components/schemas/UpdateSkillRequest')
        ),
        responses: [
            new OAT\Response(
                response: HttpResponse::HTTP_OK,
                description: 'Ok',
                content: new OAT\JsonContent(ref: '#/components/schemas/SkillResource') 
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
    public function update(UpdateSkillRequest $request, Skill $skill)
    {
        $validated = $request->safe()->only(['name', 'description']);
        $skill->name = $validated['name'];
        $skill->description = $validated['description'];
        $skill->save();

        return Response::json(new SkillResource($skill));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    #[OAT\Delete(
        tags: ['skills'],
        path: '/api/skills/{skill_uuid}',
        summary: 'Delete a skill',
        operationId: 'SkillController.destroy',
        security: [['BearerToken' => []]],
        parameters: [
            new OAT\Parameter(
                name: 'skill_uuid',
                in: 'path',
                required: true
            )
        ],
        responses: [
            new OAT\Response(
                response: HttpResponse::HTTP_NO_CONTENT,
                description: 'Ok',
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
    public function destroy(Skill $skill)
    {
        $skill->delete();
        return response()->noContent();
    }
}
