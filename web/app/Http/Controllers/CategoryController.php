<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Colocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function store(Request $request, Colocation $colocation)
    {
        $request->validate(['name' => 'required|string|max:50']);

        // Only owner can add categories
        $pivot = $colocation->User()->wherePivot('user_id', Auth::id())->first()?->pivot;
        if (!$pivot || $pivot->role !== 'owner') {
            abort(403);
        }

        Category::create([
            'colocation_id' => $colocation->id,
            'name'          => $request->name,
        ]);

        return back()->with('success', 'Catégorie ajoutée.');
    }

    public function destroy(Colocation $colocation, Category $category)
    {
        $pivot = $colocation->User()->wherePivot('user_id', Auth::id())->first()?->pivot;
        if (!$pivot || $pivot->role !== 'owner') {
            abort(403);
        }

        $category->delete();

        return back()->with('success', 'Catégorie supprimée.');
    }
}
