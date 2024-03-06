<?php

namespace App\Http\Controllers;

use App\Models\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class APIController extends Controller
{
    public function allData(Request $request)
    {
        if($request->id)
        {
            $id = intval($request->id);
            $data = Data::where('id', $id)->get();
            return response()->json($data);
        }

        $data = Data::all();
        return response()->json($data);
    }

    public function postData(Request $request)
    {
        if ($request->isJson()) {
            $jsonData = $request->json()->all();

            Data::create([
                'test1' => $jsonData["test1"],
                'test2' => $jsonData["test2"],
            ]);
    
            return response()->json(['message' => 'New Data Have Been Created']);
        } else {
            return response()->json(['message' => 'Invalid request. Expected JSON data.'], 400);
        }
    }

    public function modifyData(Request $request)
    {
        if ($request->isJson()) {
            $jsonData = $request->json()->all();

            $data1 = Data::find($jsonData["id"]);

            $data1->test1 = $jsonData["test1"];
            $data1->test2 = $jsonData["test2"];

            $data1->save();

            return response()->json(['message' => 'Your Data Has Been Updated']);
        } else {
            return response()->json(['message' => 'Invalid request. Expected JSON data.'], 400);
        }
    }

    public function getAPI()
    {
        $response = Http::get('http://laravel-rest-api.test/api/data/getData');

        if ($response->successful()) {
            $data = $response->json();
            dd($data);
        }
    }
}
