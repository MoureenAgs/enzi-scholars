<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container-fluid px-4">

        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
            <img src="{{ asset('images/logo.jpg') }}" alt="Enzi Scholars" style="height: 42px; width: 42px; object-fit: cover; border-radius: 8px;">
            <span class="fw-bold" style="color: #2C7A78;">A New Era of Empowered Minds</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-semibold' : '' }}" href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>

                @if (auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('scholarships.*') ? 'active fw-semibold' : '' }}" href="{{ route('scholarships.index') }}">
                            Scholarships
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('assignments.*') ? 'active fw-semibold' : '' }}" href="{{ route('assignments.index') }}">
                            Assignments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('decisions.*') ? 'active fw-semibold' : '' }}" href="{{ route('decisions.select') }}">
                            Rankings &amp; Decisions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('logs.*') ? 'active fw-semibold' : '' }}" href="{{ route('logs.index') }}">
                            Activity Log
                        </a>
                    </li>
                @endif

                @if (auth()->user()->isReviewer())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reviewer.scores.*') ? 'active fw-semibold' : '' }}" href="{{ route('reviewer.scores.index') }}">
                            Assigned Applications
                        </a>
                    </li>
                @endif

                @if (auth()->user()->isApplicant())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('applicant.profile.*') ? 'active fw-semibold' : '' }}" href="{{ route('applicant.profile.edit') }}">
                            My Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('applicant.applications.index') ? 'active fw-semibold' : '' }}" href="{{ route('applicant.applications.index') }}">
                            Browse Scholarships
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('applicant.applications.my') ? 'active fw-semibold' : '' }}" href="{{ route('applicant.applications.my') }}">
                            My Applications
                        </a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav align-items-lg-center gap-lg-2">

                @php
                    $unreadNotifications = auth()->user()->notifications()->where('is_read', false)->latest()->get();
                @endphp

                <!-- Notifications -->
                <li class="nav-item dropdown">
                    <a class="nav-link position-relative" href="#" role="button" data-bs-toggle="dropdown">
                        🔔
                        @if ($unreadNotifications->count() > 0)
                            <span class="badge rounded-pill bg-danger" style="font-size: 0.6rem; position: relative; top: -8px;">
                                {{ $unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="min-width: 280px;">
                        @forelse ($unreadNotifications as $notification)
                            <li class="px-3 py-2 border-bottom">
                                <div style="font-size: 0.85rem;">{{ $notification->message }}</div>
                                <div class="text-muted" style="font-size: 0.72rem;">{{ $notification->created_at->diffForHumans() }}</div>
                            </li>
                        @empty
                            <li class="px-3 py-2 text-muted" style="font-size: 0.85rem;">No new notifications.</li>
                        @endforelse

                        @if ($unreadNotifications->count() > 0)
                            <li>
                                <form method="POST" action="{{ route('notifications.markRead') }}" class="px-3 py-2">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-link p-0" style="color: #2C7A78;">
                                        Mark all as read
                                    </button>
                                </form>
                            </li>
                        @endif
                    </ul>
                </li>

                <!-- User dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Log Out</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>