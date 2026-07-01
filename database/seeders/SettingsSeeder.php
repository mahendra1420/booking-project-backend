<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'app_name',         'value' => 'BookingPro',    'group' => 'general',  'type' => 'text',    'label' => 'App Name'],
            ['key' => 'app_logo',         'value' => null,            'group' => 'general',  'type' => 'file',    'label' => 'App Logo'],
            ['key' => 'currency',         'value' => 'INR',           'group' => 'general',  'type' => 'text',    'label' => 'Currency Code'],
            ['key' => 'currency_symbol',  'value' => '₹',             'group' => 'general',  'type' => 'text',    'label' => 'Currency Symbol'],
            ['key' => 'timezone',         'value' => 'Asia/Kolkata',  'group' => 'general',  'type' => 'text',    'label' => 'Timezone'],
            ['key' => 'support_email',    'value' => 'support@bookingpro.com', 'group' => 'general', 'type' => 'text', 'label' => 'Support Email'],
            ['key' => 'support_phone',    'value' => '+91 9000000000','group' => 'general',  'type' => 'text',    'label' => 'Support Phone'],
            // Payment
            ['key' => 'razorpay_key_id',     'value' => '',           'group' => 'payment',  'type' => 'text',    'label' => 'Razorpay Key ID'],
            ['key' => 'razorpay_key_secret', 'value' => '',           'group' => 'payment',  'type' => 'text',    'label' => 'Razorpay Key Secret'],
            ['key' => 'payment_methods',     'value' => '["razorpay","cash"]', 'group' => 'payment', 'type' => 'json', 'label' => 'Enabled Payment Methods'],
            // Business
            ['key' => 'commission_rate',  'value' => '10',            'group' => 'business', 'type' => 'text',    'label' => 'Default Commission Rate (%)'],
            ['key' => 'min_booking_hrs',  'value' => '1',             'group' => 'business', 'type' => 'text',    'label' => 'Min Advance Booking (hours)'],
            ['key' => 'max_booking_days', 'value' => '30',            'group' => 'business', 'type' => 'text',    'label' => 'Max Advance Booking (days)'],
            ['key' => 'cancellation_hrs', 'value' => '2',             'group' => 'business', 'type' => 'text',    'label' => 'Free Cancellation Window (hours)'],
            // Maps
            ['key' => 'google_maps_key',  'value' => '',              'group' => 'maps',     'type' => 'text',    'label' => 'Google Maps API Key'],
            // Notifications
            ['key' => 'fcm_server_key',   'value' => '',              'group' => 'notification', 'type' => 'text','label' => 'FCM Server Key'],
        ];

        foreach ($settings as $s) {
            DB::table('settings')->updateOrInsert(['key' => $s['key']], array_merge($s, [
                'created_at' => now(), 'updated_at' => now(),
            ]));
        }

        $this->command->info('✅ Default settings seeded!');
    }
}
