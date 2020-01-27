<?php

namespace App\Http\Controllers;

use App\Download;
use App\User;
use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DownloadController extends Controller
{


    /**
     *
     * show number and statistics about downloads
     *
     * @param Book $_book
     * @param Download $_download
     * @param User $_user
     * @return mixed
     */

    public function downloaders(Book $_book, Download $_download, User $_user){

        $user = DB::select("SELECT COUNT(id) AS downloads, user_username FROM downloads GROUP BY user_username ORDER BY downloads DESC LIMIT 10");
        // dd($user);
        return $user;
    }
}
