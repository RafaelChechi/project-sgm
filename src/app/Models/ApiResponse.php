<?php


namespace App\Models;


/**
 * Class ApiResponse
 *
 * @package Petstore30
 *
 * @author  Donii Sergii <doniysa@gmail.com>
 *
 * @OA\Schema(
 *     description="Api response",
 *     title="Api response"
 * )
 */
class ApiResponse {
    /**
     * @OA\Property(
     *     description="Code",
     *     title="Code",
     *     format="int32",
     *     example=456
     * )
     *
     * @var int
     */
    private $code;

    /**
     * @OA\Property(
     *     description="Message",
     *     title="Message",
     *     example="Error"
     * )
     *
     * @var string
     */
    private $message;
}
