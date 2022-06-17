<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topics';

    public $incrementing = true;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    /**
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'author_id',
        'picture_id',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function picture()
    {
        return $this->belongsTo(Image::class, 'picture_id');
    }
}
