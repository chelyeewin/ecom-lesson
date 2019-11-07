@extends('layouts.app')
@section('title') Shopping Cart @stop

@section('content')


    <div class="container mt-5">
        <div>
            <i class="fas fa-shopping-cart"></i> Shopping Cart
        </div>
        <div class="dropdown-divider"></div>
        <div class="row">
            <div class="col-sm-8">
                <table class="table table-hover table-borderless">
                    <tr>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Amount</th>
                    </tr>
                    @if(Session::has('cart'))
                        @foreach(Session::get('cart')->posts as $items)
                            <tr>
                                <td>{{$items['post']['item_name']}}</td>
                                <td>{{$items['post']['price']}}</td>
                                <td>
                                    <a href="{{route('decrease.cart',['id'=>$items['post']['id']])}}" class="btn btn-outline-info btn-sm"><i class="fas fa-minus-circle"></i></a>
                                    <span class="btn btn-outline-success rounded-circle">{{$items['qty']}}</span>
                                    <a href="{{route('increase.cart',['id'=>$items['post']['id']])}}" class="btn btn-outline-info btn-sm"><i class="fas fa-plus-circle"></i></a>
                                </td>
                                <td>{{$items['amount']}}</td>
                            </tr>

                            @endforeach
                            <tr>
                                <td colspan="3" class="text-right">Total Qty</td>
                                <td>{{Session::get('cart')->totalQty}}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">Total Amount</td>
                                <td>{{Session::get('cart')->totalAmount}}</td>
                            </tr>
                        @else
                        <td colspan="4">
                            <div class="alert alert-danger">
                                Empty item cart.
                            </div>
                        </td>
                        @endif

                </table>
                <a href="{{route('/')}}"><i class="fas fa-shopping-basket"></i> Continuous Shopping</a>
            </div>
            <div class="col-sm-4">
                @if(Auth::User())
                @if((Session::has('cart'))&&(Auth::User()->hasAnyRole(['Member'])))
                    <p class="text-danger">
                        The field with star is all required to fill.
                    </p>
                    <form method="post" action="{{route('checkout')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="phone">Phone *</label>
                            <input type="tel" name="phone" id="phone" class="form-control">
                            @if($errors->has('phone')) <span class="text-danger">{{$errors->first('phone')}}</span> @endif
                        </div>
                        <div class="form-group">
                            <label for="address">Address *</label>
                            <textarea name="address" id="address" class="form-control"></textarea>
                            @if($errors->has('address')) <span class="text-danger">{{$errors->first('address')}}</span> @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Checkout</button>
                        </div>
                    </form>
                    @else
                        <p>
                            Please contact to Web site administrator
                        </p>
                        <a href="tel:09450946433"><i class="fas fa-phone"></i> Call Now.</a>
                    @endif


                    @endif

            </div>
        </div>
    </div>
@stop
