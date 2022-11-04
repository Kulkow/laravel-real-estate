<?php
namespace App\Http\Controllers\Api\Topics;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopicResource;
use App\Models\Topic;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Resources\TopicCollection;

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
        return new TopicResource($topic);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function edit($id = null){
        if(! $id){
            throw new NotFoundHttpException('Not found topic id');
        }
        $topic = Topic::with(['author', 'picture'])->find($id);
        if(! $topic){
            throw new NotFoundHttpException('Not found topic '.$id);
        }
        $response = Gate::inspect('edit', $topic);
        if (! $response->allowed()) {
            abort(403, $response->message());
        }
        return new TopicResource($topic);
    }
}
