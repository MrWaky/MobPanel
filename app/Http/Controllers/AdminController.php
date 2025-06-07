<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * Display the users management page.
     *
     * @return \Illuminate\Http\Response
     */
    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    /**
     * Display the nodes management page.
     *
     * @return \Illuminate\Http\Response
     */
    public function nodes()
    {
        // In a real implementation, you would fetch nodes from the database
        return view('admin.nodes');
    }

    /**
     * Display the games management page.
     *
     * @return \Illuminate\Http\Response
     */
    public function games()
    {
        // In a real implementation, you would fetch games from the database
        return view('admin.games');
    }
}