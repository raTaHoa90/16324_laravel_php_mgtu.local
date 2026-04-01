<?php

namespace App\Http\Controllers\Admin;

use App\Models\OrderRecord;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends BaseController {

    function table(){
        $this->menu->active = 'orders';
        return view('admin.orders.table',[
            'orders' => OrderRecord::OrderBy('status','DESC')->OrderBy('id','DESC')->paginate(20)
        ]);
    }

    function setStatus(OrderRecord $orderRecord){
        $user = Auth::user();
        if($user === null)
            return back();

        /**
         * @var User $user
         */
        $status = $_GET['status'] ?? '';
        $status = match($status){
            'work'   => $user->can('status-set-work',   $orderRecord) ? OrderRecord::STATUS_WORK   : false,
            'travel' => $user->can('status-set-travel', $orderRecord) ? OrderRecord::STATUS_TRAVEL : false,
            'apply'  => $user->can('status-set-apply',  $orderRecord) ? OrderRecord::STATUS_APPLY  : false,
            'cancel' => $user->can('status-set-cancel', $orderRecord) ? OrderRecord::STATUS_CANCEL : false,
            default  => false
        };

        if($status === false)
            return back();

        $orderRecord->status = $status;
        $orderRecord->save();
        return back();
    }

}
