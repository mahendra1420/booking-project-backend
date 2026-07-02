<?php namespace Database\Seeders; use Illuminate\Database\Seeder; class SettingSeeder extends Seeder { public function run() { use App\Models\Setting;

\ = [
    // General
    ['key' => 'site_name', 'label' => 'Site Name', 'value' => 'Booking App', 'group' => 'general'],
    ['key' => 'site_description', 'label' => 'Site Description', 'value' => 'The best booking platform.', 'group' => 'general'],
    ['key' => 'support_email', 'label' => 'Support Email', 'value' => 'support@example.com', 'group' => 'general'],
    ['key' => 'contact_phone', 'label' => 'Contact Phone', 'value' => '+1234567890', 'group' => 'general'],
    ['key' => 'default_timezone', 'label' => 'Default Timezone', 'value' => 'UTC', 'group' => 'general'],
    ['key' => 'currency_symbol', 'label' => 'Currency Symbol', 'value' => '$', 'group' => 'general'],

    // Payment
    ['key' => 'stripe_key', 'label' => 'Stripe Public Key', 'value' => '', 'group' => 'payment'],
    ['key' => 'stripe_secret', 'label' => 'Stripe Secret Key', 'value' => '', 'group' => 'payment'],
    ['key' => 'paypal_client_id', 'label' => 'PayPal Client ID', 'value' => '', 'group' => 'payment'],
    ['key' => 'paypal_secret', 'label' => 'PayPal Secret', 'value' => '', 'group' => 'payment'],
    ['key' => 'default_commission_rate', 'label' => 'Default Platform Commission (%)', 'value' => '10', 'group' => 'payment'],

    // Social
    ['key' => 'fb_link', 'label' => 'Facebook Link', 'value' => 'https://facebook.com', 'group' => 'social'],
    ['key' => 'twitter_link', 'label' => 'Twitter/X Link', 'value' => 'https://twitter.com', 'group' => 'social'],
    ['key' => 'instagram_link', 'label' => 'Instagram Link', 'value' => 'https://instagram.com', 'group' => 'social'],
    ['key' => 'linkedin_link', 'label' => 'LinkedIn Link', 'value' => 'https://linkedin.com', 'group' => 'social'],

    // Notifications
    ['key' => 'mail_from_address', 'label' => 'Sender Email Address', 'value' => 'noreply@example.com', 'group' => 'notifications'],
    ['key' => 'mail_from_name', 'label' => 'Sender Name', 'value' => 'Booking Team', 'group' => 'notifications'],
    ['key' => 'sms_provider', 'label' => 'SMS Gateway', 'value' => 'twilio', 'group' => 'notifications'],
    ['key' => 'twilio_sid', 'label' => 'Twilio SID', 'value' => '', 'group' => 'notifications'],
    ['key' => 'twilio_token', 'label' => 'Twilio Auth Token', 'value' => '', 'group' => 'notifications'],
    
    // Business
    ['key' => 'auto_approve_businesses', 'label' => 'Auto-Approve New Businesses (1=Yes, 0=No)', 'value' => '0', 'group' => 'business'],
    ['key' => 'max_services_per_business', 'label' => 'Max Services Per Business', 'value' => '50', 'group' => 'business'],
];

foreach (\ as \) {
    Setting::updateOrCreate(['key' => \['key']], \);
}
echo 'Settings seeded successfully!'; } }
