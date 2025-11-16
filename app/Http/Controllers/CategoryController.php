<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * GET /api/categories
     * List categories with pagination.
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $perPage = max(1, min(100, $perPage)); // sane bounds

        // You can add ordering/filtering here (search, sort)
        $categories = Category::orderBy('created_at', 'desc')->paginate($perPage);

        // Return a resource collection (automatically includes meta/links)
        return CategoryResource::collection($categories);
    }

    /**
     * POST /api/categories
     * Create a category.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->only(['name', 'description', 'slug']);
        $category = Category::create($data);

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * GET /api/categories/{category}
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * PUT/PATCH /api/categories/{category}
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->only(['name', 'description', 'slug']));

        return new CategoryResource($category);
    }

    /**
     * DELETE /api/categories/{category}
     * Soft-delete by default (because model uses SoftDeletes).
     */
    public function destroy(Category $category)
    {
        $category->delete();

        // 204 No Content is conventional for successful deletes.
        return response()->noContent();
    }
}
