@extends('checkout.master')

@section('message')
<div>
    <i class="fa fa-check" aria-hidden="true" style="color: green;"></i>
    <span style="color: black;">Thanh toán thành công!</span>
</div>
<div style="margin-top: 1em">
    <div>
        <span>Đơn hàng: </span>
        <span>{!! $order['code'] !!}</span>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>STT</th>
                <th>Loại rau</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order['items'] as $item)
                <tr>
                    <th scope="row">1</th>
                    <td>{!! $item['vegetables_in_store']['vegetable']['name'] !!}</td>
                    <td>{!! $item['quantity'] !!}</td>
                    <td>{!! number_format($item['vegetables_in_store']['price'], 0, ',', '.') !!}</td>
                    <td>{!! number_format($item['vegetables_in_store']['price'] * $item['quantity'], 0, ',', '.') !!}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <span>Tổng tiền: </span>
        <span>{!! number_format($order['total_price'], 0, ',', '.') !!}</span>
        <span>Đồng</span>
    </div>
</div>
@endsection

