<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\ParamList;
use App\Models\Product;
use App\Models\ProductParam;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductsController extends BaseController {

    function getParamProductPage(Product $product){
        return [
            'product' => $product,
            'statuses' => Product::STATUS,
            'categories' => Category::getAllCategories(),
            'paramTypes' => ProductParam::TYPES,
            'paramTypesList' => ProductParam::TYPES_OF_LIST,
            'TYPE_LIST_VALUES_USER_SELECT' => ProductParam::TYPE_LIST_VALUES_USER_SELECT,
            'lists' => ParamList::all()
        ];
    }
    //===============

    function table(){
        $this->menu->active = 'a_products';

        return view('admin.products.table', [
            'products' => Product::orderBy('id')->paginate(10)
        ]);
    }

    function createPage(){
        $this->menu->active = 'a_products';

        return view('admin.products.edit', $this->getParamProductPage(new Product()));
    }

    function showPage(Product $product){
        $this->menu->active = 'a_products';

        return view('admin.products.edit', $this->getParamProductPage($product));
    }

    /**** POST ****/
    function saveProduct(){
        request()->validate([
            'id' => 'required|integer',
            'caption' => 'required',
            'price' => 'required|decimal:0,2',
            'category_id' => 'required|integer',
            'status' => 'required|integer',
            'param.*.caption' => 'required',
            'param.*.type' => 'required|integer',
            'param.*.value' => 'required',
            'param.*.list' => 'required|integer',
        ]);

        // создание или сохранение товара
        $pid = request('id'); // забираем id товара, если 0, то это новый товар

        // заполняем общие поля
        $data = [
            'caption'     => request('caption'),    // название товара
            'description' => request('desc', ''),   // описание товара
            'price'       => request('price'),      // стоимость товара
            'status'      => request('status'),     // статус товара (0 - скрыто, 1 - опубликовано)
            'category_id' => request('category_id')
        ];

        $product = $pid > 0 ? Product::find($pid) : null;
        if($product)
            $product->forceFill($data)->save();
        else
            $product = Product::create($data);
        /** @var Product $product */

        // сохраняем характеристики товара
        $oldParams = $product->params();
        $updateParams = request('param', []);

        $idsOld = [];
        foreach($oldParams as $param)
            if(isset($updateParams[$param->id])){
                $param->forceFill([
                    'caption'    => $updateParams[$param->id]['caption'], // название характеристики
                    'value'      => $updateParams[$param->id]['value'],   // значение характеристики
                    'type_param' => $updateParams[$param->id]['type'],    // тип характеристики
                    'list_id'    => $updateParams[$param->id]['list']     // ссылка на лист значений
                ])->save();
                $idsOld[] = $param->id;
            } else
                $param->delete();

        foreach($updateParams as $paramID => $param)
            if(!in_array($paramID, $idsOld)){
                $paramObj = $product->addParam($param['caption'], $param['type'], $param['list']);
                $paramObj->value = $param['value'];
                $paramObj->save();
            }

        // сохранение картинок
        if(request()->hasfile('loadImage'))
            foreach(request()->file('loadImage') as $file){
                /** @var UploadedFile $file */
                //$filename = $file->getClientOriginalName(); // имя файла у пользователя
                $path = 'product_'.$product->id;
                if(!Storage::directoryExists($path))
                    Storage::makeDirectory($path);
                $file->storeAs($path, $file->hashName());
            }

        return redirect('/admin/products/'.$product->id);
    }
}
