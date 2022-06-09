<?php
namespace App\Http\Controllers\Admin\Topics;
use App\Http\Controllers\Controller;
use App\Models\Topic;
use \Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


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
                  redirect('/admin/topics');
            }
        }
        return view('admin.topics.add');
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id, Request  $request){
        if(! $id){
            throw new NotFoundHttpException('Not found topic id');
        }
        $topic = Topic::find($id);
        if(! $topic){
            throw new NotFoundHttpException('Not found topic '.$id);
        }
        if ($request->isMethod('post')) {
            $input = $request->collect()->all();
            $topic = Topic::create($input);
            $topic->author_id = Auth::id();
            if($topic->save()){
                redirect('/admin/topics');
            }
        }
        return view('admin.topics.edit', ['id' => $id, 'topic' => $topic]);
    }

    public function view($id){
        if(! $id){
            throw new NotFoundHttpException('Not found topic id');
        }
        $topic = Topic::find($id);
        if(! $topic){
            throw new NotFoundHttpException('Not found topic '.$id);
        }
        return view('admin.topics.view', ['topic' => $topic]);
    }
}
