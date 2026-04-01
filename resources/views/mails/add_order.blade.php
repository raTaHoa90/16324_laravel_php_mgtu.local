<!DOCTYPE html>
<html>
<body>
    <H2>Заказ № {{$orderID}} оформлен {{$order->created_at->format('d.m.Y в H:i:s')}}</H2>

    Всего заказано: {{$order->count_products}} товара<br>
    Общая стоимость заказа: {{$order->sum_price}} руб.<br>
    Адрес доставки: {{$order->address}}<br>
    {{strtr($order->other, ["\n" => '<br>'])}}
    <br><br>
    Товары заказа:
    <table>
        <tr>
            <th>Название</th>
            <th>кол-во</th>
            <th>стоимость</th>
        </tr>
        @foreach($order->products() as $prod)
        <tr> @php($product = $prod->product())
            <td>{{$product->caption}}</td>
            <td>{{$prod->count_product}} шт.</td>
            <td>{{$product->price * $prod->count_product}} руб.</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
