@extends('admin.base_template')


@section('content')
    <section>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>email</th>
                    <th>Кол-во тавара</th>
                    <th>Статус</th>
                    <th>Стоимость</th>
                    <th>Дата заказа</th>
                    <th>Адрес заказа</th>
                    <th>Комментарий в заказе</th>
                    <th>
                        <i class="fa fa-cog"></i>
                    </th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($orders as $order)
                <tr>
                    <td><a href="/admin/orders/{{$order->id}}">{{$order->id}}</a></td>
                    <td>{{$order->email}}</td>
                    <td style="text-align: right">{{$order->count_products}}</td>
                    <td>{{$order->getStatus()}}</td>
                    <td style="text-align: right">{{$order->sum_price}}</td>
                    <td>{{$order->created_at->format('d.m.Y')}}</td>
                    <td>{{$order->address}}</td>
                    <td>{!! strtr($order->other, ["\n"=>'<br>']) !!}</td>
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
                @endforeach
            </tbody>
        </table>
        {{ $orders->links() }}
    </section>
@endsection
