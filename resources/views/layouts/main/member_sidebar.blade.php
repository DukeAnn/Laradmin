{{--会员中心侧边栏--}}
<div class="c-layout-sidebar-menu c-theme ">
    <!-- BEGIN: LAYOUT/SIDEBARS/SHOP-SIDEBAR-DASHBOARD -->
    <div class="c-sidebar-menu-toggler">
        <h3 class="c-title c-font-uppercase c-font-bold">会员中心</h3>
        <a href="javascript:;" class="c-content-toggler" data-toggle="collapse" data-target="#sidebar-menu-1">
            <span class="c-line"></span>
            <span class="c-line"></span>
            <span class="c-line"></span>
        </a>
    </div>
    <ul class="c-sidebar-menu collapse " id="sidebar-menu-1">
        <li class="c-dropdown c-open">
            <a href="javascript:;" class="c-toggler">会员中心
                <span class="c-arrow"></span>
            </a>
            <ul class="c-dropdown-menu">
                <li @if(if_route(['member.index']))class="c-active"@endif>
                    <a href="{{ route('member.index') }}">个人信息</a>
                </li>
                <li @if(if_route(['member.edit']))class="c-active"@endif>
                    <a href="{{ route('member.edit') }}">编辑资料</a>
                </li>
                <li @if(if_route(['member.password']))class="c-active"@endif>
                    <a href="{{ route('member.password') }}">重置密码</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- END: LAYOUT/SIDEBARS/SHOP-SIDEBAR-DASHBOARD -->
</div>