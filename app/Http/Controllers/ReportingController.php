<?php

namespace App\Http\Controllers;

use App\Services\ReportingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportingController extends Controller
{
    protected $reportingService;

    public function __construct(ReportingService $reportingService)
    {
        $this->reportingService = $reportingService;
    }

    /**
     * Display hotel operator dashboard
     */
    public function hotelOperator(Request $request)
    {
        $user = Auth::user();

        if (! $user->isHotelOperator() && ! $user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $period = $request->get('period', 'month');
        $stats = $this->reportingService->getHotelOperatorStats($user->id, $period);
        $trends = $this->reportingService->getBookingTrends('hotels', $period);

        return view('reporting.hotel-operator', compact('stats', 'trends', 'period'));
    }

    /**
     * Display ferry operator dashboard
     */
    public function ferryOperator(Request $request)
    {
        $user = Auth::user();

        if (! $user->isFerryOperator() && ! $user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $period = $request->get('period', 'month');
        $stats = $this->reportingService->getFerryOperatorStats($user->id, $period);
        $trends = $this->reportingService->getBookingTrends('ferry', $period);

        return view('reporting.ferry-operator', compact('stats', 'trends', 'period'));
    }

    /**
     * Display theme park operator dashboard
     */
    public function themeParkOperator(Request $request)
    {
        $user = Auth::user();

        if (! $user->isParkOperator() && ! $user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $period = $request->get('period', 'month');
        $stats = $this->reportingService->getThemeParkOperatorStats($period);
        $trends = $this->reportingService->getBookingTrends('theme_park', $period);

        return view('reporting.theme-park-operator', compact('stats', 'trends', 'period'));
    }

    /**
     * Display beach organizer dashboard
     */
    public function beachOrganizer(Request $request)
    {
        $user = Auth::user();

        if (! $user->isBeachOrganizer() && ! $user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $period = $request->get('period', 'month');
        $stats = $this->reportingService->getBeachOrganizerStats($user->id, $period);
        $trends = $this->reportingService->getBookingTrends('beach_events', $period);

        return view('reporting.beach-organizer', compact('stats', 'trends', 'period'));
    }

    /**
     * Display system-wide analytics (admin only)
     */
    public function systemWide(Request $request)
    {
        $user = Auth::user();

        if (! $user->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $period = $request->get('period', 'month');
        $stats = $this->reportingService->getSystemWideStats($period);
        $revenue = $this->reportingService->getRevenueReport($period);

        return view('reporting.system-wide', compact('stats', 'revenue', 'period'));
    }

    /**
     * Export report data
     */
    public function export(Request $request, string $type)
    {
        $user = Auth::user();
        $period = $request->get('period', 'month');

        // Check authorization based on report type
        switch ($type) {
            case 'hotel':
                if (! $user->isHotelOperator() && ! $user->isAdmin()) {
                    abort(403, 'Unauthorized access.');
                }
                break;
            case 'ferry':
                if (! $user->isFerryOperator() && ! $user->isAdmin()) {
                    abort(403, 'Unauthorized access.');
                }
                break;
            case 'theme_park':
                if (! $user->isParkOperator() && ! $user->isAdmin()) {
                    abort(403, 'Unauthorized access.');
                }
                break;
            case 'beach_events':
                if (! $user->isBeachOrganizer() && ! $user->isAdmin()) {
                    abort(403, 'Unauthorized access.');
                }
                break;
            case 'system':
                if (! $user->isAdmin()) {
                    abort(403, 'Unauthorized access.');
                }
                break;
            default:
                abort(400, 'Invalid report type.');
        }

        $format = $request->get('format', 'csv');

        // Generate report data
        $data = $this->generateReportData($type, $period);

        // Export based on format
        return $this->exportReport($data, $type, $period, $format);
    }

    /**
     * Generate report data based on type
     */
    private function generateReportData(string $type, string $period): array
    {
        switch ($type) {
            case 'hotel':
                return $this->reportingService->getHotelOperatorStats(Auth::id(), $period);
            case 'ferry':
                return $this->reportingService->getFerryOperatorStats(Auth::id(), $period);
            case 'theme_park':
                return $this->reportingService->getThemeParkOperatorStats($period);
            case 'beach_events':
                return $this->reportingService->getBeachOrganizerStats(Auth::id(), $period);
            case 'system':
                return $this->reportingService->getSystemWideStats($period);
            default:
                return [];
        }
    }

    /**
     * Export report in specified format
     */
    private function exportReport(array $data, string $type, string $period, string $format)
    {
        $filename = "{$type}_report_{$period}_".now()->format('Y-m-d_H-i-s');

        switch ($format) {
            case 'csv':
                return $this->exportCsv($data, $filename);
            case 'json':
                return $this->exportJson($data, $filename);
            case 'pdf':
                return $this->exportPdf($data, $filename);
            default:
                abort(400, 'Unsupported export format.');
        }
    }

    /**
     * Export as CSV
     */
    private function exportCsv(array $data, string $filename)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // Add headers
            fputcsv($file, array_keys($data));

            // Add data
            fputcsv($file, array_values($data));

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export as JSON
     */
    private function exportJson(array $data, string $filename)
    {
        return response()->json($data)
            ->header('Content-Disposition', "attachment; filename=\"{$filename}.json\"");
    }

    /**
     * Export as PDF (placeholder - would need a PDF library)
     */
    private function exportPdf(array $data, string $filename)
    {
        // This would typically use a library like DomPDF or Snappy
        // For now, we'll return a simple text response
        return response($this->generatePdfContent($data))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}.pdf\"");
    }

    /**
     * Generate simple PDF content (placeholder)
     */
    private function generatePdfContent(array $data): string
    {
        $content = 'Report Generated: '.now()->format('Y-m-d H:i:s')."\n\n";

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $content .= ucfirst(str_replace('_', ' ', $key)).":\n";
                foreach ($value as $subKey => $subValue) {
                    $content .= '  '.ucfirst(str_replace('_', ' ', $subKey)).': '.$subValue."\n";
                }
            } else {
                $content .= ucfirst(str_replace('_', ' ', $key)).': '.$value."\n";
            }
        }

        return $content;
    }
}
