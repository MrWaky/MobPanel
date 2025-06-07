<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servers = auth()->user()->servers;
        return view('servers.index', compact('servers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // In a real implementation, you would fetch available games, nodes, etc.
        return view('servers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'game_id' => 'required|integer',
            'node_id' => 'required|integer',
            'memory' => 'required|integer|min:256',
            'disk' => 'required|integer|min:1024',
            'cpu' => 'required|integer|min:10',
        ]);

        $server = new Server();
        $server->name = $request->name;
        $server->user_id = auth()->id();
        $server->game_id = $request->game_id;
        $server->node_id = $request->node_id;
        $server->allocation_id = 1; // This would be dynamically assigned in a real implementation
        $server->status = 'installing';
        $server->memory = $request->memory;
        $server->disk = $request->disk;
        $server->cpu = $request->cpu;
        $server->installed = false;
        $server->save();

        // In a real implementation, you would queue a job to install the server

        return redirect()->route('servers.show', $server->id)
            ->with('success', 'Server created successfully. Installation in progress...');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function show(Server $server)
    {
        // Check if the user owns this server
        if ($server->user_id !== auth()->id()) {
            return redirect()->route('servers.index')
                ->with('error', 'You do not have permission to view this server.');
        }

        return view('servers.show', compact('server'));
    }

    /**
     * Show the console for the specified server.
     *
     * @param  \App\Models\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function console(Server $server)
    {
        // Check if the user owns this server
        if ($server->user_id !== auth()->id()) {
            return redirect()->route('servers.index')
                ->with('error', 'You do not have permission to view this server console.');
        }

        return view('servers.console', compact('server'));
    }

    /**
     * Handle power actions for the server.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Server  $server
     * @return \Illuminate\Http\Response
     */
    public function power(Request $request, Server $server)
    {
        // Check if the user owns this server
        if ($server->user_id !== auth()->id()) {
            return redirect()->route('servers.index')
                ->with('error', 'You do not have permission to control this server.');
        }

        $request->validate([
            'action' => 'required|in:start,stop,restart',
        ]);

        $action = $request->action;
        
        // In a real implementation, you would send commands to the daemon
        // For now, we'll just update the status
        switch ($action) {
            case 'start':
                $server->status = 'running';
                break;
            case 'stop':
                $server->status = 'stopped';
                break;
            case 'restart':
                $server->status = 'restarting';
                // In a real implementation, you would queue a job to restart the server
                // For demo purposes, we'll just set it to running after a delay
                $server->status = 'running';
                break;
        }
        
        $server->save();

        return redirect()->back()->with('success', 'Server ' . $action . ' command sent successfully.');
    }
}