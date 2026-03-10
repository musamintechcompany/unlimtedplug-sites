<?php

namespace App\Http\Controllers;

use App\Models\RentableProject;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectAdminController extends Controller
{
    public function index(Request $request)
    {
        if (!$this->isAuthenticated($request)) {
            return view('admin.projects.login');
        }

        $projects = RentableProject::all();
        return view('admin.projects.index', compact('projects'));
    }

    public function create(Request $request)
    {
        if (!$this->isAuthenticated($request)) {
            return redirect()->route('admin.projects.login');
        }

        $categories = Category::all();
        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (!$this->isAuthenticated($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required|uuid|exists:categories,id',
            'subcategory_id' => 'required|uuid|exists:subcategories,id',
            'api_url' => 'required|string',
            'pricing_24h' => 'required|numeric',
            'pricing_7d' => 'required|numeric',
            'pricing_30d' => 'required|numeric',
            'pricing_365d' => 'required|numeric',
            'sort_order' => 'required|integer',
            'status' => 'required|in:active,inactive',
            'is_buyable' => 'nullable|boolean',
            'is_rentable' => 'nullable|boolean',
            'banner_image' => 'nullable|image|max:5120',
            'media_images' => 'nullable|array',
            'media_images.*' => 'image|max:5120',
        ]);

        $bannerImage = null;
        if ($request->hasFile('banner_image')) {
            $bannerImage = 'storage/' . $request->file('banner_image')->store('projects', 'public');
        }

        $mediaImages = [];
        if ($request->hasFile('media_images')) {
            foreach ($request->file('media_images') as $image) {
                $mediaImages[] = 'storage/' . $image->store('projects', 'public');
            }
        }

        $details = [];

        RentableProject::create([
            'id' => Str::uuid(),
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
            'details' => json_encode($details),
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully');
    }

    public function show(Request $request, $id)
    {
        if (!$this->isAuthenticated($request)) {
            return redirect()->route('admin.projects.login');
        }

        $project = RentableProject::findOrFail($id);
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Request $request, $id)
    {
        if (!$this->isAuthenticated($request)) {
            return redirect()->route('admin.projects.login');
        }

        $project = RentableProject::findOrFail($id);
        $categories = Category::all();
        return view('admin.projects.create', compact('project', 'categories'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->isAuthenticated($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $project = RentableProject::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required|uuid|exists:categories,id',
            'subcategory_id' => 'required|uuid|exists:subcategories,id',
            'api_url' => 'required|string',
            'pricing_24h' => 'required|numeric',
            'pricing_7d' => 'required|numeric',
            'pricing_30d' => 'required|numeric',
            'pricing_365d' => 'required|numeric',
            'sort_order' => 'required|integer',
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
            $bannerImage = 'storage/' . $request->file('banner_image')->store('projects', 'public');
        }

        $mediaImages = $project->media_images ?? [];
        if ($request->hasFile('media_images')) {
            foreach ($request->file('media_images') as $image) {
                $mediaImages[] = 'storage/' . $image->store('projects', 'public');
            }
        }

        $details = [];

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
            'details' => json_encode($details),
        ]);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully');
    }

    public function destroy(Request $request, $id)
    {
        if (!$this->isAuthenticated($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        RentableProject::findOrFail($id)->delete();
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully');
    }

    private function isAuthenticated(Request $request): bool
    {
        return session('admin_authenticated') === true;
    }

    public function login(Request $request)
    {
        if ($request->method() === 'POST') {
            $request->validate(['password' => 'required|string']);
            
            if (hash_equals(config('app.admin_password'), $request->input('password'))) {
                $request->session()->regenerate();
                session()->put('admin_authenticated', true);
                return redirect()->route('admin.projects.index');
            }
            
            return back()->withErrors(['password' => 'Invalid password'])->onlyInput('password');
        }

        return view('admin.projects.login');
    }

    public function logout(Request $request)
    {
        session()->forget('admin_authenticated');
        return redirect()->route('admin.projects.login');
    }
}
