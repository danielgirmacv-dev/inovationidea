<?php

namespace Database\Seeders;

use App\Models\IdeaCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Process Improvement',
                'slug' => Str::slug('Process Improvement'),
                'description' => 'Enhancing workflows, operational efficiency, and reducing procedural bottlenecks.',
                'icon' => 'cog',
                'color' => '#004B59',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Cost-Saving',
                'slug' => Str::slug('Cost-Saving'),
                'description' => 'Tactics and systems that directly cut operational, procurement, or project expenditures.',
                'icon' => 'currency-dollar',
                'color' => '#059669',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Quality Improvement',
                'slug' => Str::slug('Quality Improvement'),
                'description' => 'Elevating engineering deliverables, accuracy, standard compliance, and project outputs.',
                'icon' => 'badge-check',
                'color' => '#0284C7',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Safety Improvement',
                'slug' => Str::slug('Safety Improvement'),
                'description' => 'Enhancing occupational safety, hazard mitigation, PPE protocols, and job site security.',
                'icon' => 'shield-check',
                'color' => '#DC2626',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'New Technology or Digitalization',
                'slug' => Str::slug('New Technology or Digitalization'),
                'description' => 'Implementing modern digital tools, automation, BIM/GIS innovations, and smart systems.',
                'icon' => 'cpu-chip',
                'color' => '#00A3C4',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Client Experience Enhancements',
                'slug' => Str::slug('Client Experience Enhancements'),
                'description' => 'Boosting stakeholder communication, delivery responsiveness, and client satisfaction.',
                'icon' => 'user-group',
                'color' => '#7C3AED',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Sustainability & Environment',
                'slug' => Str::slug('Sustainability & Environment'),
                'description' => 'Green engineering, carbon footprint reduction, renewable energy, and waste recycling.',
                'icon' => 'globe-alt',
                'color' => '#10B981',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'New Business Idea',
                'slug' => Str::slug('New Business Idea'),
                'description' => 'New engineering services, corporate revenue streams, spin-offs, and commercial ventures.',
                'icon' => 'light-bulb',
                'color' => '#D97706',
                'sort_order' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Other',
                'slug' => Str::slug('Other'),
                'description' => 'Innovative ideas spanning organizational culture, community impact, or general topics.',
                'icon' => 'sparkles',
                'color' => '#4B5563',
                'sort_order' => 9,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $cat) {
            IdeaCategory::updateOrCreate(['name' => $cat['name']], $cat);
        }
    }
}
