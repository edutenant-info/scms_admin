<?php

namespace Database\Seeders;

use App\Models\DashboardTemplate;
use App\Models\LoginTemplate;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $loginTemplates = [
            ['name' => 'Classic Login', 'code' => 'login-1', 'description' => 'Centered card login layout.'],
            ['name' => 'Split Login', 'code' => 'login-2', 'description' => 'Two-column split screen login.'],
            ['name' => 'Minimal Login', 'code' => 'login-3', 'description' => 'Minimal full-width login.'],
        ];

        foreach ($loginTemplates as $template) {
            LoginTemplate::updateOrCreate(['code' => $template['code']], $template + ['is_active' => true]);
        }

        $dashboardTemplates = [
            ['name' => 'Classic Dashboard', 'code' => 'dashboard-1', 'description' => 'Sidebar + top bar layout.'],
            ['name' => 'Compact Dashboard', 'code' => 'dashboard-2', 'description' => 'Condensed widgets dashboard.'],
            ['name' => 'Analytics Dashboard', 'code' => 'dashboard-3', 'description' => 'Charts-first analytics dashboard.'],
        ];

        foreach ($dashboardTemplates as $template) {
            DashboardTemplate::updateOrCreate(['code' => $template['code']], $template + ['is_active' => true]);
        }
    }
}
