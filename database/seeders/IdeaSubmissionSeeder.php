<?php

namespace Database\Seeders;

use App\Models\IdeaCategory;
use App\Models\IdeaComment;
use App\Models\IdeaStatusHistory;
use App\Models\IdeaSubmission;
use App\Models\User;
use Illuminate\Database\Seeder;

class IdeaSubmissionSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@eec.com.et')->first();
        $reviewer1 = User::where('email', 'reviewer@eec.com.et')->first();
        $reviewer2 = User::where('email', 'bethlehem@eec.com.et')->first();

        $catProcess = IdeaCategory::where('name', 'Process Improvement')->first();
        $catCost = IdeaCategory::where('name', 'Cost-Saving')->first();
        $catQuality = IdeaCategory::where('name', 'Quality Improvement')->first();
        $catSafety = IdeaCategory::where('name', 'Safety Improvement')->first();
        $catTech = IdeaCategory::where('name', 'New Technology or Digitalization')->first();
        $catClient = IdeaCategory::where('name', 'Client Experience Enhancements')->first();
        $catSustainability = IdeaCategory::where('name', 'Sustainability & Environment')->first();
        $catBusiness = IdeaCategory::where('name', 'New Business Idea')->first();

        $sampleSubmissions = [
            [
                'reference_number' => 'EEC-IDEA-2026-00001',
                'submitter_name' => 'Kenenisa Bekele',
                'submitter_job_title' => 'Structural Design Specialist',
                'submitter_department' => 'Structural & Geotechnical Engineering',
                'submitter_site' => 'Head Office - Addis Ababa',
                'submitter_email' => 'kenenisa.bekele@eec.com.et',
                'submitter_phone' => '+251 91 100 2233',
                'title' => 'AI-Assisted Structural Load Simulation & Automated Bill of Quantities (BoQ)',
                'description' => 'Integrating an AI model with our existing CAD/BIM software to run rapid structural stress tests and automatically synthesize accurate BoQ schedules.',
                'problem_addressed' => 'Manual load calculation cross-checking and BoQ compilation takes 2-3 weeks per mid-scale bridge project, leading to procurement delays and human estimation variance.',
                'company_benefits' => 'Reduces design turnaround by 65%, eliminates over-budgeting variance in concrete/steel quantities, and empowers junior engineers with instant structural validation.',
                'risks_challenges' => 'Requires validation against Ethiopian Building Code Standards (EBCS) and team training on API interfaces.',
                'submission_date' => now()->subDays(25),
                'status' => IdeaSubmission::STATUS_IMPLEMENTED,
                'assigned_reviewer_id' => $reviewer1?->id,
                'approval_notes' => 'Approved by Executive Committee with 200,000 ETB pilot budget.',
                'reviewer_notes' => 'Verified against international FEM benchmarks. Code generation is reliable.',
                'categories' => [$catTech?->id, $catProcess?->id, $catCost?->id],
                'history' => [
                    ['from' => null, 'to' => IdeaSubmission::STATUS_SUBMITTED, 'note' => 'Submission received via portal.'],
                    ['from' => IdeaSubmission::STATUS_SUBMITTED, 'to' => IdeaSubmission::STATUS_UNDER_REVIEW, 'note' => 'Assigned to Alemayehu Tadesse for structural peer check.'],
                    ['from' => IdeaSubmission::STATUS_UNDER_REVIEW, 'to' => IdeaSubmission::STATUS_APPROVED, 'note' => 'Approved by Committee with 200,000 ETB pilot budget.'],
                    ['from' => IdeaSubmission::STATUS_APPROVED, 'to' => IdeaSubmission::STATUS_IMPLEMENTED, 'note' => 'Pilot deployed across Awash and Dire Dawa structural teams.'],
                ],
                'comments' => [
                    ['user' => $reviewer1, 'text' => 'Outstanding technical foundation. The prototype script connects smoothly with SAP2000.', 'internal' => true],
                    ['user' => $admin, 'text' => 'Congratulations Kenenisa! This initiative has been scheduled for showcase at the EEC Annual Executive Summit.', 'internal' => false],
                ],
            ],
            [
                'reference_number' => 'EEC-IDEA-2026-00002',
                'submitter_name' => 'Hanan Mohammed',
                'submitter_job_title' => 'Hydrologist & Irrigation Specialist',
                'submitter_department' => 'Water & Energy Design',
                'submitter_site' => 'Hawassa Regional Office',
                'submitter_email' => 'hanan.m@eec.com.et',
                'submitter_phone' => '+251 92 233 4455',
                'title' => 'Low-Cost IoT Water Flow Sensors for Gravity-Fed Irrigation Schemes',
                'description' => 'Deploying low-cost solar-powered ultrasonic flow sensors along main canals to transmit real-time telemetry over GSM to the central EEC dashboard.',
                'problem_addressed' => 'Field inspectors travel hundreds of kilometers weekly across Southern region sites just to record manual staff gauge readings, with significant data lag.',
                'company_benefits' => 'Saves an estimated 1.8M ETB annually in vehicle fuel and field allowances while providing minute-by-minute water distribution accountability.',
                'risks_challenges' => 'Sensor vandalism and seasonal silt deposition requiring protective casing.',
                'submission_date' => now()->subDays(18),
                'status' => IdeaSubmission::STATUS_APPROVED,
                'assigned_reviewer_id' => $reviewer2?->id,
                'approval_notes' => 'Hardware procurement endorsed. Project pilot start scheduled for next month.',
                'reviewer_notes' => 'Prototype architecture is sound and works well with our telemetry database.',
                'categories' => [$catTech?->id, $catSustainability?->id, $catCost?->id],
                'history' => [
                    ['from' => null, 'to' => IdeaSubmission::STATUS_SUBMITTED, 'note' => 'Idea submitted via online portal.'],
                    ['from' => IdeaSubmission::STATUS_SUBMITTED, 'to' => IdeaSubmission::STATUS_UNDER_REVIEW, 'note' => 'Forwarded to Digital Transformation review panel.'],
                    ['from' => IdeaSubmission::STATUS_UNDER_REVIEW, 'to' => IdeaSubmission::STATUS_APPROVED, 'note' => 'Endorsed for hardware procurement pilot.'],
                ],
                'comments' => [
                    ['user' => $reviewer2, 'text' => 'We can leverage our existing LoRaWAN gateway in Hawassa before expanding GSM SIM modules.', 'internal' => true],
                ],
            ],
            [
                'reference_number' => 'EEC-IDEA-2026-00003',
                'submitter_name' => 'Tewodros Kassaye',
                'submitter_job_title' => 'Safety & Environmental Health Inspector',
                'submitter_department' => 'Environmental & Social Safeguards',
                'submitter_site' => 'Gibe III Project Site',
                'submitter_email' => 'tewodros.k@eec.com.et',
                'submitter_phone' => '+251 94 555 6677',
                'title' => 'Digital Near-Miss Incident Reporting via Telegram Bot & Mobile QR Codes',
                'description' => 'Placed weatherproof QR codes at all high-risk construction zones linking to a lightweight Telegram Bot for workers to report safety hazards in under 30 seconds.',
                'problem_addressed' => 'Over 80% of safety near-misses go unrecorded due to cumbersome multi-page paper incident logs requiring English literacy.',
                'company_benefits' => 'Immediate hazard awareness, multilingual prompts in Amharic and Afaan Oromo, expected to drop recordable site incidents by 40%.',
                'risks_challenges' => 'Field staff smartphone accessibility and network deadzones on remote sites.',
                'submission_date' => now()->subDays(12),
                'status' => IdeaSubmission::STATUS_UNDER_REVIEW,
                'assigned_reviewer_id' => $reviewer1?->id,
                'reviewer_notes' => 'Reviewing security and privacy parameters regarding Telegram API data protection.',
                'categories' => [$catSafety?->id, $catProcess?->id],
                'history' => [
                    ['from' => null, 'to' => IdeaSubmission::STATUS_SUBMITTED, 'note' => 'Submission logged.'],
                    ['from' => IdeaSubmission::STATUS_SUBMITTED, 'to' => IdeaSubmission::STATUS_UNDER_REVIEW, 'note' => 'Assigned to Safety & Infrastructure lead.'],
                ],
                'comments' => [
                    ['user' => $reviewer1, 'text' => 'Reviewing security and privacy parameters regarding Telegram API data protection.', 'internal' => true],
                ],
            ],
            [
                'reference_number' => 'EEC-IDEA-2026-00004',
                'submitter_name' => 'Selamawit Girma',
                'submitter_job_title' => 'Senior Procurement Officer',
                'submitter_department' => 'Procurement & Logistics',
                'submitter_site' => 'Head Office - Addis Ababa',
                'submitter_email' => 'selamawit.g@eec.com.et',
                'submitter_phone' => '+251 91 777 8899',
                'title' => 'Centralized Vendor Performance Scoring & Automated Framework Contracts',
                'description' => 'A structured portal to score suppliers on delivery speed, material quality compliance, and price stability to automatically renew top 10% vendors.',
                'problem_addressed' => 'Repeated tendering cycles for standard surveying and soil lab consumables delay project kickoffs by 4 to 8 weeks.',
                'company_benefits' => 'Cuts tendering cycle time by 70% and secures volume rebates saving an estimated 3.2M ETB in FY2026/27.',
                'risks_challenges' => 'Compliance with Public Procurement and Property Authority (FPPA) guidelines.',
                'submission_date' => now()->subDays(4),
                'status' => IdeaSubmission::STATUS_SUBMITTED,
                'categories' => [$catProcess?->id, $catCost?->id],
                'history' => [
                    ['from' => null, 'to' => IdeaSubmission::STATUS_SUBMITTED, 'note' => 'Initial submission received.'],
                ],
                'comments' => [],
            ],
            [
                'reference_number' => 'EEC-IDEA-2026-00005',
                'submitter_name' => 'Yonas Hailu',
                'submitter_job_title' => 'Geographical Information System (GIS) Analyst',
                'submitter_department' => 'Geomatics & Remote Sensing',
                'submitter_site' => 'Head Office - Addis Ababa',
                'submitter_email' => 'yonas.hailu@eec.com.et',
                'submitter_phone' => '+251 93 111 2233',
                'title' => 'Drone Photogrammetry & LiDAR Surveying Service as New EEC Commercial Offering',
                'description' => 'Commercializing EECs state-of-the-art surveying drones to offer precision aerial topographic surveys to external municipal and agricultural developers.',
                'problem_addressed' => 'High-end drone equipment sits idle 45% of the year between major governmental corridor projects.',
                'company_benefits' => 'Generates projected 12M ETB in secondary corporate commercial revenue annually while keeping survey pilots highly practiced.',
                'risks_challenges' => 'Civil Aviation Authority flight clearance permits and liability insurance.',
                'submission_date' => now()->subDays(9),
                'status' => IdeaSubmission::STATUS_UNDER_REVIEW,
                'assigned_reviewer_id' => $reviewer2?->id,
                'reviewer_notes' => 'Feasibility study looks promising. Consulting with Legal Directorate.',
                'categories' => [$catBusiness?->id, $catTech?->id],
                'history' => [
                    ['from' => null, 'to' => IdeaSubmission::STATUS_SUBMITTED, 'note' => 'Submitted online.'],
                    ['from' => IdeaSubmission::STATUS_SUBMITTED, 'to' => IdeaSubmission::STATUS_UNDER_REVIEW, 'note' => 'Assigned to Digital Reviewer for commercial viability audit.'],
                ],
                'comments' => [
                    ['user' => $admin, 'text' => 'Coordinate with Business Development Directorate to formulate official service price schedule.', 'internal' => true],
                ],
            ],
            [
                'reference_number' => 'EEC-IDEA-2026-00006',
                'submitter_name' => 'Rahel Tesfaye',
                'submitter_job_title' => 'Client Relations Executive',
                'submitter_department' => 'Business Development & Client Relations',
                'submitter_site' => 'Head Office - Addis Ababa',
                'submitter_email' => 'rahel.t@eec.com.et',
                'submitter_phone' => '+251 91 888 9900',
                'title' => 'Client Live Milestone Portal: Real-Time Engineering Progress Tracker',
                'description' => 'A branded web portal where government clients and private financiers can securely track deliverables, view CAD progress renders, and download verified inspection memos.',
                'problem_addressed' => 'Clients frequently escalate status inquiries via phone calls and formal letters because monthly PDF reports are out of date upon delivery.',
                'company_benefits' => 'Skyrockets client trust, positions EEC as the premier digital-first engineering firm in East Africa, and reduces ad-hoc stakeholder meetings by 50%.',
                'risks_challenges' => 'Ensuring intellectual property protection on preliminary structural drawings.',
                'submission_date' => now()->subDays(14),
                'status' => IdeaSubmission::STATUS_APPROVED,
                'assigned_reviewer_id' => $reviewer2?->id,
                'approval_notes' => 'Approved for development in Q2 IT roadmap.',
                'categories' => [$catClient?->id, $catTech?->id, $catQuality?->id],
                'history' => [
                    ['from' => null, 'to' => IdeaSubmission::STATUS_SUBMITTED, 'note' => 'Idea submitted.'],
                    ['from' => IdeaSubmission::STATUS_SUBMITTED, 'to' => IdeaSubmission::STATUS_UNDER_REVIEW, 'note' => 'Under assessment.'],
                    ['from' => IdeaSubmission::STATUS_UNDER_REVIEW, 'to' => IdeaSubmission::STATUS_APPROVED, 'note' => 'Approved for development in Q2 roadmap.'],
                ],
                'comments' => [
                    ['user' => $reviewer2, 'text' => 'Can be architected as a submodule within our internal portal infrastructure.', 'internal' => false],
                ],
            ],
            [
                'reference_number' => 'EEC-IDEA-2026-00007',
                'submitter_name' => 'Fikadu Worku',
                'submitter_job_title' => 'Mechanical Workshop Engineer',
                'submitter_department' => 'Electromechanical Engineering',
                'submitter_site' => 'Kality Central Workshop',
                'submitter_email' => 'fikadu.w@eec.com.et',
                'submitter_phone' => '+251 92 666 7788',
                'title' => 'Solar-Powered Battery Regeneration and Desulfation Station',
                'description' => 'Implementing high-frequency pulse desulfation charging units powered by workshop solar arrays to restore heavy machinery lead-acid batteries.',
                'problem_addressed' => 'Over 140 expensive heavy machinery batteries are discarded every year due to sulfation despite 85% plate integrity.',
                'company_benefits' => 'Restores up to 60% of discarded batteries, saving over 2.4M ETB in replacement procurement while eliminating toxic lead waste.',
                'risks_challenges' => 'Acid handling safety precautions and disposal of non-recoverable cells.',
                'submission_date' => now()->subDays(30),
                'status' => IdeaSubmission::STATUS_IMPLEMENTED,
                'assigned_reviewer_id' => $reviewer1?->id,
                'approval_notes' => 'Budget allocated from Green Engineering Reserve Fund.',
                'reviewer_notes' => 'Installed and active at Kality Workshop.',
                'categories' => [$catSustainability?->id, $catCost?->id, $catProcess?->id],
                'history' => [
                    ['from' => null, 'to' => IdeaSubmission::STATUS_SUBMITTED, 'note' => 'Submitted.'],
                    ['from' => IdeaSubmission::STATUS_SUBMITTED, 'to' => IdeaSubmission::STATUS_UNDER_REVIEW, 'note' => 'Reviewed by electromechanical division.'],
                    ['from' => IdeaSubmission::STATUS_UNDER_REVIEW, 'to' => IdeaSubmission::STATUS_APPROVED, 'note' => 'Hardware funded.'],
                    ['from' => IdeaSubmission::STATUS_APPROVED, 'to' => IdeaSubmission::STATUS_IMPLEMENTED, 'note' => 'Installed and active at Kality Workshop.'],
                ],
                'comments' => [
                    ['user' => $reviewer1, 'text' => 'First batch of 24 batteries recovered with 92% cold-cranking amp capacity.', 'internal' => true],
                ],
            ],
            [
                'reference_number' => 'EEC-IDEA-2026-00008',
                'submitter_name' => 'Abel Desta',
                'submitter_job_title' => 'Junior Draftsman',
                'submitter_department' => 'Urban Planning & Architecture',
                'submitter_site' => 'Head Office - Addis Ababa',
                'submitter_email' => 'abel.desta@eec.com.et',
                'submitter_phone' => '+251 91 333 4411',
                'title' => 'Mandatory Company-Wide Switch to Linux Operating System',
                'description' => 'Replacing all Windows licenses across all computers with open-source Ubuntu Linux overnight to eliminate OS license costs.',
                'problem_addressed' => 'Software licensing expenditures for desktop operating systems.',
                'company_benefits' => 'Eliminates annual Windows licensing fees.',
                'risks_challenges' => 'Complete incompatibility with major engineering CAD/BIM tools.',
                'submission_date' => now()->subDays(15),
                'status' => IdeaSubmission::STATUS_REJECTED,
                'assigned_reviewer_id' => $admin?->id,
                'rejection_reason' => 'While cost saving is admirable, industry standard CAD/BIM tools (AutoCAD, Civil 3D, ArcGIS) require native Windows environments and cannot run reliably under Linux. Not technically viable for an engineering firm.',
                'reviewer_notes' => 'Incompatible with core engineering software suites.',
                'categories' => [$catCost?->id],
                'history' => [
                    ['from' => null, 'to' => IdeaSubmission::STATUS_SUBMITTED, 'note' => 'Submission received.'],
                    ['from' => IdeaSubmission::STATUS_SUBMITTED, 'to' => IdeaSubmission::STATUS_UNDER_REVIEW, 'note' => 'Reviewed by IT Governance.'],
                    ['from' => IdeaSubmission::STATUS_UNDER_REVIEW, 'to' => IdeaSubmission::STATUS_REJECTED, 'note' => 'Incompatible with core engineering software suites (AutoCAD, Civil 3D, ArcGIS).'],
                ],
                'comments' => [
                    ['user' => $admin, 'text' => 'While cost saving is admirable, industry standard CAD/BIM tools require native Windows environments. Not technically viable.', 'internal' => false],
                ],
            ],
            [
                'reference_number' => 'EEC-IDEA-2026-00009',
                'submitter_name' => 'Marta Alemu',
                'submitter_job_title' => 'Quality Control Chemist',
                'submitter_department' => 'Geotechnical & Materials Testing Laboratory',
                'submitter_site' => 'Kality Central Laboratory',
                'submitter_email' => 'marta.alemu@eec.com.et',
                'submitter_phone' => '+251 94 888 1234',
                'title' => 'QR Code Sample Tracking and Barcoded Soil Specimen Archive',
                'description' => 'Affixing thermal barcode stickers to all incoming borehole soil and aggregate core specimens, synchronized with laboratory digital scales and compression testing rigs.',
                'problem_addressed' => 'Handwritten labels on core boxes occasionally smudge or detach during high-volume field seasons, risking specimen mix-ups.',
                'company_benefits' => '100% chain-of-custody traceability, prevents costly re-drilling field trips, and automates laboratory test certificate generation.',
                'risks_challenges' => 'Dust resistance of barcode readers in aggregate sieving areas.',
                'submission_date' => now()->subDays(6),
                'status' => IdeaSubmission::STATUS_APPROVED,
                'assigned_reviewer_id' => $reviewer1?->id,
                'approval_notes' => 'Thermal printers and industrial scanners approved for procurement.',
                'reviewer_notes' => 'High ROI and will directly support ISO/IEC 17025 laboratory accreditation.',
                'categories' => [$catQuality?->id, $catProcess?->id],
                'history' => [
                    ['from' => null, 'to' => IdeaSubmission::STATUS_SUBMITTED, 'note' => 'Submitted by Lab Chemist.'],
                    ['from' => IdeaSubmission::STATUS_SUBMITTED, 'to' => IdeaSubmission::STATUS_UNDER_REVIEW, 'note' => 'Evaluated.'],
                    ['from' => IdeaSubmission::STATUS_UNDER_REVIEW, 'to' => IdeaSubmission::STATUS_APPROVED, 'note' => 'Thermal printers and scanners approved for purchase.'],
                ],
                'comments' => [],
            ],
            [
                'reference_number' => 'EEC-IDEA-2026-00010',
                'submitter_name' => 'Biniyam Zewde',
                'submitter_job_title' => 'Power Systems Project Coordinator',
                'submitter_department' => 'Water & Energy Design',
                'submitter_site' => 'Dire Dawa Regional Hub',
                'submitter_email' => 'biniyam.z@eec.com.et',
                'submitter_phone' => '+251 92 111 8899',
                'title' => 'Hybrid Wind-Solar Microgrid Template for Remote Construction Camps',
                'description' => 'A modular, containerized 25kW hybrid wind/solar generator to replace 24/7 diesel generator runtime at remote desert site encampments.',
                'problem_addressed' => 'Diesel fuel logistics to remote sites account for up to 28% of site accommodation operational budgets, with frequent supply disruptions.',
                'company_benefits' => 'Saves over 8,000 liters of diesel per camp every quarter, silent night operation, and zero carbon emissions during camp habitation.',
                'risks_challenges' => 'Upfront capital expenditure and transport logistics across rugged terrain.',
                'submission_date' => now()->subDays(2),
                'status' => IdeaSubmission::STATUS_SUBMITTED,
                'categories' => [$catSustainability?->id, $catCost?->id, $catTech?->id],
                'history' => [
                    ['from' => null, 'to' => IdeaSubmission::STATUS_SUBMITTED, 'note' => 'Submitted.'],
                ],
                'comments' => [],
            ],
        ];

        foreach ($sampleSubmissions as $item) {
            $categories = $item['categories'];
            $history = $item['history'];
            $comments = $item['comments'];
            unset($item['categories'], $item['history'], $item['comments']);

            $submission = IdeaSubmission::updateOrCreate(
                ['reference_number' => $item['reference_number']],
                $item
            );

            // Sync categories
            $validCatIds = array_filter($categories);
            if (! empty($validCatIds)) {
                $submission->categories()->sync($validCatIds);
            }

            // Sync history
            foreach ($history as $h) {
                IdeaStatusHistory::create([
                    'idea_submission_id' => $submission->id,
                    'user_id' => $submission->assigned_reviewer_id ?? $admin?->id,
                    'from_status' => $h['from'],
                    'to_status' => $h['to'],
                    'remarks' => $h['note'],
                    'created_at' => now()->subDays(rand(1, 15)),
                ]);
            }

            // Sync comments
            foreach ($comments as $c) {
                IdeaComment::create([
                    'idea_submission_id' => $submission->id,
                    'user_id' => $c['user']?->id ?? $admin?->id,
                    'comment' => $c['text'],
                    'is_internal' => $c['internal'],
                    'created_at' => now()->subDays(rand(1, 10)),
                ]);
            }
        }
    }
}
