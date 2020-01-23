<?php

namespace App\Http\Controllers;

use App\Book_file;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookFileController extends Controller
{

    /**
     *
     * This method is for receiveing vile from book
     * @param Request $request
     * @param Book_file $file
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */

    public function getBook(Request $request,Book_file $file){
        $status = array();

        //getting and hasshing filename of computer
        $tempFile = $request->file("bookFile")->hashName();

        //storing book file
        $destination = public_path('/books');
        $book = $request->file('bookFile');
        $path = $book->move($destination,$tempFile);
        $fullPath = "books/" . $tempFile;

        // saving data to database
        $data = request()->all();
        $file->book_ISBN = $data['bookISBN'];
        $file->file = $fullPath;
        $file->pages = $data['bookPages'];
        $file->created_at = Carbon::now();
        $file->updated_at = Carbon::now();
        $status['file'] =  $file->save() ? true : false;

        return response($status);
    }

}
