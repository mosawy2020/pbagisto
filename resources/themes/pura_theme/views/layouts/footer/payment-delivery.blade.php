{{-- <ul class="payment-methods">
  @foreach (\Webkul\Payment\Facades\Payment::getPaymentMethods() as $method)
    <li class="method-sticker">
      <img src="{{ url('/themes/pura_theme/assets/images/payment/' . $method['method'] . '.png') }}" alt="{{ $method['method_title'] }}">
    </li>
  @endforeach

  @foreach (\Webkul\Shipping\Facades\Shipping::getShippingMethods() as $method)
    <li class="method-sticker">
      <img src="{{ url('/themes/pura_theme/assets/images/payment/' . $method['method'] . '.png') }}" alt="{{ $method['method_title'] }}">
    </li>
  @endforeach

</ul> --}}
<img class="lazyload" data-src="{{ url('/themes/pura_theme/assets/images/payment.png') }}" alt="payment">
