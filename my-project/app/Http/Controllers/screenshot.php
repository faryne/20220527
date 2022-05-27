<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class screenshot extends Controller
{
    private $service;
    public function __construct(\App\Services\Screenshot $service) {
        $this->service = $service;
    }
    // 顯示頁面
    public function index(Request $request, \App\Services\Screenshot $service) {
        if ($request->method() === "POST") {
            $validation = Validator::make($request->all(), [
                'url' => 'required|url'
            ]);
            if ($validation->fails()) {
                return view('screenshot.index', [
                    'errors' => $validation->messages(),
                    'oldValue' => $request->post("url"),
                ]);
            }
            // @TODO Fetch page
            $result = $service->FetchPage($request->url);
            return view('screenshot.index', [
                'result' => $result,
                'screenshots' => \App\Models\screenshot::paginate(15),
            ]);
        }
        return view('screenshot.index', [
            'screenshots' => \App\Models\screenshot::paginate(15),
        ]);
    }
}
