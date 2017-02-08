{{--编辑会员资料--}}
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
        <div class="c-content-title-1">
            <h3 class="c-font-uppercase c-font-bold">编辑个人资料</h3>
            <div class="c-line-left"></div>
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @elseif (session('message'))
            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
        @endif
        <form class="c-shop-form-1" method="post" action="{{ route('member.edit') }}">
            {{ csrf_field() }}
            <!-- BEGIN: ADDRESS FORM -->
            <div class="">
                <!-- BEGIN: BILLING ADDRESS -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label">用户名</label>
                                <input type="text" class="form-control c-square c-theme" name="name" placeholder="用户名">
                            </div>

                        </div>
                    </div>
                </div>
                <!-- END: BILLING ADDRESS -->
                <div class="row c-margin-t-30">
                    <div class="form-group col-md-12" role="group">
                        <button type="submit" class="btn btn-lg c-theme-btn c-btn-square c-btn-uppercase c-btn-bold">确认修改</button>
                        <button type="reset" class="btn btn-lg btn-default c-btn-square c-btn-uppercase c-btn-bold">重置</button>
                    </div>
                </div>
            </div>
            <!-- END: ADDRESS FORM -->
        </form>
        <!-- END: PAGE CONTENT -->
    </div>
</div>
@endsection

{{--尾部前端资源--}}
@section('script')

@endsection