<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MobPanel') }} - Dashboard</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #343a40;
            color: white;
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .nav-link {
            color: rgba(255, 255, 255, .75);
            padding: .5rem 1rem;
        }
        .nav-link:hover {
            color: white;
        }
        .nav-link.active {
            color: white;
            font-weight: bold;
        }
        .main-content {
            margin-left: 240px;
            padding: 2rem;
        }
        @media (max-width: 767.98px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky sidebar-sticky">
                    <div class="px-3 py-4">
                        <h3>MobPanel</h3>
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('dashboard') }}">
                                <span data-feather="home"></span>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('servers.index') }}">
                                <span data-feather="server"></span>
                                Servers
                            </a>
                        </li>
                        @if(auth()->user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.index') }}">
                                <span data-feather="settings"></span>
                                Admin Panel
                            </a>
                        </li>
                        @endif
                        <li class="nav-item mt-5">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link border-0 bg-transparent">
                                    <span data-feather="log-out"></span>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="main-content col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>

                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                Your Servers
                            </div>
                            <div class="card-body">
                                @if(count(auth()->user()->servers) > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(auth()->user()->servers as $server)
                                            <tr>
                                                <td>{{ $server->name }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $server->status == 'running' ? 'success' : ($server->status == 'stopped' ? 'danger' : 'warning') }}">
                                                        {{ ucfirst($server->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('servers.show', $server->id) }}" class="btn btn-sm btn-primary">Manage</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <p>You don't have any servers yet.</p>
                                <a href="{{ route('servers.create') }}" class="btn btn-primary">Create Server</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                System Status
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h5>CPU Usage</h5>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h5>Memory Usage</h5>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">40%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h5>Disk Usage</h5>
                                            <div class="progress">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100">60%</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h5>Network</h5>
                                            <div class="progress">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">15%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"></script>
    <script>
        // Initialize Feather icons
        feather.replace();
    </script>
</body>
</html>