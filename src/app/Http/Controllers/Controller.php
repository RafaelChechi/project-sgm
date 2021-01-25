<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Project",
 *      description="API Project"
 * )
 *
 *  @OA\Server(
 *      url="https://project-sgm.3head.com.br"
 *  )
 *
 * @OA\Tag(
 *     name="Project",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
 */
class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
