<?php

namespace App\Http\Controllers;

use App\Book;
use App\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{

    /**
     * show levels
     * @return mixed
     */
    public function show()
    {
        $level = Level::select('levelName')->get();

        return $level;
    }


    /**
     *
     * show  books based on levels
     *
     * @param Level $level
     * @param Request $req
     * @return mixed
     */
    public function showBook(Level $level, Request $req)
    {
        // dd($req->lev);
        $books = Book::where('level_levelName', $req->lev)->get();
        return $books;
    }

}
