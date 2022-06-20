<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    protected $table = 'tags';
    public $timestamps = false;
    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'alias' => '',
        'color' => '',
    ];

    /**
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'alias',
        'color',
    ];
}
