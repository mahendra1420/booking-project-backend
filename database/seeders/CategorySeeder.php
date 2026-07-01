<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // ── Parent Categories with Sub-categories ────────────────────────────
        $categories = [

            // 1. Beauty & Wellness
            [
                'name' => 'Beauty & Wellness',
                'icon' => '💅',
                'sort_order' => 1,
                'children' => [
                    ['name' => 'Hair Salon',         'icon' => '✂️',  'sort_order' => 1],
                    ['name' => 'Nail Salon',          'icon' => '💅',  'sort_order' => 2],
                    ['name' => 'Spa & Massage',       'icon' => '💆',  'sort_order' => 3],
                    ['name' => 'Makeup Artist',       'icon' => '💄',  'sort_order' => 4],
                    ['name' => 'Barber Shop',         'icon' => '💈',  'sort_order' => 5],
                    ['name' => 'Eyebrow & Lash',      'icon' => '👁️', 'sort_order' => 6],
                    ['name' => 'Skin Care & Facial',  'icon' => '🧴',  'sort_order' => 7],
                    ['name' => 'Hair Removal',        'icon' => '🪒',  'sort_order' => 8],
                    ['name' => 'Tattoo & Piercing',   'icon' => '🎨',  'sort_order' => 9],
                ],
            ],

            // 2. Health & Medical
            [
                'name' => 'Health & Medical',
                'icon' => '🏥',
                'sort_order' => 2,
                'children' => [
                    ['name' => 'General Physician',   'icon' => '🩺',  'sort_order' => 1],
                    ['name' => 'Dentist',             'icon' => '🦷',  'sort_order' => 2],
                    ['name' => 'Dermatologist',       'icon' => '🧴',  'sort_order' => 3],
                    ['name' => 'Eye Care / Optometrist', 'icon' => '👁️', 'sort_order' => 4],
                    ['name' => 'Physiotherapy',       'icon' => '🦾',  'sort_order' => 5],
                    ['name' => 'Cardiologist',        'icon' => '❤️',  'sort_order' => 6],
                    ['name' => 'Orthopedic',          'icon' => '🦴',  'sort_order' => 7],
                    ['name' => 'Pediatrician',        'icon' => '👶',  'sort_order' => 8],
                    ['name' => 'Gynecologist',        'icon' => '🩺',  'sort_order' => 9],
                    ['name' => 'ENT Specialist',      'icon' => '👂',  'sort_order' => 10],
                    ['name' => 'Neurologist',         'icon' => '🧠',  'sort_order' => 11],
                    ['name' => 'Psychiatrist',        'icon' => '🧘',  'sort_order' => 12],
                    ['name' => 'Dietitian / Nutritionist', 'icon' => '🥗', 'sort_order' => 13],
                    ['name' => 'Lab & Diagnostics',   'icon' => '🔬',  'sort_order' => 14],
                ],
            ],

            // 3. Fitness & Sports
            [
                'name' => 'Fitness & Sports',
                'icon' => '💪',
                'sort_order' => 3,
                'children' => [
                    ['name' => 'Gym & Fitness Center', 'icon' => '🏋️', 'sort_order' => 1],
                    ['name' => 'Yoga & Meditation',    'icon' => '🧘', 'sort_order' => 2],
                    ['name' => 'Personal Trainer',     'icon' => '🏅', 'sort_order' => 3],
                    ['name' => 'Swimming Pool',        'icon' => '🏊', 'sort_order' => 4],
                    ['name' => 'Martial Arts',         'icon' => '🥋', 'sort_order' => 5],
                    ['name' => 'Pilates',              'icon' => '🤸', 'sort_order' => 6],
                    ['name' => 'Cycling Studio',       'icon' => '🚴', 'sort_order' => 7],
                    ['name' => 'Zumba & Dance',        'icon' => '💃', 'sort_order' => 8],
                    ['name' => 'CrossFit',             'icon' => '🏋️', 'sort_order' => 9],
                ],
            ],

            // 4. Mental Health & Therapy
            [
                'name' => 'Mental Health & Therapy',
                'icon' => '🧠',
                'sort_order' => 4,
                'children' => [
                    ['name' => 'Psychologist',         'icon' => '🧠', 'sort_order' => 1],
                    ['name' => 'Therapist / Counselor','icon' => '💬', 'sort_order' => 2],
                    ['name' => 'Marriage Counselor',   'icon' => '💑', 'sort_order' => 3],
                    ['name' => 'Life Coach',           'icon' => '🎯', 'sort_order' => 4],
                    ['name' => 'Career Counselor',     'icon' => '💼', 'sort_order' => 5],
                    ['name' => 'Child Psychologist',   'icon' => '👦', 'sort_order' => 6],
                ],
            ],

            // 5. Professional Services
            [
                'name' => 'Professional Services',
                'icon' => '💼',
                'sort_order' => 5,
                'children' => [
                    ['name' => 'Lawyer / Legal',       'icon' => '⚖️', 'sort_order' => 1],
                    ['name' => 'Financial Advisor',    'icon' => '💰', 'sort_order' => 2],
                    ['name' => 'Tax Consultant',       'icon' => '🧾', 'sort_order' => 3],
                    ['name' => 'Business Consultant',  'icon' => '📊', 'sort_order' => 4],
                    ['name' => 'Chartered Accountant', 'icon' => '📑', 'sort_order' => 5],
                    ['name' => 'Real Estate Agent',    'icon' => '🏠', 'sort_order' => 6],
                    ['name' => 'Insurance Advisor',    'icon' => '🛡️', 'sort_order' => 7],
                ],
            ],

            // 6. Education & Tutoring
            [
                'name' => 'Education & Tutoring',
                'icon' => '📚',
                'sort_order' => 6,
                'children' => [
                    ['name' => 'Private Tutor',        'icon' => '📖', 'sort_order' => 1],
                    ['name' => 'Music Classes',        'icon' => '🎵', 'sort_order' => 2],
                    ['name' => 'Language Classes',     'icon' => '🌐', 'sort_order' => 3],
                    ['name' => 'Art & Craft Classes',  'icon' => '🎨', 'sort_order' => 4],
                    ['name' => 'Coding Classes',       'icon' => '💻', 'sort_order' => 5],
                    ['name' => 'Dance Classes',        'icon' => '💃', 'sort_order' => 6],
                    ['name' => 'Sports Coaching',      'icon' => '⚽', 'sort_order' => 7],
                ],
            ],

            // 7. Home Services
            [
                'name' => 'Home Services',
                'icon' => '🏠',
                'sort_order' => 7,
                'children' => [
                    ['name' => 'Plumber',              'icon' => '🔧', 'sort_order' => 1],
                    ['name' => 'Electrician',          'icon' => '⚡', 'sort_order' => 2],
                    ['name' => 'Home Cleaning',        'icon' => '🧹', 'sort_order' => 3],
                    ['name' => 'Pest Control',         'icon' => '🐛', 'sort_order' => 4],
                    ['name' => 'Interior Designer',    'icon' => '🛋️', 'sort_order' => 5],
                    ['name' => 'AC / Appliance Repair','icon' => '❄️', 'sort_order' => 6],
                    ['name' => 'Carpenter',            'icon' => '🪚', 'sort_order' => 7],
                    ['name' => 'Painter',              'icon' => '🎨', 'sort_order' => 8],
                ],
            ],

            // 8. Pet Services
            [
                'name' => 'Pet Services',
                'icon' => '🐾',
                'sort_order' => 8,
                'children' => [
                    ['name' => 'Veterinary Clinic',    'icon' => '🐕', 'sort_order' => 1],
                    ['name' => 'Pet Grooming',         'icon' => '✂️', 'sort_order' => 2],
                    ['name' => 'Pet Training',         'icon' => '🎾', 'sort_order' => 3],
                    ['name' => 'Pet Boarding',         'icon' => '🏠', 'sort_order' => 4],
                    ['name' => 'Dog Walking',          'icon' => '🦮', 'sort_order' => 5],
                ],
            ],

            // 9. Automotive
            [
                'name' => 'Automotive',
                'icon' => '🚗',
                'sort_order' => 9,
                'children' => [
                    ['name' => 'Car Service & Repair', 'icon' => '🔧', 'sort_order' => 1],
                    ['name' => 'Car Wash & Detailing', 'icon' => '🚿', 'sort_order' => 2],
                    ['name' => 'Tire Service',         'icon' => '🛞', 'sort_order' => 3],
                    ['name' => 'Dent & Paint Repair',  'icon' => '🎨', 'sort_order' => 4],
                    ['name' => 'Car Inspection',       'icon' => '🔍', 'sort_order' => 5],
                ],
            ],

            // 10. Photography & Media
            [
                'name' => 'Photography & Media',
                'icon' => '📷',
                'sort_order' => 10,
                'children' => [
                    ['name' => 'Photography Studio',   'icon' => '📷', 'sort_order' => 1],
                    ['name' => 'Videography',          'icon' => '🎬', 'sort_order' => 2],
                    ['name' => 'Portrait Session',     'icon' => '🤳', 'sort_order' => 3],
                    ['name' => 'Wedding Photography',  'icon' => '💒', 'sort_order' => 4],
                    ['name' => 'Product Photography',  'icon' => '📦', 'sort_order' => 5],
                ],
            ],

            // 11. Alternative Medicine
            [
                'name' => 'Alternative Medicine',
                'icon' => '🌿',
                'sort_order' => 11,
                'children' => [
                    ['name' => 'Acupuncture',          'icon' => '📍', 'sort_order' => 1],
                    ['name' => 'Ayurveda',             'icon' => '🌿', 'sort_order' => 2],
                    ['name' => 'Homeopathy',           'icon' => '💊', 'sort_order' => 3],
                    ['name' => 'Naturopathy',          'icon' => '🍃', 'sort_order' => 4],
                    ['name' => 'Chiropractic',         'icon' => '🦴', 'sort_order' => 5],
                    ['name' => 'Reiki & Energy Healing','icon' => '✨', 'sort_order' => 6],
                ],
            ],

            // 12. Events & Entertainment
            [
                'name' => 'Events & Entertainment',
                'icon' => '🎉',
                'sort_order' => 12,
                'children' => [
                    ['name' => 'Event Planner',        'icon' => '🎊', 'sort_order' => 1],
                    ['name' => 'DJ & Music',           'icon' => '🎧', 'sort_order' => 2],
                    ['name' => 'Catering Service',     'icon' => '🍽️', 'sort_order' => 3],
                    ['name' => 'Decoration Service',   'icon' => '🎀', 'sort_order' => 4],
                    ['name' => 'Comedian / Entertainer','icon' => '🎭', 'sort_order' => 5],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $children   = $categoryData['children'] ?? [];
            $parentSlug = Str::slug($categoryData['name']);

            // Insert parent
            $parentId = DB::table('categories')->insertGetId([
                'parent_id'   => null,
                'name'        => $categoryData['name'],
                'slug'        => $parentSlug,
                'icon'        => $categoryData['icon'],
                'description' => null,
                'sort_order'  => $categoryData['sort_order'],
                'status'      => true,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);

            // Insert children
            foreach ($children as $child) {
                $childSlug = Str::slug($categoryData['name'] . ' ' . $child['name']);

                // Handle duplicate slugs
                $slug  = $childSlug;
                $count = 1;
                while (DB::table('categories')->where('slug', $slug)->exists()) {
                    $slug = $childSlug . '-' . $count++;
                }

                DB::table('categories')->insert([
                    'parent_id'   => $parentId,
                    'name'        => $child['name'],
                    'slug'        => $slug,
                    'icon'        => $child['icon'],
                    'description' => null,
                    'sort_order'  => $child['sort_order'],
                    'status'      => true,
                    'created_at'  => $now,
                    'updated_at'  => $now,
                ]);
            }
        }

        $this->command->info('✅ ' . DB::table('categories')->count() . ' categories seeded successfully!');
    }
}
