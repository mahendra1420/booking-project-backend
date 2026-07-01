<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // ── Permissions ──────────────────────────────────────────────────────
        $permissions = [
            // Dashboard
            ['name' => 'View Dashboard',     'slug' => 'dashboard.view',          'module' => 'dashboard'],
            // Customers
            ['name' => 'View Customers',     'slug' => 'customers.view',           'module' => 'customers'],
            ['name' => 'Edit Customers',     'slug' => 'customers.edit',           'module' => 'customers'],
            ['name' => 'Block Customers',    'slug' => 'customers.block',          'module' => 'customers'],
            ['name' => 'Delete Customers',   'slug' => 'customers.delete',         'module' => 'customers'],
            ['name' => 'Export Customers',   'slug' => 'customers.export',         'module' => 'customers'],
            // Businesses
            ['name' => 'View Businesses',    'slug' => 'businesses.view',          'module' => 'businesses'],
            ['name' => 'Approve Business',   'slug' => 'businesses.approve',       'module' => 'businesses'],
            ['name' => 'Reject Business',    'slug' => 'businesses.reject',        'module' => 'businesses'],
            ['name' => 'Edit Business',      'slug' => 'businesses.edit',          'module' => 'businesses'],
            ['name' => 'Delete Business',    'slug' => 'businesses.delete',        'module' => 'businesses'],
            ['name' => 'Feature Business',   'slug' => 'businesses.feature',       'module' => 'businesses'],
            // Categories
            ['name' => 'View Categories',    'slug' => 'categories.view',          'module' => 'categories'],
            ['name' => 'Create Category',    'slug' => 'categories.create',        'module' => 'categories'],
            ['name' => 'Edit Category',      'slug' => 'categories.edit',          'module' => 'categories'],
            ['name' => 'Delete Category',    'slug' => 'categories.delete',        'module' => 'categories'],
            // Appointments
            ['name' => 'View Appointments',  'slug' => 'appointments.view',        'module' => 'appointments'],
            ['name' => 'Update Appt Status', 'slug' => 'appointments.update',      'module' => 'appointments'],
            // Payments
            ['name' => 'View Payments',      'slug' => 'payments.view',            'module' => 'payments'],
            ['name' => 'Issue Refund',       'slug' => 'payments.refund',          'module' => 'payments'],
            ['name' => 'Process Payout',     'slug' => 'payments.payout',          'module' => 'payments'],
            // Coupons
            ['name' => 'View Coupons',       'slug' => 'coupons.view',             'module' => 'coupons'],
            ['name' => 'Create Coupon',      'slug' => 'coupons.create',           'module' => 'coupons'],
            ['name' => 'Edit Coupon',        'slug' => 'coupons.edit',             'module' => 'coupons'],
            ['name' => 'Delete Coupon',      'slug' => 'coupons.delete',           'module' => 'coupons'],
            // Notifications
            ['name' => 'View Notifications', 'slug' => 'notifications.view',       'module' => 'notifications'],
            ['name' => 'Send Notifications', 'slug' => 'notifications.send',       'module' => 'notifications'],
            // Reviews
            ['name' => 'View Reviews',       'slug' => 'reviews.view',             'module' => 'reviews'],
            ['name' => 'Hide Review',        'slug' => 'reviews.hide',             'module' => 'reviews'],
            ['name' => 'Delete Review',      'slug' => 'reviews.delete',           'module' => 'reviews'],
            // Reports
            ['name' => 'View Reports',       'slug' => 'reports.view',             'module' => 'reports'],
            ['name' => 'Export Reports',     'slug' => 'reports.export',           'module' => 'reports'],
            // CMS
            ['name' => 'View CMS',           'slug' => 'cms.view',                 'module' => 'cms'],
            ['name' => 'Edit CMS',           'slug' => 'cms.edit',                 'module' => 'cms'],
            // Settings
            ['name' => 'View Settings',      'slug' => 'settings.view',            'module' => 'settings'],
            ['name' => 'Edit Settings',      'slug' => 'settings.edit',            'module' => 'settings'],
            // Roles
            ['name' => 'View Roles',         'slug' => 'roles.view',               'module' => 'roles'],
            ['name' => 'Create Role',        'slug' => 'roles.create',             'module' => 'roles'],
            ['name' => 'Edit Role',          'slug' => 'roles.edit',               'module' => 'roles'],
            ['name' => 'Delete Role',        'slug' => 'roles.delete',             'module' => 'roles'],
            // Support
            ['name' => 'View Support',       'slug' => 'support.view',             'module' => 'support'],
            ['name' => 'Reply Ticket',       'slug' => 'support.reply',            'module' => 'support'],
            ['name' => 'Close Ticket',       'slug' => 'support.close',            'module' => 'support'],
            // Audit Logs
            ['name' => 'View Audit Logs',    'slug' => 'audit-logs.view',          'module' => 'audit-logs'],
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['slug' => $p['slug']], $p);
        }

        // ── Roles ────────────────────────────────────────────────────────────
        $allPermissionIds = Permission::pluck('id')->toArray();

        $superAdmin = Role::firstOrCreate(['slug' => 'super-admin'], [
            'name' => 'Super Admin', 'description' => 'Full access to all features', 'is_system' => true,
        ]);
        $superAdmin->permissions()->sync($allPermissionIds);

        $manager = Role::firstOrCreate(['slug' => 'manager'], [
            'name' => 'Manager', 'description' => 'Access to most features except settings and roles', 'is_system' => true,
        ]);
        $managerPerms = Permission::whereNotIn('module', ['settings', 'roles'])->pluck('id')->toArray();
        $manager->permissions()->sync($managerPerms);

        $finance = Role::firstOrCreate(['slug' => 'finance'], [
            'name' => 'Finance', 'description' => 'Payments, payouts, reports, commission', 'is_system' => true,
        ]);
        $financePerms = Permission::whereIn('module', ['dashboard','payments','reports'])->pluck('id')->toArray();
        $finance->permissions()->sync($financePerms);

        $support = Role::firstOrCreate(['slug' => 'customer-support'], [
            'name' => 'Customer Support', 'description' => 'Customers, support tickets, reviews', 'is_system' => true,
        ]);
        $supportPerms = Permission::whereIn('module', ['dashboard','customers','support','reviews'])->pluck('id')->toArray();
        $support->permissions()->sync($supportPerms);

        $operations = Role::firstOrCreate(['slug' => 'operations'], [
            'name' => 'Operations', 'description' => 'Businesses, appointments, bookings', 'is_system' => true,
        ]);
        $opsPerms = Permission::whereIn('module', ['dashboard','businesses','appointments','categories'])->pluck('id')->toArray();
        $operations->permissions()->sync($opsPerms);

        // ── Super Admin User ─────────────────────────────────────────────────
        AdminUser::firstOrCreate(['email' => 'admin@bookingpro.com'], [
            'role_id'  => $superAdmin->id,
            'name'     => 'Super Admin',
            'password' => Hash::make('Admin@123'),
            'phone'    => '+91 9000000000',
            'status'   => true,
        ]);

        $this->command->info('✅ Admin panel seeded successfully!');
        $this->command->info('   Email: admin@bookingpro.com');
        $this->command->info('   Password: Admin@123');
    }
}
