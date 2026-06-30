<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Template\StoreLoginTemplateRequest;
use App\Models\LoginTemplate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LoginTemplateController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $templates = LoginTemplate::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.settings.login-templates.index', compact('templates', 'search'));
    }

    public function create(): View
    {
        return view('admin.settings.login-templates.create', [
            'template' => new LoginTemplate(['is_active' => true]),
        ]);
    }

    public function store(StoreLoginTemplateRequest $request): RedirectResponse
    {
        $template = LoginTemplate::create($request->validated());

        return redirect()
            ->route('admin.login-templates.index')
            ->with('status', "Login template \"{$template->name}\" created successfully.");
    }

    public function edit(LoginTemplate $loginTemplate): View
    {
        return view('admin.settings.login-templates.edit', ['template' => $loginTemplate]);
    }

    public function update(StoreLoginTemplateRequest $request, LoginTemplate $loginTemplate): RedirectResponse
    {
        $loginTemplate->update($request->validated());

        return redirect()
            ->route('admin.login-templates.index')
            ->with('status', "Login template \"{$loginTemplate->name}\" updated successfully.");
    }

    public function destroy(LoginTemplate $loginTemplate): RedirectResponse
    {
        $name = $loginTemplate->name;
        $loginTemplate->delete();

        return redirect()
            ->route('admin.login-templates.index')
            ->with('status', "Login template \"{$name}\" deleted successfully.");
    }
}
