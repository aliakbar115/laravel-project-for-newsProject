<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
      /**
     * show all categories
     * @return void
     */
    public function index()
    {
        $categories = Category::paginate(10);
        return new \App\Http\Resources\V1\CategoryCollection($categories);
    }
    public function allParent()
    {
        $categories = Category::where('parent_id', 0)->get();
        return [
            'status'=>'success',
            'categories'=>$categories
        ];
    }
    public function create(Request $request){
        $validated = $request->validate([
            'name'=>'required',
            'parent_id'=>'required|integer',
            'lname'=>'required|alpha_dash|max:255|unique:categories'
        ]);
        Category::create($validated);
        return [
            'status'=>'success'
        ];
    }
     /**
     * edit Category
     * @param Request $request
     * @param Category $category
     * @return array
     */
    public function edit(Request $request,Category $category){
        return new \App\Http\Resources\V1\Category($category);
    }
       /**
     * update category
     * @param Request $request
     * @return string
     */
    public function update(Request $request){
        $category=Category::find($request->id);
        $validated = $request->validate([
            'name'=>'required',
            'parent_id'=>'required|integer',
            'lname'=>'required|alpha_dash|max:255|unique:categories'
        ]);
        $category->update($validated);
        return [
            'status'=>'success'
        ];
    }
    public function delete(Request $request,Category $category){
        $category->delete();
        $categories = Category::paginate(10);
        return [
            'status'=>'success',
            'categories'=>new \App\Http\Resources\V1\CategoryCollection($categories)
        ];
    }
     /**
     * search in name in all categories
     * @param Request $request
     * @return array
     */
    public function search(Request $request){
        $categories = Category::query();
        if ($keyword = request('search')) {
            $categories->where('name', 'LIKE', "%$keyword%");
        }
        $categories_search = $categories->latest()->paginate(10);
        return new \App\Http\Resources\V1\CategoryCollection($categories_search);
    }
}
