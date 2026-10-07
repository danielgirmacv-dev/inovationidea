<?php

namespace App\Services;

use App\Models\IdeaSubmission;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportService
{
    /**
     * Export filtered submissions to a CSV streamed response.
     */
    public function exportCsv(array $filters = []): StreamedResponse
    {
        $query = $this->buildFilteredQuery($filters);

        $filename = 'eec-ideas-export-'.now()->format('Y-m-d-His').'.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM for Excel compatibility
            fwrite($handle, "\xEF\xBB\xBF");

            // Header row
            fputcsv($handle, [
                'Reference Number',
                'Submission Date',
                'Status',
                'Submitter Name',
                'Job Title',
                'Department',
                'Site',
                'Email',
                'Phone',
                'Idea Title',
                'Categories',
                'Brief Description',
                'Problem Addressed',
                'Company Benefits',
                'Risks & Challenges',
                'Supporting Links',
                'Assigned Reviewer',
                'Submitted At',
            ]);

            // Stream rows in chunks to avoid memory issues
            $query->with(['categories', 'assignedReviewer'])->chunk(100, function ($submissions) use ($handle) {
                foreach ($submissions as $sub) {
                    fputcsv($handle, [
                        $sub->reference_number,
                        $sub->submission_date?->format('Y-m-d'),
                        $sub->status,
                        $sub->submitter_name,
                        $sub->submitter_job_title,
                        $sub->submitter_department,
                        $sub->submitter_site,
                        $sub->submitter_email,
                        $sub->submitter_phone,
                        $sub->title,
                        $sub->categories->pluck('name')->implode('; '),
                        strip_tags($sub->description),
                        strip_tags($sub->problem_addressed),
                        strip_tags($sub->company_benefits),
                        strip_tags($sub->risks_challenges),
                        is_array($sub->supporting_links) ? implode(', ', $sub->supporting_links) : $sub->supporting_links,
                        $sub->assignedReviewer?->name,
                        $sub->created_at?->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    private function buildFilteredQuery(array $filters): Builder
    {
        $query = IdeaSubmission::query();

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['department'])) {
            $query->where('submitter_department', $filters['department']);
        }

        if (! empty($filters['site'])) {
            $query->where('submitter_site', $filters['site']);
        }

        if (! empty($filters['category'])) {
            $query->whereHas('categories', fn ($q) => $q->where('idea_categories.id', $filters['category']));
        }

        if (! empty($filters['date_from'])) {
            $query->where('submission_date', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->where('submission_date', '<=', $filters['date_to']);
        }

        if (! empty($filters['search'])) {
            $query->search($filters['search']);
        }

        return $query->latest();
    }
}
