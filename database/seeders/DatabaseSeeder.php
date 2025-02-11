<?php
namespace Database\Seeders;

use App\Models\ComPermission;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        User::factory()->create([
            'name'     => 'Admin User',
            'email'    => 'admin@suswebapp.com',
            'password' => Hash::make('Admin@1234'),
            'userType' => '1',
        ]);

        // Super Admin user
        User::factory()->create([
            'name'     => 'Super Admin',
            'email'    => 'supperadmin@suswebapp.com',
            'password' => Hash::make('Supperadmin@1234'),
            'userType' => '1',
        ]);

        ComPermission::factory()->create([
            'id'               => 1,
            'userType'         => 'Super Admin',
            'description'      => 'Administrator Role with full permissions',
            'permissionObject' => json_encode([
                "INSIGHT_VIEW"                                    => true,
                "ADMIN_USERS_EDIT"                                => true,
                "ADMIN_USERS_VIEW"                                => true,
                "ADMIN_USERS_DELETE"                              => true,
                "ADMIN_ACCESS_MNG_EDIT"                           => true,
                "ADMIN_ACCESS_MNG_VIEW"                           => true,
                "ADMIN_ACCESS_MNG_CREATE"                         => true,
                "ADMIN_ACCESS_MNG_DELETE"                         => true,
                "AUDIT_INSPECTION_CALENDAR_EDIT"                  => true,
                "AUDIT_INSPECTION_CALENDAR_VIEW"                  => true,
                "AUDIT_INSPECTION_DASHBOARD_VIEW"                 => true,
                "AUDIT_INSPECTION_CALENDAR_CREATE"                => true,
                "AUDIT_INSPECTION_CALENDAR_DELETE"                => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_TASK_EDIT"       => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_TASK_VIEW"       => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_TASK_CREATE"     => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_TASK_DELETE"     => false,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_REGISTER_EDIT"   => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_REGISTER_VIEW"   => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_REGISTER_CREATE" => true,
                "AUDIT_INSPECTION_INTERNAL_AUDIT_REGISTER_DELETE" => true,
            ]),
        ]);
    }
}
