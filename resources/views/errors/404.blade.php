@extends('layouts.errors')

@section('title', 'Page Title')

@section('content')
    <div class="row">
        <div class="col-md-12 page-500">
            <div class=" number font-red"> 404 </div>
            <div class=" details">
                <h3>啊哦！看起来走错路了。</h3>
                <p> 点击下方链接返回首页
                    <br/>
                </p>
                <p>
                    <a href="{{ url('/') }}" class="btn red btn-outline"> 返回首页 </a>
                    <br>
                </p>
            </div>
        </div>
    </div>
@endsection