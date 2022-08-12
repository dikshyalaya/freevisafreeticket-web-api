<?php

namespace App\Http\Controllers\Admin\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;

class JobsAjaxController extends Controller
{
    public function list(){
        $jobs=\DB::table('jobs')->get();
        return  Response::json($jobs); 
    }
}
