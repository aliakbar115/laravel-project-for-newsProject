<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ArticleController extends AdminController
{
    /**
     * show all articles
     * @return void
     */
    public function index()
    {
        $articles = Article::paginate(10);
        return new \App\Http\Resources\V1\ArticleCollection($articles);
    }
    public function create(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string'],
            'body' => ['required', 'string'],
            'status' => 'required|integer',
            'category_id' => 'required|integer',
            'image' => 'required|image|max:2048',
        ]);
        if ($validated['status']) {
            $data = array_merge($validated, ['status' => 'enable']);
        } else {
            $data = array_merge($validated, ['status' => 'disable']);
        }
        $imageUrl = $this->uploadImages($request->file('image'));
        $data = array_merge($data, ['image' => $imageUrl]);
        $data = array_merge($data, ['user_id' => 1]);  // فعلا به این صورت است تا لاگین انجام شود To do ********
        Article::create($data);
        return [
            'status' => 'success'
        ];
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['required', 'string'],
            'body' => ['required', 'string'],
            'status' => 'required|integer',
            'category_id' => 'required|integer',
        ]);
        if ($validated['status']) {
            $data = array_merge($validated, ['status' => 'enable']);
        } else {
            $data = array_merge($validated, ['status' => 'disable']);
        }
        $article = Article::find($request->id);

        if ($request->file('image')) {
            $request->validate([
                'image' => 'required|image|max:2048',
            ]);
            $imageUrl = $this->uploadImages($request->file('image'));
            $data = array_merge($data, ['image' => $imageUrl]);
            if (File::exists(public_path($article->image['images']['original']))) { //  حذف فایل
                File::delete(public_path($article->image['images']['original']));
                File::delete(public_path($article->image['images']['300']));
                File::delete(public_path($article->image['images']['600']));
                File::delete(public_path($article->image['images']['900']));
            }
        }
        $data = array_merge($data, ['user_id' => 1]);  // فعلا به این صورت است تا لاگین انجام شود To do ********
        $article->update($data);
        return [
            'status' => 'success'
        ];
    }
    public function edit(Article $article)
    {
        return new \App\Http\Resources\V1\Article($article);
    }
    public function delete(Request $request, Article $article)
    {
        $article->delete();
        $articles = Article::paginate(10);
        return [
            'status' => 'success',
            'articles' => new \App\Http\Resources\V1\ArticleCollection($articles)
        ];
    }
    /**
     * search in name in all categories
     * @param Request $request
     * @return array
     */
    public function search(Request $request)
    {
        $articles = Article::query();
        if ($keyword = request('search')) {
            $articles->where('title', 'LIKE', "%$keyword%");
            $articles->orWhere('summary', 'LIKE', "%$keyword%");
            $articles->orWhere('body', 'LIKE', "%$keyword%");
        }
        $articles_search = $articles->latest()->paginate(10);
        return new \App\Http\Resources\V1\ArticleCollection($articles_search);
    }
}
