<x-mail::message>
<h3>جزییات سفارش</h3>
سفارش شما با شماره 
{{$order->id}}
ثبت شد.

لیست سفارش های شما به صورت زیر میباشد : 
<ul>
@foreach ($order->products as $product)
<li>{{$product->title}}</li> 
@endforeach
</ul>

تشکر از خرید و اعتماد شما,<br>
{{ config('app.name') }}
</x-mail::message>
