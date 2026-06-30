<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Template\StoreDashboardTemplateRequest;
use App\Models\DashboardTemplate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardTemplateController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $templates = DashboardTemplate::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.settings.dashboard-templates.index', compact('templates', 'search'));
    }

    public function create(): View
    {
        return view('admin.settings.dashboard-templates.create', [
            'template' => new DashboardTemplate(['is_active' => true]),
        ]);
    }

    public function store(StoreDashboardTemplateRequest $request): RedirectResponse
    {
        $template = DashboardTemplate::create($request->validated());

        return redirect()
            ->route('admin.dashboard-templates.index')
            ->with('status', "Dashboard template \"{$template->name}\" created successfully.");
    }

    public function edit(DashboardTemplate $dashboardTemplate): View
    {
        return view('admin.settings.dashboard-templates.edit', ['template' => $dashboardTemplate]);
    }

    public function update(StoreDashboardTemplateRequest $request, DashboardTemplate $dashboardTemplate): RedirectResponse
    {
        $dashboardTemplate->update($request->validated());

        return redirect()
            ->route('admin.dashboard-templates.index')
            ->with('status', "Dashboard template \"{$dashboardTemplate->name}\" updated successfully.");
    }

    public function destroy(DashboardTemplate $dashboardTemplate): RedirectResponse
    {
        $name = $dashboardTemplate->name;
        $dashboardTemplate->delete();

        return redirect()
            ->route('admin.dashboard-templates.index')
            ->with('status', "Dashboard template \"{$name}\" deleted successfully.");
    }
}
