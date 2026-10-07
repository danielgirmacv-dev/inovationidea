<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaSubmissionRequest;
use App\Models\IdeaCategory;
use App\Models\IdeaSubmission;
use App\Services\IdeaSubmissionService;
use Illuminate\Http\Request;

class IdeaSubmissionController extends Controller
{
    public function __construct(private readonly IdeaSubmissionService $service) {}

    /**
     * Public landing / submission form.
     */
    public function create()
    {
        $categories = IdeaCategory::active()->get();

        $departments = [
            'Civil Engineering',
            'Water & Energy Works',
            'Transport Infrastructure',
            'Procurement & Logistics',
            'Quality & Safety Control',
            'ICT & Digitalization',
            'Finance & Administration',
            'Human Resources',
            'Legal & Compliance',
            'Project Management',
            'Other',
        ];

        $sites = [
            'Head Office - Addis Ababa',
            'GERD Project Site',
            'Koysha Hydroelectric Project',
            'Modjo Logistics Hub',
            'Awash Depot',
            'Dire Dawa Branch',
            'Hawassa Branch',
            'Bahir Dar Branch',
            'Mekelle Branch',
            'Other',
        ];

        return view('submissions.create', compact('categories', 'departments', 'sites'));
    }

    /**
     * Store the new submission.
     */
    public function store(StoreIdeaSubmissionRequest $request)
    {
        $data = $request->safe()->except(['categories', 'attachments', 'custom_category']);

        // Parse supporting links from newline-separated text
        if ($request->filled('supporting_links')) {
            $links = array_filter(
                array_map('trim', preg_split('/[\n,]+/', $request->supporting_links))
            );
            $data['supporting_links'] = array_values($links);
        }

        $submission = $this->service->createSubmission(
            data: $data,
            categoryIds: $request->input('categories', []),
            uploadedFiles: $request->file('attachments', []),
            userId: auth()->id(),
        );

        return redirect()->route('submissions.confirmation', $submission->reference_number);
    }

    /**
     * Submission confirmation / success page.
     */
    public function confirmation(string $referenceNumber)
    {
        $submission = IdeaSubmission::where('reference_number', $referenceNumber)
            ->with(['categories'])
            ->firstOrFail();

        return view('submissions.confirmation', compact('submission'));
    }

    /**
     * Public status tracking page.
     */
    public function track(Request $request)
    {
        $submission = null;

        if ($request->filled('ref')) {
            $submission = IdeaSubmission::where('reference_number', strtoupper($request->ref))
                ->with(['categories', 'publicComments', 'statusHistory'])
                ->first();
        }

        return view('submissions.track', compact('submission'));
    }
}
