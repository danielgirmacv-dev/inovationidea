<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IdeaCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = IdeaCategory::orderBy('sort_order')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:idea_categories,name'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:10'],
            'color' => ['nullable', 'string', 'max:20'],
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['sort_order'] = IdeaCategory::max('sort_order') + 1;

        IdeaCategory::create($data);

        return back()->with('success', 'Category created successfully.');
    }

    public function update(Request $request, IdeaCategory $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', "unique:idea_categories,name,{$category->id}"],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:10'],
            'color' => ['nullable', 'string', 'max:20'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = Str::slug($data['name']);

        $category->update($data);

        return back()->with('success', 'Category updated successfully.');
    }

    public function toggleActive(IdeaCategory $category)
    {
        $category->update(['is_active' => ! $category->is_active]);

        return back()->with('success', 'Category status toggled.');
    }
}
