<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $categoryCounts = [
            'main' => 0,
            'sub' => 0,
            'subSub' => 0,
        ];
        foreach ($categories as $category) {
            if ($category->level == 1) {
                $categoryCounts['main']++;
            } elseif ($category->level == 2) {
                $categoryCounts['sub']++;
            } elseif ($category->level == 3) {
                $categoryCounts['subSub']++;
            }
        }
        return view('admin.categories.index', [
            'categories' => $categories,
            'categoryCounts' => $categoryCounts,
        ]);
    }

    public function create(Request $request)
    {
        $category = new Category();
        $category->title = $request->input('title');
        $category->description = $request->input('description');
        $category->parent_id = $request->input('parent_id');
        $category->save();

        $category->slug = Str::slug($category->title);
        $category->save();

        if ($category->parent_id) {
            $category->level = $category->parent->level + 1;
            $category->save();
        }

        return redirect()->route('admin.categories');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        if ($category) {
            return view('admin.categories.edit', [
                'category' => $category,
            ]);
        }
        return redirect()->route('admin.categories');
    }

    public function update(Request $request)
    {
        $category = Category::find($request->input('category_id'));
        $category->title = $request->input('title');
        $category->description = $request->input('description');
        /*$category->parent_id = $request->input('parent_id');*/
        $category->save();

        $category->slug = Str::slug($category->title);
        $category->save();

        /*if ($category->parent_id) {
            $category->level = $category->parent->level + 1;
            $category->save();
        }*/

        return redirect()->route('admin.categories');
    }

    public function enable(Request $request)
    {
        $category = Category::find($request->input('category_id'));
        if ($category && $category->status === 'disabled') {
            $category->status = 'enabled';
            $category->save();
            return redirect()->route('admin.categories.edit', [
                'id' => $category->id,
            ]);
        }
        return redirect()->route('admin.categories');
    }

    public function disable(Request $request)
    {
        $category = Category::find($request->input('category_id'));
        if ($category && $category->status === 'enabled') {
            $category->status = 'disabled';
            $category->save();
            return redirect()->route('admin.categories.edit', [
                'id' => $category->id,
            ]);
        }
        return redirect()->route('admin.categories');
    }
}
