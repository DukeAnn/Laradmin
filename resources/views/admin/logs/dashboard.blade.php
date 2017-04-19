@extends('admin.layouts.main')

{{--顶部前端资源--}}
@section('styles')

@endsection

{{--页面内容--}}
@section('content')
    <div class="row">
        <div class="col-md-6">
            <!-- BEGIN CHART PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bar-chart font-green-haze"></i>
                        <span class="caption-subject bold uppercase font-green-haze">日志统计</span>
                    </div>
                    <div class="tools">
                        <button type="button" class="btn green btn-outline" onclick="location='{{ route('log.list') }}'">查看日志列表</button>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="chart_logs_all" class="chart" style="height: 525px;"> </div>
                </div>
            </div>
            <!-- END CHART PORTLET-->
        </div>
        <div class="col-md-6">
            @foreach($percents as $level => $item)
                @if($level == 'all')
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @else
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                @endif
                    <a class="dashboard-stat dashboard-stat-v2 {{ $item['count'] === 0 ? log_styler()->color('empty') : log_styler()->color($level) }}" href="#">
                        <div class="visual">
                            {!! log_styler()->icon($level) !!}
                        </div>
                        <div class="details">
                            <div class="number">
                                <span data-counter="counterup" data-value="{{ $item['count'] }}">0</span>条
                            </div>
                            <div class="desc">{{ $item['name'] }}：{!! $item['percent'] !!}%</div>
                        </div>
                    </a>
                </div>
            @endforeach
            </div>
        </div>
    </div>
@endsection

{{--尾部前端资源--}}
@section('script')
<script src="{{ asset('vendor/amcharts/amcharts.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/amcharts/serial.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/amcharts/pie.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/amcharts/radar.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/amcharts/themes/light.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/amcharts/themes/patterns.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/amcharts/themes/chalk.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/ammap/ammap.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/ammap/maps/js/worldLow.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/amstockcharts/amstock.js') }}" type="text/javascript"></script>

<script src="{{asset('vendor/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
<script src="{{asset('vendor/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
<script>
    var data = '{!! $chartData !!}';
    //转成json对象
    var dataobkect = JSON.parse(data);
</script>
<script src="{{ asset('assets/admin/logs/scripts/logs-charts.js') }}" type="text/javascript"></script>
@endsection