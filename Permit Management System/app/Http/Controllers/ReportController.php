<?php

namespace App\Http\Controllers;

use App\Models\Studentpermit;
use App\Models\Workpermit;
use App\Models\Reject;
use Illuminate\Http\Request;
use Carbon\Carbon;
use ConsoleTVs\Charts\Classes\Highcharts\Chart;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function generate(Request $request)
    {
        $query = Studentpermit::query();

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        if ($request->filled('institution')) {
            $query->where('institution', 'like', '%' . $request->institution . '%');
        }

        if ($request->filled('course')) {
            $query->where('course', 'like', '%' . $request->course . '%');
        }

        if ($request->filled('nationality')) {
            $query->where('nationality', 'like', '%' . $request->nationality . '%');
        }

        $results = $query->get();
        $total = $results->count();

        return view('reports.result', compact('results', 'total'));
    }

    public function generateCharts()
    {
        // Monthly Applications Chart
        $monthlyData = Studentpermit::selectRaw('COUNT(*) as count, MONTH(created_at) as month')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyChart = new Chart;
        $monthlyChart->title('Monthly Applications');
        $monthlyChart->labels($monthlyData->pluck('month')->map(fn($m) => Carbon::create()->month($m)->format('F'))->toArray());
        $monthlyChart->dataset('Applications', 'line', $monthlyData->pluck('count')->toArray());

        // Status Distribution Chart
        $statusData = Studentpermit::selectRaw('COUNT(*) as count, status')
            ->groupBy('status')
            ->get();

        $statusChart = new Chart;
        $statusChart->title('Application Status Distribution');
        $statusChart->labels($statusData->pluck('status')->toArray());
        $statusChart->dataset('Status', 'pie', $statusData->pluck('count')->toArray());

        // Top Institutions Chart
        $institutionData = Studentpermit::selectRaw('COUNT(*) as count, institution')
            ->groupBy('institution')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        $institutionChart = new Chart;
        $institutionChart->title('Top 10 Institutions');
        $institutionChart->labels($institutionData->pluck('institution')->toArray());
        $institutionChart->dataset('Applications', 'bar', $institutionData->pluck('count')->toArray());

        return view('reports.charts', compact('monthlyChart', 'statusChart', 'institutionChart'));
    }

    public function compare(Request $request)
    {
        $type = $request->type;
        $chart = new Chart;

        return match ($type) {
            'universities' => $this->compareUniversities($chart),
            'permit_status' => $this->comparePermitStatus($chart),
            'permit_types' => $this->comparePermitTypes($chart),
            'nationalities' => $this->compareNationalities($chart),
            'rejection_reasons' => $this->compareRejectionReasons($chart),
            default => redirect()->route('reports.index')->with('error', 'Invalid comparison type selected'),
        };
    }

    private function compareUniversities(Chart $chart)
    {
        $data = Studentpermit::selectRaw('COUNT(*) as count, institution')
            ->groupBy('institution')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        $chart->title('Top 10 Universities by Applications');
        $chart->labels($data->pluck('institution')->toArray());
        $chart->dataset('Applications', 'bar', $data->pluck('count')->toArray());

        return view('reports.comparison', [
            'chart' => $chart,
            'title' => 'University Applications Comparison',
        ]);
    }

    private function comparePermitStatus(Chart $chart)
    {
        $data = Studentpermit::selectRaw('COUNT(*) as count, status')
            ->whereYear('created_at', now()->year)
            ->groupBy('status')
            ->get();

        $chart->title('Permit Status Distribution (Current Year)');
        $chart->labels($data->pluck('status')->toArray());
        $chart->dataset('Status', 'pie', $data->pluck('count')->toArray());

        return view('reports.comparison', [
            'chart' => $chart,
            'title' => 'Permit Status Analysis',
        ]);
    }

    private function comparePermitTypes(Chart $chart)
    {
        $studentCount = Studentpermit::count();
        $workCount = Workpermit::count();

        $chart->title('Student vs Work Permits');
        $chart->labels(['Student Permits', 'Work Permits']);
        $chart->dataset('Permits', 'pie', [$studentCount, $workCount]);

        return view('reports.comparison', [
            'chart' => $chart,
            'title' => 'Permit Types Comparison',
        ]);
    }

    private function compareNationalities(Chart $chart)
    {
        $data = Studentpermit::selectRaw('COUNT(*) as count, nationality')
            ->groupBy('nationality')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $chart->title('Top 5 Nationalities');
        $chart->labels($data->pluck('nationality')->toArray());
        $chart->dataset('Applications', 'bar', $data->pluck('count')->toArray());

        return view('reports.comparison', [
            'chart' => $chart,
            'title' => 'Top Nationalities Analysis',
        ]);
    }

    private function compareRejectionReasons(Chart $chart)
    {
        $data = Reject::selectRaw('COUNT(*) as count, reason')
            ->groupBy('reason')
            ->orderByDesc('count')
            ->get();

        $chart->title('Common Rejection Reasons');
        $chart->labels($data->pluck('reason')->toArray());
        $chart->dataset('Rejections', 'bar', $data->pluck('count')->toArray());

        return view('reports.comparison', [
            'chart' => $chart,
            'title' => 'Rejection Reasons Analysis',
        ]);
    }

    public function showCustomComparisonForm()
{
    return view('reports.custom_comparison_form', [
        'parameter1' => null,
        'parameter2' => null,
        'chart' => null
    ]);
}

    public function compareCustom(Request $request)
    {
        $parameter1 = $request->input('parameter1');
        $parameter2 = $request->input('parameter2');

        $validParams = ['status', 'institution', 'course', 'nationality'];

        if (!in_array($parameter1, $validParams) || !in_array($parameter2, $validParams)) {
            return redirect()->route('reports.index')->with('error', 'Invalid parameters selected!');
        }

        $data1 = Studentpermit::selectRaw("COUNT(*) as count, {$parameter1}")
            ->groupBy($parameter1)
            ->get();

        $data2 = Studentpermit::selectRaw("COUNT(*) as count, {$parameter2}")
            ->groupBy($parameter2)
            ->get();

        $chart = new Chart;
        $chart->title("Custom Comparison: {$parameter1} vs {$parameter2}");
        $chart->labels($data1->pluck($parameter1)->toArray());
        $chart->dataset("Comparison", 'bar', $data2->pluck('count')->toArray());

        return view('reports.custom_comparison', compact('chart', 'parameter1', 'parameter2'));
    }
}
