<?php

namespace App\Http\Controllers\Admin;

use App\Models\ParamList;
use App\Models\ParamListValue;

class ProductsTypesController extends BaseController {
    function table(){
        $this->menu->active = 'a_types';

        return view('admin.products.types.table', [
            'lists' => ParamList::orderBy('id')->get(),
            'types' => ParamList::TYPES
        ]);
    }

    function listValues(ParamList $paramList){
        $this->menu->active = 'a_types';

        return view('admin.products.types.list', [
            'list' => $paramList,
            'types' => ParamList::TYPES
        ]);
    }

    /**** AJAX  ****/
    function create(){
        request()->validate([
            'caption' => 'required'
        ]);

        $paramList = ParamList::create([
            'caption' => request('caption'),
            'type_values' => request('type_list')
        ]);

        return json_encode(['ok'=>true, 'list'=>$paramList]);
    }

    function rename(){
        request()->validate([
            'idList' => 'required|integer',
            'caption' => 'required',
            'type_list' => 'required|integer'
        ]);

        $paramList = ParamList::find(request('idList'));
        if($paramList)
            $paramList->forceFill([
                'caption' => request('caption'),
                'type_values' => request('type_list')
            ])->save();
        else
            return '{"error":"Отсутствует указанный лист"}';

        return json_encode(['ok'=>true, 'list'=>$paramList]);
    }

    function delete(){
        request()->validate([
            'idList' => 'required|integer'
        ]);

        $list = ParamList::find(request('idList'));
        if($list){
            if($list->hasUsed())
                return '"error":"Лист используется в характеристиках"';
            // DELETE FORM param_list_values WHERE list_id = ?
            ParamListValue::where('list_id', $list->id)->delete();
            $list->delete();

            return '{"ok":true}';
        }

        return '{"error":"Нет указанного листа"}';
    }

    /*====================*/

    function listValueAdd(ParamList $paramList){
        request()->validate([
            'value' => 'required'
        ]);

        $value = request('value');
        if($paramList->hasValueItem($value))
            return '{"error":"Такой элемент листа уже есть"}';

        $item = $paramList->addValue($value);
        return '{"ok":true, "item":{"id":'.$item->id.', "value":"'.$item->value.'"}}';
    }

    function listValueUpdate(ParamList $paramList){
        request()->validate([
            'id' => 'required|integer',
            'value' => 'required'
        ]);

        $item = ParamListValue::find(request('id'));
        if(!$item)
            return '{"error":"Нет такого значения"}';

        $value = request('value');
        if($paramList->hasValueItem($value))
            return '{"error":"Такой элемент листа уже есть"}';

        $item->value = $value;
        $item->save();
        return '{"ok":true, "item":{"id":'.$item->id.', "value":"'.$item->value.'"}}';
    }

    function listValueDelete(ParamList $paramList){
        request()->validate([
            'id' => 'required|integer',
            'value' => 'required'
        ]);

        $paramList->delValue(request('value'));
        return '{"ok":true}';
    }
}
