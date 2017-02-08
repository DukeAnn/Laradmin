@extends('layouts.main')

{{--顶部前端资源--}}
@section('styles')

@endsection

{{--页面内容--}}
@section('content')
<div class="container">
    @include('layouts.main.member_sidebar')
    <div class="c-layout-sidebar-content ">
        <!-- BEGIN: PAGE CONTENT -->
        <!-- BEGIN: CONTENT/SHOPS/SHOP-CUSTOMER-DASHBOARD-1 -->
        <div class="c-content-title-1">
            <h3 class="c-font-uppercase c-font-bold">仪表盘</h3>
            <div class="c-line-left"></div>
            <p class=""> 你好
                <a href="javascript:;" class="c-theme-link">{{ Auth::user()->name }}</a>
                <br />
            </p>
        </div>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 c-margin-b-20">
                <h3 class="c-font-uppercase c-font-bold">信息总览</h3>
                <ul class="c-content-list-1 c-theme">
                    <li>邮箱：{{ Auth::user()->email }}</li>
                    <li>用户名：{{ Auth::user()->name }}</li>
                </ul>
            </div>
        </div>
        <!-- END: CONTENT/SHOPS/SHOP-CUSTOMER-DASHBOARD-1 -->
        <!-- END: PAGE CONTENT -->
    </div>
</div>
@endsection

{{--尾部前端资源--}}
@section('script')

@endsection