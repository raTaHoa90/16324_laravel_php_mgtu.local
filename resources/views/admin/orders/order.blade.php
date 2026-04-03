@extends('admin.base_template')


@section('content')
    <a href="/admin/orders" class="btn btn-light"><i class="fa fa-arrow-left"></i> Назад к таблице заказов</a><br><br>
    <section>
        <table class='r-t'>
            <tr>
                <td>#</td>
                <td>{{$order->id}}</td>
            </tr>
            <tr>
                <td>Почта покупателя</td>
                <td><a href="mailto:{{$order->email}}">{{$order->email}}</a></td>
            </tr>
            <tr>
                <td>Текущий статус</td>
                <td>{{$order->getStatus()}} </td>
                <td>
                    @can('status-set-work', $order)
                        <a class="btn btn-primary" href="/admin/orders/{{$order->id}}/set-status?status=work">Взять в работу</a>
                    @elsecan('status-set-travel', $order)
                        <a class="btn btn-primary" href="/admin/orders/{{$order->id}}/set-status?status=travel">Отправлен курьером</a>
                    @elsecan('status-set-apply', $order)
                        <a class="btn btn-primary" href="/admin/orders/{{$order->id}}/set-status?status=apply">Доставлен</a>
                    @endcan
                    @can('status-set-cancel', $order)
                        <a class="btn btn-danger" href="/admin/orders/{{$order->id}}/set-status?status=cancel">Отменен</a>
                    @endcan
                </td>
            </tr>
            <tr>
                <td>Общая сумма заказа</td>
                <td>{{$order->sum_price}}</td>
            </tr>
            <tr>
                <td>Дата заказа</td>
                <td>{{$order->created_at->format('d.m.Y')}}</td>
            </tr>
            <tr>
                <td>Адрес доставки</td>
                <td>{{$order->address}}</td>
            </tr>
            <tr>
                <td>Примечание от покупателя</td>
                <td>{!! strtr($order->other, ["\n"=>'<br>']) !!}</td>
            </tr>
        </table>

        Товары заказа:
        <table class="table">
            <tr>
                <th>Название</th>
                <th>кол-во</th>
                <th>стоимость</th>
            </tr>
            @foreach($order->products() as $prod)
            <tr> @php($product = $prod->product())
                <td><a href="/products/{{$product->saf}}" target="_blank">{{$product->caption}}</a></td>
                <td>{{$prod->count_product}} шт.</td>
                <td>{{$product->price * $prod->count_product}} руб.</td>
            </tr>
            @endforeach
        </table>
    </section>
@endsection
