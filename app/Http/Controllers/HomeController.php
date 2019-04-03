<?php

namespace App\Http\Controllers;

use App\Application;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // 获取用户的应用信息
        $applications = Application::where('user_id', auth()->id())->paginate(5);

        // 如果是管理员，获取全部应用信息
        if (auth()->user()->is_admin) {
            $applications = Application::query()->with('user')->paginate(5);
        }

        return view('home', compact('applications'));
    }
}
