<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow @yield('sidebar-size')"
    data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto"><a class="navbar-brand"
                    href="../../../html/ltr/vertical-menu-template/index.html">
                    <span class="brand-logo">
                        {{-- <img src="{{ asset('logo-color.png') }}" /> --}}
                    </span>
                    <h2 class="brand-text">
                        <div class="d-flex w-100 align-items-center justify-content-between" style="margin-left: -50px">
                            {{-- <img src="{{ asset('logo-color.png') }}" style="width:100%;max-width:40px" class="me-1" /> --}}
                            {{-- <h6 class="mb-0 text-wrap fw-bolder"><span style="color:#0F6CB5">Human</span><span style="color:#F26E22">Techno</span></h6> --}}
                        </div>
                    </h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i
                        class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i
                        class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                        data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="navigation-header"><span data-i18n="Apps &amp; Pages">Web Content</span><i
                    data-feather="more-horizontal"></i>
            </li>
            <li class="nav-item {{ request()->path() == '/products' ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ url('/products') }}">
                    <i data-feather="file"></i>
                    <span class="menu-title text-truncate">Products</span>
                </a>
            </li>
            <li class="nav-item {{ request()->path() == '/projects' ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ url('/projects') }}">
                    <i data-feather="file"></i>
                    <span class="menu-title text-truncate">Projects</span>
                </a>
            </li>
        </ul>
    </div>
</div>
