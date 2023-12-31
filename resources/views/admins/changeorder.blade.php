@extends('layouts.admins')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-5 d-inline">Change status</h5>
                    <p>Current status is <b>{{ $order->status }}</b></p>
                    <form method="POST" action="{{ route('update.order', $order->id) }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Email input -->


                        <div class="form-outline mb-4 mt-4">

                            <select name="type" class="form-select  form-control" aria-label="Default select example">
                                <option selected>Choose Type</option>
                                <option value="Processing">Processing</option>
                                <option value="Delivered">Delivered</option>
                            </select>
                        </div>

                        <br>



                        <!-- Submit button -->
                        <button type="submit" name="submit" class="btn btn-primary  mb-4 text-center">create</button>


                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection