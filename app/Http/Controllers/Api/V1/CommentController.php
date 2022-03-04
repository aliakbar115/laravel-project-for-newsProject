<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function allApproved()
    {
        $comments = Comment::where(['approved' => 1, 'parent_id' => 0,])->latest()->paginate(10);
        return new \App\Http\Resources\V1\CommentCollection($comments);
    }
    public function allUnApproved()
    {
        $comments = Comment::where('approved', 0)->latest()->paginate(10);
        return new \App\Http\Resources\V1\CommentCollection($comments);
    }
    public function delete(Request $request, Comment $comment)
    {
        $approved = $comment->approved;
        if ($comment->child->count() > 0) {
            $comment->child()->delete(); // حذف پاسخ های این نظر
        }
        $comment->delete();
        if ($approved) {
            $comments = Comment::where(['approved' => 1, 'parent_id' => 0,])->latest()->paginate(10);
            return new \App\Http\Resources\V1\CommentCollection($comments);
        } else {
            $comments = Comment::where('approved', 0)->latest()->paginate(10);
            return new \App\Http\Resources\V1\CommentCollection($comments);
        }
    }
    public function delete_response(Request $request,Comment $comment){
        $parent_id=$request->parent_id;
        $comment->delete();
        $parent_comment=Comment::find($parent_id);
        $responses=$parent_comment->child;
        return new \App\Http\Resources\V1\CommentCollection($responses);
    }
    /**
     * search in all comments
     * @return array
     */
    public function search()
    {
        $comments = Comment::query();
        if ($keyword = request('search')) {
            $comments->where(function ($query) use ($keyword) {  // پایین اعمال نمی شود where اگر انجام نشود
                $query->where('comment', 'like', "%$keyword%")
                    ->orWhere('id', $keyword);
            });
        }
        $comments_search = $comments->where(['approved' => 1, 'parent_id' => 0,])->latest()->paginate(10);
        return new \App\Http\Resources\V1\CommentCollection($comments_search);
    }
    public function setApproved(Comment $comment)
    {
        $comment->update(['approved' => 1]);
        $comments = Comment::where('approved', 0)->latest()->paginate(10);
        return new \App\Http\Resources\V1\CommentCollection($comments);
    }
    public function getResponse(Comment $comment){
        $responses=$comment->child;
        return new \App\Http\Resources\V1\CommentCollection($responses);
    }
    /**
     * پاسخ به یک کامنت در پنل ادمین
     * @param Request $request
     * @return array
     */
    public function response(Request $request)
    {
        $parent_id=$request->parent_id;
        $commentText=$request->comment;
        $comment=Comment::find($parent_id);
        $user=User::find(1);  // to Do   *****  فعلا به این صورت تا لاگین کامل شود
        $user->comments()->create([   // auth()->user()
            'parent_id'=>$parent_id,
            'comment'=>$commentText,
            'commentable_type'=>'App\Models\Article',
            'commentable_id'=>$comment->commentable_id,
            'approved'=>1
        ]);
        $responses=$comment->child;
        return new \App\Http\Resources\V1\CommentCollection($responses);
    }
}
