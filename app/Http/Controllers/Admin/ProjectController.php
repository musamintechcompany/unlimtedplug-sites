<?php

namespace App\Http\Controllers\Admin;

use App\Models\RentableProject;
use App\Models\Category;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = RentableProject::with('category', 'subcategory')->paginate(15);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|uuid|exists:categories,id',
            'subcategory_id' => 'required|uuid|exists:subcategories,id',
            'api_url' => 'required|string|url',
            'pricing_24h' => 'required|numeric|min:0',
            'pricing_7d' => 'required|numeric|min:0',
            'pricing_30d' => 'required|numeric|min:0',
            'pricing_365d' => 'required|numeric|min:0',
            'sort_order' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'is_buyable' => 'nullable|boolean',
            'is_rentable' => 'nullable|boolean',
            'banner_image' => 'nullable|image|max:5120',
            'media_images' => 'nullable|array',
            'media_images.*' => 'image|max:5120',
        ]);

        $bannerImage = null;
        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image')->store('projects', 'public');
        }

        $mediaImages = [];
        if ($request->hasFile('media_images')) {
            foreach ($request->file('media_images') as $image) {
                $mediaImages[] = $image->store('projects', 'public');
            }
        }

        RentableProject::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'],
            'api_url' => $validated['api_url'],
            'pricing_24h' => $validated['pricing_24h'],
            'pricing_7d' => $validated['pricing_7d'],
            'pricing_30d' => $validated['pricing_30d'],
            'pricing_365d' => $validated['pricing_365d'],
            'sort_order' => $validated['sort_order'],
            'status' => $validated['status'],
            'banner_image' => $bannerImage,
            'media_images' => $mediaImages,
            'is_buyable' => $request->boolean('is_buyable'),
            'is_rentable' => $request->boolean('is_rentable'),
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully');
    }

    public function show(RentableProject $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    public function edit(RentableProject $project)
    {
        $categories = Category::all();
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, RentableProject $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|uuid|exists:categories,id',
            'subcategory_id' => 'required|uuid|exists:subcategories,id',
            'api_url' => 'required|string|url',
            'pricing_24h' => 'required|numeric|min:0',
            'pricing_7d' => 'required|numeric|min:0',
            'pricing_30d' => 'required|numeric|min:0',
            'pricing_365d' => 'required|numeric|min:0',
            'sort_order' => 'required|integer|min:0',
            'status' => 'required|in:active,inactive',
            'is_buyable' => 'nullable|boolean',
            'is_rentable' => 'nullable|boolean',
            'banner_image' => 'nullable|image|max:5120',
            'media_images' => 'nullable|array',
            'media_images.*' => 'image|max:5120',
        ]);

        $bannerImage = $project->banner_image;
        if ($request->boolean('delete_banner')) {
            $bannerImage = null;
        } elseif ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image')->store('projects', 'public');
        }

        $mediaImages = $project->media_images ?? [];
        if ($request->hasFile('media_images')) {
            foreach ($request->file('media_images') as $image) {
                $mediaImages[] = $image->store('projects', 'public');
            }
        }

        $project->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'],
            'category_id' => $validated['category_id'],
            'subcategory_id' => $validated['subcategory_id'],
            'api_url' => $validated['api_url'],
            'pricing_24h' => $validated['pricing_24h'],
            'pricing_7d' => $validated['pricing_7d'],
            'pricing_30d' => $validated['pricing_30d'],
            'pricing_365d' => $validated['pricing_365d'],
            'sort_order' => $validated['sort_order'],
            'status' => $validated['status'],
            'banner_image' => $bannerImage,
            'media_images' => $mediaImages,
            'is_buyable' => $request->boolean('is_buyable'),
            'is_rentable' => $request->boolean('is_rentable'),
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully');
    }

    public function destroy(RentableProject $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully');
    }
}
