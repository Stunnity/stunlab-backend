<?php

namespace App\Http\Controllers;

use App\Book;
use App\Category;
use App\Download;
use App\Report;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function show(Book $book, User $user, Download $download, Report $report, Category $category)
    {
        $provider = 'WDA';

        $total = DB::select("SELECT COUNT(id) AS downloads FROM downloads WHERE book_ISBN IN (SELECT ISBN from books WHERE provider_providerName ='".$provider."')");
        $data = [
            'totalBooks' => $book->count(),
            'books' => $book->where('provider_providerName',$provider)->count(),
            'totalDownloads' => $download->count(),
            'downloads' => $total[0]->downloads,
            'reports' => $report->count(),
            'newReports' => $report->where('seen','0')->count(),
            'users' => $user->count(),
        ];

        return $data;
    }

    public function  test(){
        return 'yes';
    }
}
