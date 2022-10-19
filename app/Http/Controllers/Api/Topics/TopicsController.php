<?php
namespace App\Http\Controllers\Api\Topics;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class TopicsController extends Controller
{

    public function index()
    {
        return Topic::paginate(2);
    }

    public function view($id){
        if(! $id){
            throw new NotFoundHttpException('Not found topic id');
        }
        $topic = Topic::with(['author', 'picture'])->find($id);
        if(! $topic){
            throw new NotFoundHttpException('Not found topic '.$id);
        }

        return $topic;
    }
}
