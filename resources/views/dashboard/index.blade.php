<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">
            Pet Care System
        </span>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-2 bg-dark text-white min-vh-100 p-3">

            <h4>Pet Care</h4>
            <hr>

            <ul class="nav flex-column">

                <li class="nav-item mb-2">
                    <a href="/dashboard" class="nav-link text-white">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="/pets" class="nav-link text-white">
                        <i class="bi bi-heart-fill"></i> Pets
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="/services" class="nav-link text-white">
                        <i class="bi bi-wrench"></i> Services
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="/bookings" class="nav-link text-white">
                        <i class="bi bi-calendar-check"></i> Bookings
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="/products" class="nav-link text-white">
                        <i class="bi bi-bag"></i> Products
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="/payments" class="nav-link text-white">
                        <i class="bi bi-credit-card"></i> Payments
                    </a>
                </li>

            </ul>

        </div>

        <!-- Content Dashboard -->
        <div class="col-md-10 p-4">

            <h2>Dashboard Pet Care</h2>

            <div class="row mt-4">

                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5>Total Pet</h5>
                            <h2>0</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5>Total Booking</h5>
                            <h2>0</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5>Total Product</h5>
                            <h2>0</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5>Total Payment</h5>
                            <h2>0</h2>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

</div>

</body>
</html>