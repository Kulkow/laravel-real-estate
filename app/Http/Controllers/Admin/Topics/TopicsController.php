<?php
namespace App\Http\Controllers\Admin\Topics;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Topic;
use \Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Requests\Topic\EditTopicRequest;
use App\Http\Requests\Topic\CreateTopicRequest;

class TopicsController extends Controller{

    public function index(){
        $topics = Topic::paginate(20);
        return view('admin.topics.index', ['topics' => $topics]);
    }


    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function add(Request  $request){
        if ($request->isMethod('post')) {
            $input = $request->collect()->all();
            $topic = Topic::create($input);
            $topic->author_id = Auth::id();
            if($topic->save()){
                return redirect('/admin/topics');
            }
        }
        return view('admin.topics.add');
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function edit($id = null){
        if(! $id){
            throw new NotFoundHttpException('Not found topic id');
        }
        $topic = Topic::find($id);
        if(! $topic){
            throw new NotFoundHttpException('Not found topic '.$id);
        }
        $response = Gate::inspect('edit', $topic);
        if (! $response->allowed()) {
            abort(403, $response->message());
        }
        return view('admin.topics.edit', ['id' => $id, 'topic' => $topic]);
    }

    /**
     * @param  \App\Http\Requests\Topic\EditTopicRequest  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function update($id, EditTopicRequest  $request){
        if(! $id){
            throw new NotFoundHttpException('Not found topic id');
        }
        $topic = Topic::find($id);
        if(! $topic){
            throw new NotFoundHttpException('Not found topic '.$id);
        }
        $response = Gate::inspect('update', $topic);
        if (! $response->allowed()) {
            abort(403, $response->message());
        }
        $input = $request->collect()->all();
        $topic = $topic->fill($input);
        $topic->author_id = Auth::id();
        if($picture = $request->file('picture')){
            $image = new Image();
            $topic->picture_id = $image->saveStorage($picture,$topic, $topic->picture_id);
        }
        if($topic->save()){
            return redirect('/admin/topic/'.$id);
        }
        return view('admin.topics.edit', ['id' => $id, 'topic' => $topic]);

    }

    public function view($id){
        if(! $id){
            throw new NotFoundHttpException('Not found topic id');
        }
        $topic = Topic::with(['author', 'picture'])->find($id);
        if(! $topic){
            throw new NotFoundHttpException('Not found topic '.$id);
        }

        return view('admin.topics.view', ['topic' => $topic]);
    }
}
