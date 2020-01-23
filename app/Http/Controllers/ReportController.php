<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    /**
     * store report
     *
     * @param Request $req
     * @param Report $report
     * @return mixed
     */
    public function store(Request $req, Report $report){

        Report::create([
            'user_username'=>$req->user,
            'message'=>$req->message,
        ]);

        return $report->get();
    }


    /**
     * show unread report
     *
     * @param Report $report
     * @return mixed
     */
    public function show(Report $report){
        $unseenReports = $report->where('seen',0)->get();
        return $unseenReports;
    }


    /**
     * show seen reports
     *
     * @param Request $req
     * @param Report $report
     * @return array
     */
    public function seen(Request $req,Report $report){

        //   $repoId =
        $seen = DB::table('reports')->where('id','=',$req->repo)->update(['seen'=>'1']);
        if($seen){

            $response = ['res' => true];
            return $response;
        } else {

            $response = ['res' => false];
            return $response;
        }
    }

}
