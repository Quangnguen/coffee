@extends('layouts.admins')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 d-inline">Foods</h5>
                    <a href="{{ route('create.product') }}" class="btn btn-primary mb-4 text-center float-right">Create Products</a>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">name</th>
                                <th scope="col">image</th>
                                <th scope="col">price</th>
                                <th scope="col">description</th>
                                <th scope="col">type</th>
                                <th scope="col">delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <th scope="row">{{ $product->id }}</th>
                                <td>{{ $product->name }}</td>
                                <td>
                                    <img style="
                                    width: 40px;
                                    height: 40px;
                                    " src="{{ asset('assets/image/'.$product->image.'') }}">
                                </td>
                                <td>${{ $product->price }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->type }}</td>
                                <td><a href="{{ route('delete.product', $product->id) }}" class="btn btn-danger  text-center ">delete</a></td>
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