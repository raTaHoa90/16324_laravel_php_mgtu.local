<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesController extends BaseController {

    function table(){
        $this->menu->active = 'a_categories';

        return view('admin.products.categories.table', [
            'categories' => Category::getAllCategories()
        ]);
    }

    /**** AJAX ****/

    function create(){
        request()->validate([
            'caption' => 'required',
            'parent_id' => 'required|integer',
        ]);

        $caption = request('caption');
        Category::create([
            'caption' => $caption,
            'saf' => Str::slug($caption),
            'parent_id' => request('parent_id'),
            'description' => request('desc', '')
        ]);

        return '{"ok":true}';
    }

    function update(){
        request()->validate([
            'idCategory' => 'required|integer',
            'caption' => 'required',
            'parent_id' => 'required|integer',
        ]);

        $category = Category::find(request('idCategory'));
        if(!$category)
            return '{"error":"Категория отсутствует"}';

        $caption = request('caption');

        $category->forceFill([
            'caption' => $caption,
            'saf' => Str::slug($caption),
            'parent_id' => request('parent_id'),
            'description' => request('desc')
        ])->save();

        return '{"ok":true}';
    }

    function delete(){
        request()->validate([
            'idCategory' => 'required|integer',
        ]);

        $category = Category::find(request('idCategory'));
        if(!$category)
            return '{"error":"Категория отсутствует"}';

        if($category->hasUsed())
            return '{"error":"Категория не может быть удалена, пока в ней есть другие объекты"}';

        $category->delete();
    }
}
