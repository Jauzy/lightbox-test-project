@php
$url = url()->current();
$exp = explode('/', $url);
$url = array_slice($exp, 3);
@endphp

<nav
    class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon"
                            data-feather="menu"></i></a></li>
            </ul>
            <ul class="nav navbar-nav bookmark-icons align-items-center">
                @if (trim($__env->yieldContent('url_back')))
                    <li class="nav-item d-none d-lg-block">
                        <a href="@yield('url_back')" class="fw-bold bg-danger text-white d-flex avatar"
                            style="width:30px;height:30px">
                            <i class="m-auto" data-feather="chevron-left"></i></a>
                    </li>
                @else
                    <li class="nav-item d-none d-lg-block">
                        <a href="{{ url('') }}" class="fw-bold bg-danger text-white d-flex avatar"
                            style="width:30px;height:30px">
                            <i class="m-auto" data-feather="chevron-left"></i></a>
                    </li>
                @endif
                <li class="nav-item d-none d-lg-block">
                    <div class="ms-1">
                        <h4 class="h5 mb-0 fw-bold">@yield('page_title')</h4>
                        <small class="mb-0">
                            @foreach ($url as $key => $item)
                                {{ ucwords($item) }} @if ($key != count($url) - 1)
                                    <span><i data-feather="chevron-right"></i></span>
                                @endif
                            @endforeach
                        </small>
                    </div>
                </li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ms-auto">
            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link"
                    id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none"><span
                            class="user-name fw-bolder">{{session()->get('userFullname')}}</span><span
                            class="user-status">{{session()->get('userRole')}}</span></div><span class="avatar"><img
                            class="round"
                            src="{{ asset('themes/vuexy/images/portrait/small/avatar-s-11.jpg') }}" alt="avatar"
                            height="40" width="40"><span class="avatar-status-online"></span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user"><a class="dropdown-item"
                        href="page-profile.html"><i class="me-50" data-feather="user"></i> Profile</a><a
                        class="dropdown-item" href="app-email.html"><i class="me-50" data-feather="mail"></i>
                        Inbox</a><a class="dropdown-item" href="app-todo.html"><i class="me-50"
                            data-feather="check-square"></i> Task</a><a class="dropdown-item" href="app-chat.html"><i
                            class="me-50" data-feather="message-square"></i> Chats</a>
                    <div class="dropdown-divider"></div><a class="dropdown-item"
                        href="page-account-settings-account.html"><i class="me-50" data-feather="settings"></i>
                        Settings</a><a class="dropdown-item" href="page-pricing.html"><i class="me-50"
                            data-feather="credit-card"></i> Pricing</a><a class="dropdown-item" href="page-faq.html"><i
                            class="me-50" data-feather="help-circle"></i> FAQ</a><a class="dropdown-item"
                        href="{{ url('api/logout') }}"><i class="me-50" data-feather="power"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
