<?php

namespace App\Http\Controllers\Api\V1\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function allCategories(){
        $categories=Category::where('parent_id',0)->get();
        return new \App\Http\Resources\V1\CategoryCollection($categories);
    }
    public function getArticles(Category $category){
        $articles=$category->articles()->paginate(4);
        return new \App\Http\Resources\V1\ArticleCollection($articles);
    }


}
