{{--
    $product - модель товара
--}}
<div onclick="location='/products/{{$product->saf}}'">
    @php($img = $product->firstImage())
    <b>{{$product->caption}}</b><br>
    @if($img != '')
        <img src="/imgs/{{$img}}"><br>
    @endif
    <i>{{$product->price}} руб.</i><br>
    <input class="btn btn-success" type="button" value="Добавить в корзину" onclick="addProduct({{$product->id}}); return cancel(event);">
</div>
