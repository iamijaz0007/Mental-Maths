@extends('layouts.master')

@section('main')

<style>
    /* Style for the welcome card */
    .welcome-card {
        background: linear-gradient(135deg, #f5f7fa, #d4ddec);
        border-radius: 15px;
        padding: 15px; /* Reduced padding */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px; /* Reduced margin */
        position: relative;
        overflow: hidden;
    }

    .welcome-card h5 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.4rem; /* Reduced font size */
        color: #2F80ED;
        margin-bottom: 5px; /* Reduced margin */
    }

    .scaleX-n1-rtl {
        transform: scaleX(1);
        border-radius: 50%;
        border: 2px solid #2F80ED; /* Reduced border size */
        padding: 5px;
    }

    /* Hover effect for the background */
    .welcome-card::before {
        content: '';
        position: absolute;
        width: 300px; /* Reduced size */
        height: 300px; /* Reduced size */
        background-color: rgba(47, 128, 237, 0.2);
        top: -60px; /* Adjusted position */
        right: -60px; /* Adjusted position */
        border-radius: 50%;
        transition: transform 0.5s ease;
    }

    .welcome-card:hover::before {
        transform: scale(1.1);
    }

    /* Smaller Minimal Card Styles */
    .dashboard-card {
        background-color: #fff;
        border-radius: 12px; /* Reduced corner radius */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Adjusted shadow */
        transition: all 0.3s ease;
        text-align: center;
        padding: 20px 10px; /* Reduced padding */
        position: relative;
        overflow: hidden;
        cursor: pointer;
        border-top: 3px solid #2F80ED; /* Slightly reduced top accent */
        margin-bottom: 15px; /* Reduced margin */
    }

    .dashboard-card:hover {
        transform: translateY(-6px); /* Slightly smaller hover effect */
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        border-top-color: #F2994A;
    }

    .card-icon-container {
        background-color: #E0F7FA;
        border-radius: 50%;
        padding: 10px; /* Reduced padding */
        display: inline-block;
        transition: background-color 0.3s ease;
    }

    .card-icon {
        width: 50px; /* Reduced icon size */
        height: 50px;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }

    .dashboard-card-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.1rem; /* Reduced font size */
        color: #333;
        margin-top: 5px; /* Reduced margin */
        letter-spacing: 0.5px; /* Reduced letter spacing */
    }

    .dashboard-card:hover .card-icon-container {
        background-color: #FFD54F;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-card-title {
            font-size: 1rem; /* Further reduced font size */
        }

        .card-icon {
            width: 40px; /* Reduced icon size */
            height: 40px;
        }

        .card-icon-container {
            padding: 8px; /* Reduced padding */
        }
    }
</style>

<div class="row">
    <!-- Welcome Card -->
    <div class="col-xxl-12 mb-6 order-0">
        <div class="card welcome-card shadow-lg border-0 rounded-lg">
            <div class="d-flex align-items-start row">
                <div class="col-sm-7 mt-6">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3">Welcome back, {{ Auth::user()->name }} 🎉</h5>
                        <p class="welcome-text mb-6">
                            Welcome to Numerica Academy's admin dashboard, where you can efficiently manage principals, students, and parents. Enhance collaboration and improve the learning experience for all users through this intuitive platform.
                        </p>    
                    </div>
                </div>

                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-6">
                        <img src="../assets/img/illustrations/mm.webp"
                            height="150" class="scaleX-n1-rtl rounded-circle" alt="Dashboard Illustration" /> <!-- Reduced image size -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard Cards -->
<div class="row">
    <div class="col-12 col-md-4 mb-4">
        <a href="{{route('principal.list')}}" class="text-decoration-none">
            <div class="card dashboard-card h-100">
                <div class="card-icon-container">
                    <img src="../assets/img/icons/unicons/p.jpeg" alt="Manage Principals" class="card-icon">
                </div>
                <h5 class="dashboard-card-title">Manage Principals</h5>
            </div>
        </a>
    </div>

    <div class="col-12 col-md-4 mb-4">
        <a href="{{ route('parent.list') }}" class="text-decoration-none">
            <div class="card dashboard-card h-100">
                <div class="card-icon-container">
                    <img src="../assets/img/icons/unicons/pa.jpeg" alt="Manage Parents" class="card-icon">
                </div>
                <h5 class="dashboard-card-title">Manage Parents</h5>
            </div>
        </a>
    </div>

    <div class="col-12 col-md-4 mb-4">
        <a href="{{route('student.list')}}" class="text-decoration-none">
            <div class="card dashboard-card h-100">
                <div class="card-icon-container">
                    <img src="../assets/img/icons/unicons/s.jpeg" alt="View Students" class="card-icon">
                </div>
                <h5 class="dashboard-card-title">View Students</h5>
            </div>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-4 mb-4">
        <a href="{{route('school.list')}}" class="text-decoration-none">
            <div class="card dashboard-card h-100">
                <div class="card-icon-container">
                    <img src="../assets/img/icons/unicons/sc.jpeg" alt="Manage Schools" class="card-icon">
                </div>
                <h5 class="dashboard-card-title">Manage Schools</h5>
            </div>
        </a>
    </div>

    <div class="col-12 col-md-4 mb-4">
        <a href="{{ route('worksheet.index') }}" class="text-decoration-none">
            <div class="card dashboard-card h-100">
                <div class="card-icon-container">
                    <img src="../assets/img/icons/unicons/w.jpeg" alt="Manage Worksheet" class="card-icon">
                </div>
                <h5 class="dashboard-card-title">Manage Worksheet</h5>
            </div>
        </a>
    </div>

    <div class="col-12 col-md-4 mb-4">
        <a href="{{ route('admin.error_reports') }}" class="text-decoration-none">
            <div class="card dashboard-card h-100">
                <div class="card-icon-container">
                    <img src="../assets/img/icons/unicons/w.jpg" alt="Manage Report" class="card-icon">
                </div>
                <h5 class="dashboard-card-title">Manage Report</h5>
            </div>
        </a>
    </div>
</div>

@endsection 
