@extends('layouts.master')

@section('main')

<style>
    /* Style for the welcome card */
    .welcome-card {
        background: linear-gradient(135deg, #f5f7fa, #d4ddec);
        border-radius: 15px;
        padding: 20px; /* Reduced padding */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
        position: relative;
        overflow: hidden;
    }

    .welcome-card h5 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.6rem; /* Reduced font size */
        color: #2F80ED;
        margin-bottom: 10px;
    }

    .scaleX-n1-rtl {
        transform: scaleX(1);
        border-radius: 50%;
        border: 3px solid #2F80ED; /* Reduced border size */
        padding: 5px;
    }

    /* Hover effect for the background */
    .welcome-card::before {
        content: '';
        position: absolute;
        width: 350px;
        height: 350px;
        background-color: rgba(47, 128, 237, 0.2);
        top: -80px;
        right: -80px;
        border-radius: 50%;
        transition: transform 0.5s ease;
    }

    .welcome-card:hover::before {
        transform: scale(1.1);
    }

    /* Smaller Minimal Card Styles */
    .dashboard-card {
        background-color: #fff;
        border-radius: 15px; /* Reduced corner radius */
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1); /* Adjusted shadow */
        transition: all 0.3s ease;
        text-align: center;
        padding: 30px 15px; /* Reduced padding */
        position: relative;
        overflow: hidden;
        cursor: pointer;
        border-top: 4px solid #2F80ED; /* Slightly reduced top accent */
    }

    .dashboard-card:hover {
        transform: translateY(-8px); /* Slightly smaller hover effect */
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.15);
        border-top-color: #F2994A;
    }

    .card-icon-container {
        background-color: #E0F7FA;
        border-radius: 50%;
        padding: 18px; /* Reduced padding */
        display: inline-block;
        transition: background-color 0.3s ease;
    }

    .card-icon {
        width: 60px; /* Reduced icon size */
        height: 60px;
        filter: drop-shadow(0 3px 5px rgba(0, 0, 0, 0.2));
    }

    .dashboard-card-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.2rem; /* Reduced font size */
        color: #333;
        margin-top: 10px;
        letter-spacing: 0.8px;
    }

    .dashboard-card:hover .card-icon-container {
        background-color: #FFD54F;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-card-title {
            font-size: 1.1rem;
        }

        .card-icon {
            width: 50px;
            height: 50px;
        }

        .card-icon-container {
            padding: 12px;
        }
    }

</style>

<div class="row">
    <!-- Welcome Card -->
    <div class="col-xxl-12 mb-6 order-0">
        <div class="card welcome-card shadow-lg border-0 rounded-lg">
            <div class="d-flex align-items-start row">
                <div class="col-sm-7 mt-12">
                    <div class="card-body">
                        <h5 class="card-title text-primary mb-3">Welcome, {{ Auth::user()->name }} to Numerica Academy 🎉</h5>
                        <p class="welcome-text mb-4">
                            Explore your courses, complete your assignments, and track your progress. Stay focused and keep up the great work!
                        </p>
                    </div>
                </div>

                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-6">
                        <img src="../assets/img/illustrations/mm.webp"
                             height="180" class="scaleX-n1-rtl rounded-circle" alt="Dashboard Illustration" />
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- Dashboard Cards for Student -->
<div class="row">
    <!-- Start Worksheet Card -->
    <div class="col-12 col-md-4 mb-4">
        <a href="{{ route('practice-worksheet.start') }}" class="text-decoration-none">
            <div class="card dashboard-card h-100">
                <div class="card-icon-container">
                    <img src="../assets/img/icons/unicons/book.png" alt="Start Worksheet" class="card-icon">
                </div>
                <h5 class="dashboard-card-title">Practice Worksheet</h5>
            </div>
        </a>
    </div>


    <!-- Error Notifications Card -->
    <div class="col-12 col-md-4 mb-4">
        <a href="{{ route('student.notifications') }}" class="text-decoration-none">
            <div class="card dashboard-card h-100">
                <div class="card-icon-container">
                    <img src="../assets/img/icons/unicons/bell.png" alt="Error Notifications" class="card-icon">
                </div>
                <h5 class="dashboard-card-title">Notifications</h5>
            </div>
        </a>
    </div>
</div>

@endsection
