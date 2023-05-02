<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class AttchmentController extends Controller
{

    public function store(Request $request)
    {
        $name =  md5(time()) . rand(1000,9999999) . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('uploads/junk'), $name);

        return response()->json([
            'name' => $name,
        ]);
    }

    public function delete(Request $request){
        $filename =  $request->get('filename');
        File::Delete(public_path('uploads/junk/'.$filename));

        return $filename;
    }
}
