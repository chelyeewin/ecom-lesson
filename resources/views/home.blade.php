@extends('layouts.app')

@section('content')
@if(Auth::User()->hasRole(['Admin']))
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-2"><i class="fas fa-tachometer-alt"></i> Dashboard</div>
        </div>
        <div class="dropdown-divider mb-3"></div>
        <div class="row">
            <div class="col-sm-6 mb-5">
                <div class="card shadow">
                    <div class="card-body">
                        <span><i class="fas fa-tags"></i> Posts</span>
                        <span class="float-right btn btn-outline-info rounded-circle">{{count($posts)}}</span>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-block btn-link bg-info text-white" href="{{route('posts')}}">More >></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mb-5">
                <div class="card shadow">
                    <div class="card-body">
                        <span><i class="fas fa-list-alt"></i> Categories</span>
                        <span class="float-right btn btn-outline-info rounded-circle">{{count($cats)}}</span>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-block btn-link bg-info text-white" href="{{route('posts.categories')}}">More >></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card shadow">
                    <div class="card-body">
                        <span><i class="fas fa-jedi-order"></i> Orders</span>
                        <span class="float-right btn btn-outline-info rounded-circle">{{count($orders)}}</span>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-block btn-link bg-info text-white" href="{{route('orders')}}">More >></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card shadow">
                    <div class="card-body">
                        <span><i class="fas fa-users-cog"></i> Users</span>
                        <span class="float-right btn btn-outline-info rounded-circle">{{count($users)}}</span>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-block btn-link bg-info text-white" href="{{route('users')}}">More >></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-2"><i class="fas fa-user-astronaut"></i> My Orders</div>
            <div class="col-sm-4">
                <form id="form_filter_by_date" method="get" action="{{route('filter_by_date')}}">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Filter By Date</div>
                            </div>
                            <input type="date" id="filter_by_date" class="form-control" name="filter_by_date">
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-sm-4">
                <form id="form_filter_by_month" method="get" action="{{route('filter_by_month')}}">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">Filter By Month</div>
                            </div>
                            <select name="filter_by_month" id="filter_by_month" class="form-control">
                                <option value="">Select Month</option>
                                <option value="2019-01">Jan 2019</option>
                                <option value="2019-02">Feb 2019</option>
                                <option value="2019-11">Nov 2019</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="dropdown-divider"></div>

        <div class="accordion" id="accordionExample">
            @foreach($orders as $od)
                <div class="card">
                    <div class="card-header @if($od->status==1) bg-success @endif" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed  @if($od->status==1) text-white @endif" type="button" data-toggle="collapse" data-target="#c{{$od->id}}" aria-expanded="false" aria-controls="collapseTwo">
                                <i class="fas fa-caret-down"></i> Order ID : {{$od->id}}
                            </button>
                        </h2>
                    </div>
                    <div id="c{{$od->id}}" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3" style="border-right: 2px solid orangered">
                                    <p>
                                        <i class="fas fa-user"></i> Name : {{$od->user->name}}
                                    </p>
                                    <p>
                                        <i class="fas fa-envelope-open"></i> Email : {{$od->user->email}}
                                    </p>
                                    <p>
                                        <i class="fas fa-phone"></i> Phone : {{$od->phone}}
                                    </p>
                                    <p>
                                        <i class="fas fa-map-marked-alt"></i> Address : {{$od->address}}
                                    </p>
                                    <p>
                                        <i class="fas fa-calendar-alt"></i> Date : {{$od->created_at}}
                                    </p>
                                </div>
                                <div class="col-sm-9">
                                    <table class="table table-borderless table-hover">
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Amount</th>
                                        </tr>
                                        <?php $totalAmount=0; ?>
                                        @foreach($od->orderitem as $i)
                                            <?php $totalAmount += $i->amount; ?>
                                            <tr>
                                                <td>{{$i->item_name}}</td>
                                                <td>{{$i->price}}</td>
                                                <td>{{$i->qty}}</td>
                                                <td>{{$i->amount}}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="3" class="text-right">Total Amount</td>
                                            <td>{{$totalAmount}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    @endif
@endsection
