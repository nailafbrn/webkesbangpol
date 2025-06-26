<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Ormas;
use App\Models\Program;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $count = Post::count();
        $count2 = Program::count();
        $count3 = Ormas::count();
        $count4 = User::count();

        return view('dashboard.home', compact('count','count2','count3','count4'));
    }
}
