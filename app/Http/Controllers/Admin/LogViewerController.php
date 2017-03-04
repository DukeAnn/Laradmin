<?php
/**
 * 日志查看 只支持日志类型为daily
 * */
namespace App\Http\Controllers\Admin;

use Arcanedev\LogViewer\Contracts\LogViewer as LogViewerContract;
use Arcanedev\LogViewer\Exceptions\LogNotFoundException;
use Arcanedev\LogViewer\Tables\StatsTable;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;

class LogViewerController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The log viewer instance
     *
     * @var \Arcanedev\LogViewer\Contracts\LogViewer
     */
    protected $logViewer;

    /** @var int */
    protected $perPage = 30;

    /** @var string */
    protected $showRoute = 'log.show';

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * LogViewerController constructor.
     *
     * @param  \Arcanedev\LogViewer\Contracts\LogViewer  $logViewer
     */
    public function __construct(LogViewerContract $logViewer)
    {
        $this->logViewer = $logViewer;
        $this->perPage = config('log-viewer.per-page', $this->perPage);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Show the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stats     = $this->logViewer->statsTable();
        $chartData = $this->prepareChartData($stats);
        $percents  = $this->calcPercentages($stats->footer(), $stats->header());

        return view('admin.logs.dashboard', compact('chartData', 'percents'));
    }

    /**
     * List all logs.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\View\View
     */
    public function listLogs(Request $request)
    {
        $stats   = $this->logViewer->statsTable();
        $headers = $stats->header();
        $rows    = $this->paginate($stats->rows(), $request);

        return view('admin.logs.list', compact('headers', 'rows', 'footer'));
    }

    /**
     * Show the log.
     *
     * @param  string  $date
     *
     * @return \Illuminate\View\View
     */
    public function show($date)
    {
        $log     = $this->getLogOrFail($date);
        $levels  = $this->logViewer->levelsNames();
        $entries = $log->entries()->paginate($this->perPage);

        return view('admin.logs.show', compact('log', 'levels', 'entries'));
    }

    /**
     * Filter the log entries by level.
     *
     * @param  string  $date
     * @param  string  $level
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showByLevel($date, $level)
    {
        $log = $this->getLogOrFail($date);
        if ($level === 'all')
            return redirect()->route($this->showRoute, [$date]);

        $levels  = $this->logViewer->levelsNames();
        $entries = $this->logViewer
            ->entries($date, $level)
            ->paginate($this->perPage);

        return view('admin.logs.show', compact('log', 'levels', 'entries'));
    }

    /**
     * Download the log
     *
     * @param  string  $date
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($date)
    {
        return $this->logViewer->download($date);
    }

    /**
     * Delete a log.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        if ( ! $request->ajax())
            abort(405, 'Method Not Allowed');
        $date = $request->get('date');
        return response()->json([
            'result' => $this->logViewer->delete($date) ? 'success' : 'error'
        ]);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string  $view
     * @param  array   $data
     * @param  array   $mergeData
     *
     * @return \Illuminate\View\View
     */
    protected function view($view, $data = [], $mergeData = [])
    {
        return view('log-viewer::'.$view, $data, $mergeData);
    }

    /**
     * Paginate logs.
     *
     * @param  array                     $data
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function paginate(array $data, Request $request)
    {
        $data = collect($data);
        $page = $request->get('page', 1);
        $url  = $request->url();

        return new LengthAwarePaginator(
            $data->forPage($page, $this->perPage),
            $data->count(),
            $this->perPage,
            $page,
            compact('url')
        );
    }

    /**
     * Get a log or fail
     *
     * @param  string  $date
     *
     * @return \Arcanedev\LogViewer\Entities\Log|null
     */
    protected function getLogOrFail($date)
    {
        $log = null;

        try {
            $log = $this->logViewer->get($date);
        }
        catch (LogNotFoundException $e) {
            abort(404, $e->getMessage());
        }

        return $log;
    }

    /**
     * Prepare chart data.
     * 修改数据结构
     * @param  \Arcanedev\LogViewer\Tables\StatsTable  $stats
     *
     * @return string
     */
    protected function prepareChartData(StatsTable $stats)
    {
        $totals = $stats->totals('zh')->all();
        $k = 0;
        foreach ($totals as $key => $value) {
            $arr[$k]['log_level'] = $value['label'];
            $arr[$k]['litres'] = $value['value'];
            $k++;
        }
        if (empty($arr)) {
            $arr[0] = [
                'log_level' => '无日志',
                'litres' => '1',
            ];
        }
        return json_encode($arr);
    }

    /**
     * Calculate the percentage.
     *
     * @param  array  $total
     * @param  array  $names
     *
     * @return array
     */
    protected function calcPercentages(array $total, array $names)
    {
        $percents = [];
        $all      = Arr::get($total, 'all');

        foreach ($total as $level => $count) {
            $percents[$level] = [
                'name'    => $names[$level],
                'count'   => $count,
                'percent' => $all ? round(($count / $all) * 100, 2) : 0,
            ];
        }

        return $percents;
    }
}
