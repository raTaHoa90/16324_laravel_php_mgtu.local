<?php
namespace App\Http\Controllers;

use App\Http\Menu\BaseMenu;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class MainController extends BaseController {

    function getCategoriesID(Category $category, Collection $categories){
        foreach($category->children() as $subCategory){
            $categories->push($subCategory->id);
            $this->getCategoriesID($subCategory, $categories);
        }
    }

    //********************/

    function main(){
        return view('main.main',[
            'products' => Product::where('status', Product::STATUS_VISIBLE)->orderBy('id')->paginate(10),
            'countCartProducts' => count(Session::get('products',[]))
        ]);
    }

    function product(Product $product){
        $categories = collect();
        $category = $product->category();
        while($category){
            $categories->unshift($category);
            $category = $category->parent();
        }

        $this->breadcrumbs->AddMenu('На главную')->link('/')->icon('fa-home');
        foreach($categories as $category)
            $this->breadcrumbs->AddMenu($category->caption)->link('/categories/'.$category->saf);

        return view('main.product',[
            'product' => $product,
            'countCartProducts' => count(Session::get('products',[]))
        ]);
    }

    function category(Category $category){
        $categoriesID = collect([$category->id]);
        $this->getCategoriesID($category, $categoriesID);

        $categories = collect();
        $cat = $category->parent();
        while($cat){
            $categories->unshift($cat);
            $cat = $cat->parent();
        }

        $this->breadcrumbs->AddMenu('На главную')->link('/')->icon('fa-home');
        foreach($categories as $cat)
            $this->breadcrumbs->AddMenu($cat->caption)->link('/categories/'.$cat->saf);

        return view('main.category',[
            'category' => $category,
            'products' => Product::where('status', Product::STATUS_VISIBLE)
                ->whereIn('category_id', $categoriesID)
                ->orderBy('id')->paginate(10),
            'countCartProducts' => count(Session::get('products',[]))
        ]);
    }
}
