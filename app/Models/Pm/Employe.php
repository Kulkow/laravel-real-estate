<?php
namespace App\Models\Pm;

use Illuminate\Database\Eloquent\Model;
use App\Models\Image;

class Employe extends Model
{
    protected $table = 'employes';

    public $incrementing = true;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    /**
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'middle_name',
        'description',
        'gender',
        'birthday',
        'experience'
    ];



    public function photo()
    {
        return $this->belongsTo(Image::class, 'picture_id');
    }
}
