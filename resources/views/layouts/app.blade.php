<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Care System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-primary">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">
                Pet Care System
            </span>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-2 bg-light vh-100 p-3">

                <h5>Menu</h5>

                <ul class="nav flex-column">

                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/pets">
                            Pets
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('services.index') }}">
                            Services
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/bookings">
                            Bookings
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/products">
                            Products
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/payments">
                            Payments
                        </a>
                    </li>

                </ul>

            </div>

            <!-- Content -->
            <div class="col-md-10 p-4">

                @yield('content')

            </div>

        </div>
    </div>

</body>
</html>