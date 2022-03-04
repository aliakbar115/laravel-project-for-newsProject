<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ArticleCollection;

class ArticleController extends Controller
{
    public function visited()
    {
        $articles = Article::orderBy('view_count', 'desc')->skip(2)->take(6)->get();
        return new \App\Http\Resources\V1\ArticleCollection($articles);
    }
    public function recentNews()
    {
        $article = Article::orderBy('id', 'desc')->first();
        return new \App\Http\Resources\V1\Article($article);
    }
    /**
     * 2 articles order by number of view
     * @return array
     */
    public function viewNews()
    {
        $articles = Article::orderBy('view_count', 'desc')->take(2)->get();
        return new \App\Http\Resources\V1\ArticleCollection($articles);
    }
    /**
     * 6 articles order by number of comments
     * @return array
     */
    public function commentArticles()
    {
        $articles = Article::withCount('comments')->orderBy('comments_count', 'desc')->take(6)->get();
        return new \App\Http\Resources\V1\ArticleCollection($articles);
    }
    public function getArticle(Article $article)
    {
        return new \App\Http\Resources\V1\Article($article);
    }
    public function send_comment(Request $request, Article $article)
    {
        $user=User::find(1);
        $user->comments()->create([  // auth()->user()    ******  بعد از لاگین اصلاح شود   -- approved  اصلاح شود
            'commentable_id' => $article->id,
            'commentable_type' => 'App\Models\Article',
            'parent_id' => 0,
            'approved' => 0,
            'comment' => $request->comment
        ]);

        return ['status'=>'success'];
    }
}
