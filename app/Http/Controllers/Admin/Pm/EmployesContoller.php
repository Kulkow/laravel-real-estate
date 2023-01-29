<?php

namespace App\Http\Controllers\Admin\Pm;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Pm\Employe;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployesContoller extends Controller
{

    public function index()
    {
        $list = Employe::paginate(20);
        return view('admin.pm.employes.index', ['list' => $list, 'crud_model' => 'employe']);
    }


    public function add(Request $request)
    {
        if ($request->isMethod('post')) {
            $input = $request->collect()->all();
            $employe = Employe::create($input);
            if ($employe->save()) {
                return redirect('/admin/pm/employes');
            }
        }
        return view('admin.pm.employes.add', ['crud_model' => 'employe']);
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
