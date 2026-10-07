<?php

namespace App\Services;

use App\Models\IdeaSubmission;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Get KPI summary counts for the dashboard cards.
     */
    public function getKpiMetrics(): array
    {
        $counts = IdeaSubmission::query()
            ->selectRaw("COUNT(*) as total,
                SUM(status = 'Submitted') as submitted,
                SUM(status = 'Under Review') as under_review,
                SUM(status = 'Need More Information') as need_info,
                SUM(status = 'Approved') as approved,
                SUM(status = 'Rejected') as rejected,
                SUM(status = 'Implemented') as implemented")
            ->first();

        return [
            'total' => (int) $counts->total,
            'submitted' => (int) $counts->submitted,
            'under_review' => (int) $counts->under_review,
            'need_info' => (int) $counts->need_info,
            'approved' => (int) $counts->approved,
            'rejected' => (int) $counts->rejected,
            'implemented' => (int) $counts->implemented,
        ];
    }

    /**
     * Ideas grouped by department (top 8).
     */
    /**
     * Ideas grouped by department (top 8).
     */
    public function getIdeasByDepartment()
    {
        return IdeaSubmission::query()
            ->selectRaw('submitter_department, COUNT(*) as count')
            ->whereNotNull('submitter_department')
            ->groupBy('submitter_department')
            ->orderByDesc('count')
            ->limit(8)
            ->get();
    }

    /**
     * Ideas grouped by category.
     */
    public function getIdeasByCategory()
    {
        return DB::table('idea_submission_categories as isc')
            ->join('idea_categories as ic', 'ic.id', '=', 'isc.idea_category_id')
            ->selectRaw('ic.name as name, COUNT(*) as submissions_count')
            ->groupBy('ic.id', 'ic.name')
            ->orderByDesc('submissions_count')
            ->get();
    }

    /**
     * Monthly submission trend for the current year.
     */
    public function getMonthlyTrend(): Collection
    {
        $year = now()->year;

        $driver = DB::getDriverName();
        $monthExpr = $driver === 'sqlite' ? "CAST(strftime('%m', submission_date) AS INTEGER)" : 'MONTH(submission_date)';

        $rows = IdeaSubmission::query()
            ->selectRaw("{$monthExpr} as month, COUNT(*) as count")
            ->whereYear('submission_date', $year)
            ->groupByRaw($monthExpr)
            ->orderByRaw($monthExpr)
            ->get()
            ->keyBy('month');

        $result = collect();
        for ($m = 1; $m <= 12; $m++) {
            $monthName = now()->month($m)->format('M');
            $result->put($monthName, (int) ($rows[$m]->count ?? 0));
        }

        return $result;
    }

    /**
     * Ideas grouped by status for pie/donut chart.
     */
    public function getIdeasByStatus(): Collection
    {
        return IdeaSubmission::query()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');
    }

    /**
     * Recent submissions for dashboard table.
     */
    public function getRecentSubmissions(int $limit = 8): \Illuminate\Database\Eloquent\Collection
    {
        return IdeaSubmission::with(['categories'])
            ->latest()
            ->limit($limit)
            ->get();
    }
}
