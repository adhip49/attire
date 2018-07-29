<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LRedis;

class chatController extends Controller {

//    public function __construct()
//    {
//        $this->middleware('guest');
//    }

    public function sendMessage(Request $request){
         $user = $request->input('user');
         $message = $request->input('message');
        $redis = LRedis::connection();
        $data = ['message' => $message, 'user' => $user];
        $redis->publish('message', json_encode($data));
        return response()->json($data);
    }
}