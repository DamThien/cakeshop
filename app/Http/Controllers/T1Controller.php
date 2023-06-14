<?php

namespace App\Http\Controllers;

use App\Models\t1;
use Illuminate\Http\Request;

class T1Controller extends Controller
{
    public function getT1s()
    {
        $T1s = T1::all();
        return response()->json($T1s);
    }
    public function getOneT1($id)
    {
        $T1 = T1::find($id);
        return response()->json($T1);
    }
    public function addT1(Request $request)
    {
        $T1 = new T1();
        $T1->name = $request->input('name');
        $T1->image = $request->input('image');
        $T1->rating = $request->input('rating');
        $T1->price = $request->input('price');
        $T1->sold = $request->input('sold');
        $T1->save();
        return response()->json(['status' => 'ok', 'msg' => 'Edit successed']);
    }
    public function deleteT1($id)
    {
        $T1 = T1::find($id);
        
        $T1->delete();
        return ['status' => 'ok', 'msg' => 'Delete successed'];
    }
    public function editT1(Request $request, $id)
    {
        $T1 = T1::find($id);
        $T1->name = $request->input('name');
        $T1->image = $request->input('image');
        $T1->rating = $request->input('rating');
        $T1->price = $request->input('price');
        $T1->sold = $request->input('sold');
        $T1->save();
        return response()->json(['status' => 'ok', 'msg' => 'Edit successed']);
    }
    public function uploadImage(Request $request)
    {
        // process image
        if ($request->hasFile('uploadImage')) {
            $file = $request->file('uploadImage');
            $fileName = $file->getClientOriginalName();

            $file->move('source/image/product', $fileName);

            return response()->json(["message" => "ok"]);
        } else return response()->json(["message" => "false"]);
    }
}
