<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $table = 'images';
    protected $prefixStorage = 'images';

    public $incrementing = true;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'updated';

    /**
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'path',
        'filename',
        'ext',
        'mime_type',
        'model',
        'filesize',
        'adapter'
    ];

    /**
     * @param $id
     * @return bool
     */
    public function deleteFile($id = null) : bool
    {
        $image = static::find($id);
        if($image instanceof Image){
            if($image->path){
                $path = $image->path();
                if(Storage::delete($path)){
                    return $image->delete();
                }
            }
        }
        return false;
    }

    /**
     * @param UploadedFile $file
     * @param Model $model
     * @param $oldId
     * @param $storage
     * @return mixed
     * @throws \Exception
     */
    public function saveStorage(UploadedFile $file, Model $model, $oldId = null, $storage = 'local')
    {
        $table = $model->getTable();
        $path = 'public'.DIRECTORY_SEPARATOR.$this->prefixStorage.DIRECTORY_SEPARATOR.$table;
        $pKey = $model->primaryKey;
        if($model->exists){
            $path .= DIRECTORY_SEPARATOR.$model->$pKey;
        }
        $pathFile = $file->store($path);
        if($pathFile){
            $save = [
                'name' => $file->getClientOriginalName(),
                'ext' => $file->extension(),
                'path' => pathinfo($pathFile, PATHINFO_DIRNAME),
                'filename' => pathinfo($pathFile, PATHINFO_FILENAME),
                'mime_type' => $file->getMimeType(),
                'model' => get_class($model),
                'adapter' => $storage,
                'filesize' => $file->getSize(),
            ];
            if($this->fill($save)->save()){
                $oldId = intval($oldId);
                if($oldId){
                    $this->deleteFile($oldId);
                }
                return $this->id;
            }else{
                throw new \Exception('Not Save image '.$pathFile);
            }
        }
        throw new \Exception('Not load image '.$path);
    }

    public function path(){
        return $this->path.DIRECTORY_SEPARATOR.$this->filename.'.'.$this->ext;
    }

    public function link(){
        return Storage::url($this->path());
    }

    public function title(){
        return str_replace('"', '', $this->name ? $this->name : $this->filename);
    }
}
