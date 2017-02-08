{{--顶部导航--}}
<header class="c-layout-header c-layout-header-4 c-layout-header-default-mobile" data-minimize-offset="80">
    <div class="c-navbar">
        <div class="container">
            <!-- BEGIN: BRAND -->
            <div class="c-navbar-wrapper clearfix">
                <div class="c-brand c-pull-left">
                    <a href="index.html" class="c-logo">
                        <img src="{{ asset('assets/front/img/layout/logos/logo-3.png') }}" alt="JANGO" class="c-desktop-logo">
                        <img src="{{ asset('assets/front/img/layout/logos/logo-3.png') }}" alt="JANGO" class="c-desktop-logo-inverse">
                        <img src="{{ asset('assets/front/img/layout/logos/logo-3.png') }}" alt="JANGO" class="c-mobile-logo"> </a>
                    <button class="c-hor-nav-toggler" type="button" data-target=".c-mega-menu">
                        <span class="c-line"></span>
                        <span class="c-line"></span>
                        <span class="c-line"></span>
                    </button>
                    <button class="c-topbar-toggler" type="button">
                        <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <button class="c-search-toggler" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                    <button class="c-cart-toggler" type="button">
                        <i class="icon-handbag"></i>
                        <span class="c-cart-number c-theme-bg">2</span>
                    </button>
                </div>
                <!-- END: BRAND -->
                <!-- BEGIN: QUICK SEARCH -->
                <form class="c-quick-search" action="#">
                    <input type="text" name="query" placeholder="Type to search..." value="" class="form-control" autocomplete="off">
                    <span class="c-theme-link">&times;</span>
                </form>
                <!-- END: QUICK SEARCH -->
                <!-- BEGIN: HOR NAV -->
                <!-- BEGIN: LAYOUT/HEADERS/MEGA-MENU -->
                <!-- BEGIN: MEGA MENU -->
                <!-- Dropdown menu toggle on mobile: c-toggler class can be applied to the link arrow or link itself depending on toggle mode -->
                <nav class="c-mega-menu c-pull-right c-mega-menu-dark c-mega-menu-dark-mobile c-fonts-uppercase c-fonts-bold">
                    <ul class="nav navbar-nav c-theme-nav">
                        <li class="c-active c-menu-type-classic">
                            <a href="javascript:;" class="c-link dropdown-toggle">会员中心
                                <span class="c-arrow c-toggler"></span>
                            </a>
                            <ul class="dropdown-menu c-menu-type-inline c-pull-left">
                                <li>
                                    <a href="index.html">个人信息</a>
                                </li>
                                <li>
                                    <a href="home-2.html">编辑资料</a>
                                </li>
                            </ul>
                        </li>
                        <li class="c-menu-type-classic">
                            <a href="javascript:;" class="c-link dropdown-toggle">菜单下拉展示
                                <span class="c-arrow c-toggler"></span>
                            </a>
                            <ul class="dropdown-menu c-menu-type-classic c-pull-left">
                                <li class="dropdown-submenu">
                                    <a href="page-extended-portfolio.html">Multi Level Menu
                                        <span class="c-arrow c-toggler"></span>
                                    </a>
                                    <ul class="dropdown-menu c-pull-right">
                                        <li>
                                            <a href="#">Example Link</a>
                                        </li>
                                        <li>
                                            <a href="#">Example Link</a>
                                        </li>
                                        <li>
                                            <a href="#">Example Link</a>
                                        </li>
                                        <li class="dropdown-submenu">
                                            <a href="#">Example Sub Menu
                                                <span class="c-arrow c-toggler"></span>
                                            </a>
                                            <ul class="dropdown-menu c-pull-left">
                                                <li>
                                                    <a href="#">Example Link</a>
                                                </li>
                                                <li>
                                                    <a href="#">Example Link</a>
                                                </li>
                                                <li>
                                                    <a href="#">Example Link</a>
                                                </li>
                                                <li class="dropdown-submenu">
                                                    <a href="#">Example Sub Menu
                                                        <span class="c-arrow c-toggler"></span>
                                                    </a>
                                                    <ul class="dropdown-menu c-pull-left">
                                                        <li>
                                                            <a href="#">Example Link</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Example Link</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Example Link</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Example Link</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li>
                                                    <a href="#">Example Link</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Example Link</a>
                                        </li>
                                        <li>
                                            <a href="#">Example Link</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                      {{--  <li class="c-cart-toggler-wrapper">
                            <a href="#" class="c-btn-icon c-cart-toggler">
                                <i class="icon-handbag c-cart-icon"></i>
                                <span class="c-cart-number c-theme-bg">2</span>
                            </a>
                        </li>--}}
                        @if(!Auth::check())
                            <li>
                                <a href="javascript:;" data-toggle="modal" data-target="#login-form" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">
                                    <i class="icon-user"></i>登录
                                </a>
                            </li>
                        @else
                            <li class="c-menu-type-classic">
                                <a href="javascript:;" class="c-link dropdown-toggle">
                                    <i class="icon-user"></i>&nbsp;&nbsp;{{ Auth::user()->name }}
                                    <span class="c-arrow c-toggler"></span>
                                </a>
                                <ul class="dropdown-menu c-menu-type-inline c-pull-left">
                                    <li>
                                        <a href="#"><i class="fa fa-user"></i>个人资料</a>
                                    </li>
                                    <li>
                                        <a href="javascript:;"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-sign-out"></i>注销
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </nav>
                <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                <!-- END: MEGA MENU -->
                <!-- END: LAYOUT/HEADERS/MEGA-MENU -->
                <!-- END: HOR NAV -->
            </div>
            <!-- BEGIN: LAYOUT/HEADERS/QUICK-CART -->
            <!-- BEGIN: CART MENU -->
           {{-- <div class="c-cart-menu">
                <div class="c-cart-menu-title">
                    <p class="c-cart-menu-float-l c-font-sbold">2 item(s)</p>
                    <p class="c-cart-menu-float-r c-theme-font c-font-sbold">$79.00</p>
                </div>
                <ul class="c-cart-menu-items">
                    <li>
                        <div class="c-cart-menu-close">
                            <a href="#" class="c-theme-link">×</a>
                        </div>
                        <img src="{{ asset('assets/front/img/24.jpg') }}" />
                        <div class="c-cart-menu-content">
                            <p>1 x
                                <span class="c-item-price c-theme-font">$30</span>
                            </p>
                            <a href="shop-product-details-2.html" class="c-item-name c-font-sbold">Winter Coat</a>
                        </div>
                    </li>
                    <li>
                        <div class="c-cart-menu-close">
                            <a href="#" class="c-theme-link">×</a>
                        </div>
                        <img src="assets/base/img/content/shop2/12.jpg" />
                        <div class="c-cart-menu-content">
                            <p>1 x
                                <span class="c-item-price c-theme-font">$30</span>
                            </p>
                            <a href="shop-product-details.html" class="c-item-name c-font-sbold">Sports Wear</a>
                        </div>
                    </li>
                </ul>
                <div class="c-cart-menu-footer">
                    <a href="shop-cart.html" class="btn btn-md c-btn c-btn-square c-btn-grey-3 c-font-white c-font-bold c-center c-font-uppercase">View Cart</a>
                    <a href="shop-checkout.html" class="btn btn-md c-btn c-btn-square c-theme-btn c-font-white c-font-bold c-center c-font-uppercase">Checkout</a>
                </div>
            </div>--}}
            <!-- END: CART MENU -->
            <!-- END: LAYOUT/HEADERS/QUICK-CART -->
        </div>
    </div>
</header>