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

class TagsController extends Controller
{

    public function index()
    {
        $list = Tag::paginate(20);
        return view('admin.crud.index', ['list' => $list, 'crud_model' => 'tags']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->collect()->all();
            $tag = Tag::create($input);
            if ($tag->save()) {
                return redirect('/admin/tags');
            }
        }
        return view('admin.crud.add', ['crud_model' => 'tags']);
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function edit($id = null)
    {
        if (!$id) {
            throw new NotFoundHttpException('Not found tag id');
        }
        $tag = Tag::find($id);
        if (!$tag) {
            throw new NotFoundHttpException('Not found tag ' . $id);
        }

        return view('admin.crud.edit', ['id' => $id, 'entity' => $tag, 'crud_model' => 'tags']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function update($id, Request $request)
    {
        if (!$id) {
            throw new NotFoundHttpException('Not found topic id');
        }
        $tag = Tag::find($id);
        if (!$tag) {
            throw new NotFoundHttpException('Not found tag ' . $id);
        }
        $input = $request->collect()->all();
        $tag = $tag->fill($input);
        if ($tag->save()) {
            return redirect('/admin/tags/' . $id);
        }
        return view('admin.crud.edit', ['id' => $id, 'entity' => $tag, 'crud_model' => 'tags']);

    }

    public function view($id)
    {
        if (!$id) {
            throw new NotFoundHttpException('Not found topic id');
        }
        $tag = Tag::find($id);
        if (!$tag) {
            throw new NotFoundHttpException('Not found tag ' . $id);
        }

        return view('admin.crud.view', ['id' => $id, 'entity' => $tag, 'crud_model' => 'tags']);
    }
}
