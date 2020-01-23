<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * show categories
     * @return mixed
     */
    public function show(){
        $categories = Category::select('categoryName')->get();

        return $categories;
    }


    /**
     *
     * show book based on specific categories
     *
     * @param Category $category
     * @param Request $req
     * @return mixed
     */
    public function showBook(Category $category,Request $req){
        $books = Book::where('category_categoryName',$req->cat)->get();
        return $books;
    }
}
