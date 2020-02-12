<?php

namespace App\Http\Controllers;

use App\Book;
use App\Book_file;
use App\Cover;
use App\Dislike;
use App\Download;
use App\Like;
use App\Read;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{


    /**
     * search book
     *
     * @param Request $request
     * @param Book $_book
     * @param Book_file $file
     * @param Cover $_cover
     * @param Download $_downloads
     * @param Like $_likes
     * @param Dislike $_dislikes
     * @param Read $_views
     * @return string
     */
    public function sortsBook(Request $request, Book $_book, Book_file $file, Cover $_cover, Download $_downloads, Like $_likes, Dislike $_dislikes, Read $_views){
        $table = $request->table;
        $string = $request->string;
        $book = $_book;
        $books = DB::select("SELECT  b.ISBN,b.name,b.publisher,b.provider_providerName,b.category_categoryName,b.level_levelName,b.description,b.created_at, COUNT(b.ISBN) AS occurences FROM books b INNER JOIN {$table} d WHERE b.ISBN = d.book_ISBN AND( name LIKE '%{$string}%' OR name LIKE '%{$string}' OR name LIKE '{$string}%') GROUP BY b.ISBN ORDER BY occurences DESC");
        $searchedBook = array();
        $searchedBook['data'] = array();


        foreach($books as $thisBook){
            // dd(date('d/m/Y h:i:s', strtotime('03/11/2019 01:41:21')));

            $isbn =  $thisBook->ISBN ;
            $file  = $file->where('book_ISBN', '=', $isbn)->get();
            $cover  = $_cover->where('book_ISBN', '=', $isbn)->get();
            $downloads  = $_downloads->where('book_ISBN', '=', $isbn)->count();
            $likes  = $_likes->where('book_ISBN', '=', $isbn)->count();
            $dislikes  = $_dislikes->where('book_ISBN', '=', $isbn)->count();
            $views  = $_views->where('book_ISBN', '=', $isbn)->count();
            $book = $_book->where('ISBN', '=', $isbn)->get();
            $date1 = date_create(date('d/m/Y h:i:s'));
            $bookDate= date('d/m/Y h:i:s', strtotime('03/11/2019 01:41:21'));
            $date2 = date_create($bookDate);
            // dd(empty($file[0]));
            $myDate = date_diff($date2, $date1);
            $dateDiff = [
                'years' => $myDate->y,
                'months' => $myDate->m,
                'days' => $myDate->d,
                'hours' => $myDate->h,
                'mins' => $myDate->i,
                'seconds' => $myDate->s,
                'totalDays' => $myDate->days,
            ];

            if(!empty($file[0]) ){
                $book = $thisBook;
                $data = [
                    'ISBN' => $book->ISBN,
                    'bookName' => $book->name,
                    'bookPublisher' => $book->publisher,
                    'bookProvider' => $book->provider_providerName,
                    'bookLevel' => $book->level_levelName,
                    'bookCategory' => $book->category_categoryName,
                    'bookDesc' => $book->description,
                    'bookTime' => $dateDiff,
                    'bookCreated_at' => date('D d/M/Y', strtotime($book->created_at)),
                    'bookFile' => $file[0]->file,
                    'bookCover' => $cover,
                    'bookDownloads' => $downloads,
                    'bookLikes' => $likes,
                    'bookDislikes' => $dislikes,
                    'bookViews' => $views,
                ];

                // $searchedBook['data'] =  $data;
                // dd($searchedBook);
                array_push($searchedBook['data'], $data);

                // at the time we will b having all files and covers we gonna rmove break
                break;
            } else {
                return "No book";
            }


        }
//        dd($searchedBook);
         return response($books);

    }

    public function searchBook(Request $req,Book $book){
//        dd($req->all());
        $searched = $book->newQuery();
        $searchString= $req->s_q;
        $searched->where('name','like','%' . $searchString . '%');
//        dd($searched->get());
    return response()->json($searched->get());
    }

    public function queryBook(Request $req, Book $book)
    {
        $s_q = $req->s_q;
        $searchedBook =$book->newQuery();
        $searchedBook->where('name','like','%'. $s_q.'%');
        if($req->has('level')){
            $searchedBook->where('level_levelName',$req->level);
        }
        if($req->has('provider'))
            $searchedBook->where('provider_providerName');
        if($req->has('categ'))
            $searchedBook->where('category_categoryName');
        if($req->has('order')){



            if($req->order == "desc"){

                if($req->has('downloads'))
                    $searchedBook->join('downloads','books.ISBN','=','downloads.book_bookISBN')->groupBy('downloads.book.bookISBN AS counts')->orderByDesc('counts');

                if($req->has('likes'))
                    $searchedBook->join('likes','books.ISBN','=','likes.book_bookISBN')->groupBy('likes.book.bookISBN AS counts')->orderByDesc('counts');

                if($req->has('reads'))
                    $searchedBook->join('reads','books.ISBN','=','reads.book_bookISBN')->groupBy('reads.book.bookISBN AS counts')->orderByDesc('counts');

            } elseif ($req->order == "asc"){
                if($req->has('downloads'))
                    $searchedBook->join('downloads','books.ISBN','=','downloads.book_bookISBN')->groupBy('downloads.book.bookISBN AS counts')->orderBy('counts');

                if($req->has('likes'))
                    $searchedBook->join('likes','books.ISBN','=','likes.book_bookISBN')->groupBy('likes.book.bookISBN AS counts')->orderBy('counts');

                if($req->has('reads'))
                    $searchedBook->join('reads','books.ISBN','=','reads.book_bookISBN')->groupBy('reads.book.bookISBN AS counts')->orderBy('counts');

            }
        }

        return response()->json($searchedBook->get());
    }
}
