<?php

namespace App\Http\Controllers\Admin\Tags;

use App\Http\Controllers\Controller;
use App\Http\Requests\Topic\EditTopicRequest;
use App\Models\Image;
use App\Models\Tag;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TagsController extends Controller{

    public function index(){
        $list = Tag::paginate(20);
        return view('admin.crud.index', ['list' => $list]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function add(Request  $request){
        if ($request->isMethod('post')) {
            $input = $request->collect()->all();
            $tag = Tag::create($input);
            if($tag->save()){
                return redirect('/admin/tags');
            }
        }
        return view('admin.crud.add');
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
        return view('admin.topics.edit', ['id' => $id, 'topic' => $topic]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function update($id, Request  $request){
        if(! $id){
            throw new NotFoundHttpException('Not found topic id');
        }
        $tag = Tag::find($id);
        if(! $tag){
            throw new NotFoundHttpException('Not found tag '.$id);
        }
        $input = $request->collect()->all();
        $topic = $tag->fill($input);
        if($topic->save()){
            return redirect('/admin/tags/'.$id);
        }
        return view('admin.crud.edit', ['id' => $id, 'topic' => $topic]);

    }

    public function view($id){
        if(! $id){
            throw new NotFoundHttpException('Not found topic id');
        }
        $topic = Tag::find($id);
        if(! $topic){
            throw new NotFoundHttpException('Not found topic '.$id);
        }

        return view('admin.topics.view', ['topic' => $topic]);
    }
}
