<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Traits\Http\APIResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller {

    use APIResponse;

    /**
     * @OA\Get(
     *     path="/api/projects",
     *     operationId="getProject",
     *     tags={"Project"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *      @OA\Response(response=400, description="Bad request", @OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     *      @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     *      @OA\Response(response=500, description="Internal Error Server", @OA\JsonContent(ref="#/components/schemas/ApiResponse"))
     * )
     */
    public function index() {
        $projects = Project::all();
        return $this->json($projects);
    }

    /**
     * @OA\Post(
     *     path="/api/projects",
     *     operationId="createProject",
     *     tags={"Project"},
     *     @OA\RequestBody(
     *         description="Created new user",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *      @OA\Response(response=400, description="Bad request", @OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     *      @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     *      @OA\Response(response=500, description="Internal Error Server", @OA\JsonContent(ref="#/components/schemas/ApiResponse"))
     * )
     */
    public function create(Request $request) {
        $request->validate([
            'name' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $project = new Project();
        $project->name = $request->name;
        $project->description = $request->description;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->save();

        return $this->created($project);
    }

    /**
     * @OA\Delete(
     *     path="/api/projects/{id}",
     *     operationId="destroyProject",
     *     tags={"Project"},
     *     @OA\Parameter(
     *          name="id",
     *          description="Project id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *          response=204,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request", @OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     *      @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     *      @OA\Response(response=500, description="Internal Error Server", @OA\JsonContent(ref="#/components/schemas/ApiResponse"))
     * )
     */
    public function destroy($id) {
        $project = Project::find($id);

        if (!empty($project)) {
            $project->delete();
            return $this->deleted();
        } else {
            $message = trans('messages.project_not_found');
            return $this->badRequest($message);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/projects/{id}",
     *     operationId="updateProject",
     *     tags={"Project"},
     *     @OA\Parameter(
     *          name="id",
     *          description="Project id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *         description="Updated user",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Project")
     *     ),
     *      @OA\Response(response=400, description="Bad request", @OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     *      @OA\Response(response=404, description="Resource Not Found", @OA\JsonContent(ref="#/components/schemas/ApiResponse")),
     *      @OA\Response(response=500, description="Internal Error Server", @OA\JsonContent(ref="#/components/schemas/ApiResponse"))
     * )
     */
    public function update($id, Request $request) {

        $request->validate([
            'start_date' => 'sometimes|required',
            'end_date' => 'sometimes|required'
        ]);

        $project = Project::find($id);
        $input = $request->only([
            'description',
            'start_date',
            'end_date'
        ]);

        if (!empty($project)) {
            $project->fill($input);
            $project->save();
        } else {
            $message = trans('messages.project_not_found');
            return $this->badRequest($message);
        }

        $this->json($project);
    }
}
