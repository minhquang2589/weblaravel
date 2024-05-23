<div>
   <h2>Order Details:</h2>
   @foreach($cart as $item)
   <div>
      <p>{{ $item['name'] }} - {{ $item['color'] }} - {{ $item['size'] }} x {{ $item['quantity'] }}</p>
      <p>Price: {{ number_format($item['price'] / 1000, 3, ',', ',') }}đ
         @if (isset($item['discountPercent'])&& $item['discountPercent']>0) - {{$item['discountPercent']}}% @endif
      </p>
   </div>
   @endforeach
   <p> @if (isset($DETACheckout['VoucherValue'])&& $DETACheckout['VoucherValue']>0) Voucher: - {{$DETACheckout['VoucherValue']}}% @endif
   </p>
   <p> @if (isset($DETACheckout['totalDiscountAmount'])&& $DETACheckout['totalDiscountAmount']>0) Total discount: -{{ number_format($DETACheckout['totalDiscountAmount']/ 1000, 3, ',', ',') }}đ @endif
   </p>
   <ul>
      <li>Order number: <strong>{{ $orderNumber }}</strong></li>
      <li>Date: <strong>{{ $orderDate }}</strong></li>
      <li>Total price: <strong>{{ number_format($DETACheckout['checkoutSubtotal']/ 1000, 3, ',', ',') }}đ</strong></li>
      <li>Payment method: <strong>{{ $element['payment'] }}</strong></li>
   </ul>
   <div>
      <strong>
         We will ship upon successful order confirmation.
      </strong>
   </div>
   <div>
      <strong>
         Thank You!
      </strong>
   </div>
</div>