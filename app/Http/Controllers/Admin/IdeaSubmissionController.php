<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreIdeaCommentRequest;
use App\Http\Requests\Admin\UpdateIdeaStatusRequest;
use App\Models\IdeaCategory;
use App\Models\IdeaComment;
use App\Models\IdeaSubmission;
use App\Models\User;
use App\Services\ExportService;
use App\Services\IdeaSubmissionService;
use Illuminate\Http\Request;

class IdeaSubmissionController extends Controller
{
    public function __construct(
        private readonly IdeaSubmissionService $service,
        private readonly ExportService $exportService,
    ) {}

    /**
     * Admin submissions index with search, filters, and pagination.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', IdeaSubmission::class);

        $query = IdeaSubmission::with(['categories', 'assignedReviewer']);

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filters
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('department')) {
            $query->byDepartment($request->department);
        }

        if ($request->filled('site')) {
            $query->bySite($request->site);
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', fn ($q) => $q->where('idea_categories.id', $request->category));
        }

        if ($request->filled('date_from')) {
            $query->where('submission_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('submission_date', '<=', $request->date_to);
        }

        $submissions = $query->latest()->paginate(15)->withQueryString();

        $categories = IdeaCategory::active()->get();
        $statuses = array_keys(IdeaSubmission::STATUSES);

        $departments = IdeaSubmission::distinct()->pluck('submitter_department')->filter()->sort()->values();
        $sites = IdeaSubmission::distinct()->pluck('submitter_site')->filter()->sort()->values();

        return view('admin.submissions.index', compact(
            'submissions',
            'categories',
            'statuses',
            'departments',
            'sites'
        ));
    }

    /**
     * Admin idea details page.
     */
    public function show(IdeaSubmission $submission)
    {
        $this->authorize('view', $submission);

        $submission->load([
            'categories',
            'attachments',
            'comments.user',
            'statusHistory.user',
            'assignedReviewer',
            'user',
        ]);

        $reviewers = User::reviewers()->get();
        $statuses = array_keys(IdeaSubmission::STATUSES);

        return view('admin.submissions.show', compact('submission', 'reviewers', 'statuses'));
    }

    /**
     * Update status of a submission.
     */
    public function updateStatus(UpdateIdeaStatusRequest $request, IdeaSubmission $submission)
    {
        $this->authorize('updateStatus', $submission);

        try {
            $this->service->transitionStatus(
                submission: $submission,
                newStatus: $request->status,
                remarks: $request->remarks,
                actorUserId: auth()->id(),
            );

            return back()->with('success', "Status updated to \"{$request->status}\" successfully.");
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update status: '.$e->getMessage())->withInput();
        }
    }

    /**
     * Assign a reviewer.
     */
    public function assignReviewer(Request $request, IdeaSubmission $submission)
    {
        $this->authorize('assignReviewer', $submission);

        $request->validate([
            'reviewer_id' => ['required', 'exists:users,id'],
        ]);

        $this->service->assignReviewer(
            submission: $submission,
            reviewerId: $request->reviewer_id,
            actorUserId: auth()->id(),
        );

        return back()->with('success', 'Reviewer assigned successfully.');
    }

    /**
     * Add a comment to a submission.
     */
    public function addComment(StoreIdeaCommentRequest $request, IdeaSubmission $submission)
    {
        $this->authorize('addComment', $submission);

        IdeaComment::create([
            'idea_submission_id' => $submission->id,
            'user_id' => auth()->id(),
            'comment' => $request->comment,
            'is_internal' => $request->boolean('is_internal'),
        ]);

        return back()->with('success', 'Comment added successfully.');
    }

    /**
     * Export filtered submissions to CSV.
     */
    public function export(Request $request)
    {
        $this->authorize('export', IdeaSubmission::class);

        return $this->exportService->exportCsv($request->only([
            'status', 'department', 'site', 'category', 'date_from', 'date_to', 'search',
        ]));
    }

    /**
     * Delete a submission (soft delete).
     */
    public function destroy(IdeaSubmission $submission)
    {
        $this->authorize('delete', $submission);

        $submission->delete();

        return redirect()->route('admin.submissions.index')
            ->with('success', "Submission {$submission->reference_number} has been deleted.");
    }
}
