<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $roles=['admin','super_admin'];

        $data = Article::where('is_published',false)->get();


        return view('index', compact('data'));
    }
}
