<!-- Menu -->
<style>
    /* Style for the brand name */
    /* Style for the brand name */
.brand-name {
    font-family: 'Poppins', sans-serif;
    font-size: 1.2rem;
    color: #4A90E2;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    font-weight: 600;
    transition: color 0.3s ease, transform 0.3s ease;
    margin-left: -5px; /* Move the name 5px to the left */
}

.brand-name:hover {
    color: #F39C12;
    transform: scale(1.02);
}

/* Responsive design: Adjust font size for smaller screens */
@media (max-width: 768px) {
    .brand-name {
        font-size: 1rem;
        margin-left: -3px; /* Slightly smaller left margin for mobile */
    }
}

</style>


<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route(Auth::user()->role == 1 ? 'admin.dashboard' : (Auth::user()->role == 2 ? 'principal.dashboard' : (Auth::user()->role == 3 ? 'student.dashboard' : 'parent.dashboard'))) }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <!-- SVG logo here -->
            </span>
            <span class="app-brand-text demo menu-text fw-bold brand-name">Mental Maths</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm d-flex align-items-center justify-content-center"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Conditional Menu Items Based on User Role -->

        @if (Auth::user()->role == 1)
            <!-- Admin Menu -->
            <li class="menu-item @if (Request::segment(2) == 'dashboard') active  @endif">
                <a href="{{route('admin.dashboard')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-smile"></i>
                    <div class="text-truncate" data-i18n="Schools Management">Dashboards </div>
                </a>
            </li>


            <li class="menu-item @if (Request::segment(2) == 'principals') active  @endif">
                <a href="{{route('principal.list')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-chalkboard"></i> <!-- Changed icon to 'bx-chalkboard' -->
                    <div class="text-truncate" data-i18n="Principals">Principals</div>
                </a>
            </li>

            <li class="menu-item @if (Request::segment(2) == 'students') active  @endif">
                <a href="{{route('student.list')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i> <!-- Changed icon to 'bx-user' -->
                    <div class="text-truncate" data-i18n="Students">Students</div> <!-- Changed data-i18n text -->
                </a>
            </li>

            <li class="menu-item @if (Request::segment(2) == 'parents') active  @endif">
                <a href="{{ route('parent.list') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-circle"></i> <!-- Alternative icon for Parents -->
                    <div class="text-truncate" data-i18n="Parents">Parents</div>
                </a>
            </li>

            <li class="menu-item @if (Request::segment(2) == 'schools-management') active  @endif">
                <a href="{{route('school.list')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-building-house"></i> <!-- Alternative icon for Schools -->
                    <div class="text-truncate" data-i18n="Schools Management">Schools</div>
                </a>
            </li>

            <li class="menu-item @if (Request::segment(2) == 'worksheets') active @endif">
                <a href="{{ route('worksheet.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-edit"></i> <!-- Changed icon to 'bx-edit' -->
                    <div class="text-truncate" data-i18n="Worksheets">Worksheet</div>
                </a>
            </li>

            <li class="menu-item @if (Request::segment(2) == 'error-reports') active @endif">
                <a href="{{ route('admin.error_reports') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-bug"></i>
                    <div class="text-truncate" data-i18n="Error Reports">Error Reports</div>
                </a>
            </li>



        @elseif(Auth::user()->role == 2)
            <!-- Principal Menu -->
            <li class="menu-item @if (Request::segment(2) == 'dashboard') active  @endif">
                <a href="{{route('principal.dashboard')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-smile"></i>
                    <div class="text-truncate" data-i18n="Schools Management">Dashboards </div>
                </a>
            </li>

            <li class="menu-item @if (Request::segment(2) == 'students') active  @endif">
                <a href="{{route('student.list')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div class="text-truncate" data-i18n="Students">Students</div>
                </a>
            </li>

            <li class="menu-item @if (Request::segment(2) == 'student-progress') active  @endif">
                <a href="{{ route('principal.student.progress') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-bar-chart"></i>
                    <div class="text-truncate" data-i18n="Student Progress">Student Progress</div>
                </a>
            </li>


        @elseif(Auth::user()->role == 3)
            <!-- Student Menu -->
            <li class="menu-item  @if (Request::segment(2) == 'dashboard') active  @endif">
                <a href="{{route('student.dashboard')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home"></i>
                    <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>


            <li class="menu-item @if (Request::segment(2) == 'student-worksheets') active @endif">
                <a href="{{ route('worksheet.worksheet_list') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-edit"></i> <!-- Changed icon to 'bx-edit' -->
                    <div class="text-truncate" data-i18n="Worksheets">Assign Worksheet</div>
                </a>
            </li>

            @if(Auth::user()->role == 3)
            <!-- Student Menu -->
{{--            <li class="menu-item @if (Request::segment(2) == 'notifications') active  @endif">--}}
{{--                <a href="{{ route('student.notifications') }}" class="menu-link d-flex justify-content-between align-items-center">--}}
{{--                    <div class="d-flex align-items-center">--}}
{{--                        <i class="menu-icon tf-icons bx bx-bell"></i>--}}
{{--                        <div class="text-truncate" data-i18n="Notifications">Notifications</div>--}}
{{--                    </div>--}}
{{--                    @if(isset($pendingCount) && $pendingCount > 0)--}}
{{--                        <span class="badge bg-warning text-dark">{{ $pendingCount }}</span>--}}
{{--                    @endif--}}
{{--                </a>--}}
{{--            </li>--}}
        @endif




        @elseif(Auth::user()->role == 4)
            <!-- Parent Menu -->
            <li class="menu-item @if (Request::segment(2) == 'dashboard') active  @endif">
                <a href="{{route('parent.dashboard')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home"></i>
                    <div class="text-truncate" data-i18n="Dashboard">Dashboard</div>
                </a>
            </li>

            @if(isset($children) && $children->count() > 0)
                @foreach($children as $child)
                    <li class="menu-item">
                        <a href="{{ route('parent.child.progress', ['childId' => $child->id]) }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-bar-chart"></i>
                            <div class="text-truncate" data-i18n="Child Progress">{{ $child->name }}'s Progress</div>
                        </a>
                    </li>
                @endforeach
            @endif

        @endif

    </ul>
</aside>
<!-- / Menu -->
