<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $title = "welcom to laravel";
        return view('pages.index', compact('title'));
    }
    public function about()
    {
        return view('pages.about');
    }
    public function services()
    {
        
        $data = array(
            'title' => 'Services Page',
            'services' => ['Web Design', 'Graphics Design', 'Art Work']
        );
        return view('pages.services')->with($data);
    }
}
