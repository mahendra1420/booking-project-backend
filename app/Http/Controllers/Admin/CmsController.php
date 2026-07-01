<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function index()
    {
        $pages = CmsPage::latest()->paginate(20);

        return view('admin.cms.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.cms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug'             => 'required|string|max:255|unique:cms_pages,slug',
            'title'            => 'required|string|max:255',
            'content'          => 'required|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status'           => 'required|in:published,draft',
        ]);

        CmsPage::create($validated);

        return redirect()->route('admin.cms.index')
            ->with('success', 'CMS page created successfully.');
    }

    public function edit(CmsPage $cms)
    {
        return view('admin.cms.edit', compact('cms'));
    }

    public function update(Request $request, CmsPage $cms)
    {
        $validated = $request->validate([
            'slug'             => 'required|string|max:255|unique:cms_pages,slug,' . $cms->id,
            'title'            => 'required|string|max:255',
            'content'          => 'required|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status'           => 'required|in:published,draft',
        ]);

        $cms->update($validated);

        return redirect()->route('admin.cms.index')
            ->with('success', 'CMS page updated successfully.');
    }
}
