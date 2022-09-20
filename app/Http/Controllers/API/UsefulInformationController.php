<?php 

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\UsefulInformation;

class UsefulInformationController extends Controller
{
    public function List(Request $request){

       $useful_info = UsefulInformation::get();
       return $useful_info;
    }
}