@extends('layouts.admins')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 d-inline">Orders</h5>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">first_name</th>
                                <th scope="col">last_name</th>
                                <th scope="col">state</th>
                                <th scope="col">address</th>
                                <th scope="col">city</th>
                                <th scope="col">zip_code</th>
                                <th scope="col">phone</th>
                                <th scope="col">email</th>
                                <th scope="col">total_price</th>
                                <th scope="col">status</th>
                                <th scope="col">Change Status</th>
                                <th scope="col">delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <th scope="row">{{ $order->id }}</th>
                                <td>{{ $order->frist_name }}</td>
                                <td>{{ $order->last_name }}</td>
                                <td>{{ $order->state }}</td>
                                <td>{{ $order->address }}</td>
                                <td>{{ $order->city }}</td>
                                <td>{{ $order->zip_code }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>{{ $order->email }}</td>
                                <td>${{ $order->price }}</td>

                                <td>{{ $order->status }}</td>
                                <td><a href="{{ route('change.order', $order->id) }}" class="btn btn-warning  text-center ">change</a></td>

                                <td><a href="{{ route('delete.order', $order->id) }}" class="btn btn-danger  text-center ">delete</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



</div>

@endsection