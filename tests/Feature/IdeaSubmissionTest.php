<?php

namespace Tests\Feature;

use App\Models\IdeaCategory;
use App\Models\IdeaSubmission;
use App\Models\User;
use Database\Seeders\CategorySeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IdeaSubmissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([
            CategorySeeder::class,
            UserSeeder::class,
        ]);
    }

    public function test_public_submission_page_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Innovative Idea Submission Form');
        $response->assertSee('Ethiopian Engineering Corporation');
    }

    public function test_can_submit_innovative_idea(): void
    {
        $category = IdeaCategory::first();

        $postData = [
            'submitter_name' => 'Almaz Ayana',
            'submitter_job_title' => 'Hydrology Engineer',
            'submitter_department' => 'Water & Energy Works',
            'submitter_site' => 'GERD Project Site',
            'submitter_email' => 'almaz.a@eec.com.et',
            'submitter_phone' => '+251912345678',
            'title' => 'Solar-Powered Automated Silt Gauge Telemetry',
            'description' => 'Real-time telemetry sensors installed along reservoir siltation points reporting live via GSM network to head office.',
            'categories' => [$category->id],
            'problem_addressed' => 'Manual silt sounding boats cannot navigate turbulent seasonal floods safely.',
            'company_benefits' => 'Prevents turbine abrasion damage, optimizes sediment flushing schedules, and saves field operational expenditures.',
            'risks_challenges' => 'Solar panel fouling in arid desert zones requiring self-cleaning wiper seals.',
            'submission_date' => now()->toDateString(),
        ];

        $response = $this->post('/submit', $postData);

        $this->assertDatabaseHas('idea_submissions', [
            'submitter_name' => 'Almaz Ayana',
            'title' => 'Solar-Powered Automated Silt Gauge Telemetry',
        ]);

        $submission = IdeaSubmission::where('submitter_name', 'Almaz Ayana')->first();
        $response->assertRedirect(route('submissions.confirmation', $submission->reference_number));
    }

    public function test_public_can_track_submission_by_reference_number(): void
    {
        $category = IdeaCategory::first();
        $submission = IdeaSubmission::create([
            'reference_number' => 'EEC-IDEA-2026-TEST1',
            'submitter_name' => 'Test Submitter',
            'submitter_phone' => '+251911111111',
            'title' => 'Test Idea For Tracking',
            'description' => 'This is a test description that meets the minimum length requirement for submission.',
            'problem_addressed' => 'Problem statement meeting length requirements.',
            'company_benefits' => 'Benefit statement meeting length requirements.',
            'risks_challenges' => 'Risks and challenges meeting length requirements.',
            'submission_date' => now()->toDateString(),
            'status' => IdeaSubmission::STATUS_UNDER_REVIEW,
        ]);
        $submission->categories()->sync([$category->id]);

        $response = $this->get('/track?ref=EEC-IDEA-2026-TEST1');
        $response->assertStatus(200);
        $response->assertSee('EEC-IDEA-2026-TEST1');
        $response->assertSee('Test Idea For Tracking');
        $response->assertSee('Under Review');
    }

    public function test_admin_can_access_dashboard_and_review_submissions(): void
    {
        $admin = User::where('email', 'admin@eec.com.et')->first();

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Executive Innovation Dashboard');

        $submissionsResponse = $this->actingAs($admin)->get('/admin/submissions');
        $submissionsResponse->assertStatus(200);
        $submissionsResponse->assertSee('Idea Submissions Review Queue');
    }

    public function test_admin_can_view_submission_details(): void
    {
        $admin = User::where('email', 'admin@eec.com.et')->first();
        $category = IdeaCategory::first();

        $submission = IdeaSubmission::create([
            'reference_number' => 'EEC-IDEA-2026-DETAIL',
            'submitter_name' => 'Sara Mengistu',
            'submitter_phone' => '+251922222222',
            'title' => 'Geothermal Heat Recovery in Tunnel Construction',
            'description' => 'A comprehensive engineering system capturing geothermal steam during deep excavation to power ventilation fans.',
            'problem_addressed' => 'Excess heat causes equipment failure and hazardous working environments underground.',
            'company_benefits' => 'Lowers auxiliary diesel consumption by 40% while ensuring ambient air compliance for workers.',
            'risks_challenges' => 'High acidity of geothermal condensate requires corrosion-resistant alloy piping.',
            'submission_date' => now()->toDateString(),
            'status' => IdeaSubmission::STATUS_SUBMITTED,
        ]);
        $submission->categories()->sync([$category->id]);

        $response = $this->actingAs($admin)->get(route('admin.submissions.show', $submission->id));
        $response->assertStatus(200);
        $response->assertSee('EEC-IDEA-2026-DETAIL');
        $response->assertSee('Sara Mengistu');
        $response->assertSee('Geothermal Heat Recovery in Tunnel Construction');
    }

    public function test_admin_can_update_submission_status(): void
    {
        $admin = User::where('email', 'admin@eec.com.et')->first();

        $submission = IdeaSubmission::create([
            'reference_number' => 'EEC-IDEA-2026-STAT',
            'submitter_name' => 'Dawit Kebede',
            'submitter_phone' => '+251933333333',
            'title' => 'AI Automated Crack Detection on Concrete Dams',
            'description' => 'Drone imagery combined with computer vision segmentation models to detect micro-fissures automatically.',
            'problem_addressed' => 'Manual abseiling inspections miss micro-fissures and introduce serious fall hazards.',
            'company_benefits' => 'Increases structural safety margins and cuts inspection times from weeks to hours.',
            'risks_challenges' => 'Adverse weather conditions and GPS loss beneath curved spillway overhangs.',
            'submission_date' => now()->toDateString(),
            'status' => IdeaSubmission::STATUS_SUBMITTED,
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.submissions.update-status', $submission->id), [
            'status' => IdeaSubmission::STATUS_UNDER_REVIEW,
            'remarks' => 'Assigned to the Structural Integrity Panel for technical feasibility assessment.',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('idea_submissions', [
            'id' => $submission->id,
            'status' => IdeaSubmission::STATUS_UNDER_REVIEW,
        ]);
        $this->assertDatabaseHas('idea_status_history', [
            'idea_submission_id' => $submission->id,
            'to_status' => IdeaSubmission::STATUS_UNDER_REVIEW,
            'remarks' => 'Assigned to the Structural Integrity Panel for technical feasibility assessment.',
        ]);
    }

    public function test_admin_can_export_submissions_csv(): void
    {
        $admin = User::where('email', 'admin@eec.com.et')->first();

        $response = $this->actingAs($admin)->get(route('admin.submissions.export'));
        $response->assertStatus(200);
        $this->assertTrue(str_contains($response->headers->get('content-type', ''), 'text/csv'));
    }
}
