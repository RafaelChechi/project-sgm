<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 *
 * @OA\Schema(
 *     title="Project model",
 *     description="Project model",
 * )
 */
class Project extends Model {
    use HasFactory;

    /**
     * @OA\Property(
     *     description="ID",
     *     title="ID",
     *     example=1
     * )
     *
     * @var integer
     *
     */
    private $id;
    /**
     * @OA\Property(
     *     description="name",
     *     title="Name",
     *     example="Construção ginágio de esportes"
     * )
     *
     * @var string
     */
    private $name;

    /**
     * @OA\Property(
     *     description="description",
     *     title="Description",
     *     example="Construção ginágio de esportes"
     * )
     *
     * @var string
     */
    private $description;

    /**
     * @OA\Property(
     *     description="start_date",
     *     title="Start Date",
     *     example="2020-12-08T21:18:11.000000Z"
     * )
     *
     * @var date
     */
    private $start_date;

    /**
     * @OA\Property(
     *     description="end_date",
     *     title="End Date",
     *     example="2020-12-09T21:18:11.000000Z"
     * )
     *
     * @var date
     */
    private $end_date;

    protected $fillable = [
        'id',
        'name',
        'description',
        'start_date',
        'end_date'
    ];
}
