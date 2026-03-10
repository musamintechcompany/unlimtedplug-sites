<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function subcategories($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        return response()->json($category->subcategories);
    }
}
