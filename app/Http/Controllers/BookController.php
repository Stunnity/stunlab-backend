<?php

namespace App\Http\Controllers;

use App\Book;
use App\Book_file;
use App\Cover;
use App\Dislike;
use App\Download;
use App\Like;
use App\Read;
use App\View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BookController extends Controller
{


    private $myISBN;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();


        foreach ($books as $book){
            $book->file = Book_file::find($book->ISBN)->file;
            $book->cover = Cover::find($book->ISBN)->file;
        }


        return $books;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     *
     * show one book
     *
     * @param Request $request
     * @param Book $_book
     * @param Book_file $file
     * @param Cover $_cover
     * @param Download $_downloads
     * @param Like $_likes
     * @param Dislike $_dislikes
     * @param Read $_views
     * @return array
     */


    public function books(Request $request, Book $_book,Book_file $file,Cover $_cover,Download $_downloads, Like $_likes, Dislike $_dislikes, Read $_views){


        $isbn = strval($request->ISBN);
        $file  = $file->where('book_ISBN','=',$isbn)->get();
        $cover  = $_cover->where('book_ISBN','=',$isbn)->get();
        $downloads  = $_downloads->where('book_ISBN','=',$isbn)->count();
        $likes  = $_likes->where('book_ISBN', '=', $isbn)->count();
        $dislikes  = $_dislikes->where('book_ISBN', '=', $isbn)->count();
        $views  = $_views->where('book_ISBN','=',$isbn)->count();
        $book = $_book->where('ISBN', '=', $isbn)->get();
        $date1 = date_create(date('d/m/Y h:i:s'));
        $date2 = date_create(date('d/m/Y h:i:s', strtotime($book[0]->created_at)));
        $myDate = date_diff($date2, $date1);
        $dateDiff = [
            'years'=>$myDate->y,
            'months'=>$myDate->m,
            'days' => $myDate->d,
            'hours' => $myDate->h,
            'mins' => $myDate->i,
            'seconds'=>$myDate->s,
            'totalDays'=>$myDate->days,
        ];


        $book = $book[0];
        $data = [
            'ISBN'=>$book->ISBN,
            'bookName'=>$book->name,
            'bookPublisher'=>$book->publisher,
            'bookProvider'=>$book->provider_providerName,
            'bookLevel'=>$book->level_levelName,
            'bookCategory'=>$book->category_categoryName,
            'bookDesc'=>$book->description,
            'bookTime' =>$dateDiff,
            'bookCreated_at' =>date('D d/M/Y',strtotime($book->created_at)) ,
            'bookFile' => $file[0]->file,
            'bookCover'=>$cover,
            'bookDownloads'=>$downloads,
            'bookLikes' => $likes,
            'bookDislikes'=>$dislikes,
            'bookViews'=>$views,
        ];
        $myBook = array();
        $myBook['data']=$data;
        // dd($myBook);
        return $myBook;



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Cover $cover)
    {
        $status = Array();


        //validating data from api POST
        $data =  request()->validate([
            'ISBN'   => 'required',
            'bookName'   => 'required',
            'bookProvider' => 'required',
            'bookCategory'      => 'required',
            'bookLevel'    => 'required',
            'bookDesc'    => 'required',
            'bookPublisher'    => 'required',
            'bookPages' => '',
            'bookCover'=>'required'
        ]);

        //assign data that will be used in database
        $this->myISBN =$data['ISBN'];
        $book = [
            'ISBN'=>$data['ISBN'],
            'name' => $data['bookName'],
            'publisher' => $data['bookPublisher'],
            'provider_providerName' => $data['bookProvider'],
            'level_levelName' => $data['bookLevel'],
            'category_categoryName' =>$data['bookCategory'],
            'description' =>$data['bookDesc'],
            'created_at' =>Carbon::now(),
            'updated_at' =>Carbon::now(),

        ];

        //hashing the name of the ISBN to get good name for book covers
        $hashed = Hash::make($book['ISBN'],[
            'rounds'=> 12
        ]);


        //array of characters that we want to remove in our hashed name
        $specChars = array(
            ' ' => '',    '!' => '',    '"' => '',
            '#' => '',    '$' => '',    '%' => '',
            '?;' => '',    '\'' => '',   '(' => '',
            ')' => '',    '*' => '',    '+' => '',
            ',' => '',    '₹' => '',    '.' => '',
            '/-' => '',    ':' => '',    ';' => '',
            '<' => '',    '=' => '',    '>' => '',
            '?' => '',    '@' => '',    '[' => '',
            '\\' => '',   ']' => '',    '^' => '',
            '_' => '',    '`' => '',    '{' => '',
            '|' => '',    '}' => '',    '~' => '',
            '-----' => '',    '----' => '',    '---' => '',
            '/' => '',    '--' => '',   '/_' => '',

        );


        //removing dot in our hashed string
        $hashed = chop($hashed,".");

        foreach ($specChars as $k => $v) {
            $hashed = str_replace($k, $v, $hashed);
        }
//        dd($hashed);

        //storing covers
        $path = 'covers/';
        $imageParts = explode(";base64",$data["bookCover"]);
        $image = base64_decode($imageParts[1]);
        $file = $path . $hashed . ".png";
        file_put_contents($file,$image);

        //assigning data to database object
        $cover->book_ISBN = $data['ISBN'];
        $cover->file = $file;
        $cover->created_at = Carbon::now();
        $cover->updated_at = Carbon::now();





        //storing book details to database
        $status['book'] = DB::table('books')->insert($book) ? true : false;

        //storing covers in database
        $status['covers'] = $cover->save() ? true : false;




        return response($status);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($myBook)
    {

        $book = Book::find($myBook);
//        dd($book);
        $book->file = Cover::find($myBook)->file;
        $book->cover = Book_file::find($myBook)->file;


        return response($book);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $book->update($request->all());

        return response($book);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json();

    }


}
