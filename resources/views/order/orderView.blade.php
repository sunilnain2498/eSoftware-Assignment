@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div>Welcome {{ $user->name }}, You are logged in!</div>

                    <a href="{{ route('home') }}" class="btn btn-primary">Home</a>
                    <a href="{{ route('orders') }}" class="btn btn-primary">Go To Orders</a>
                    <div>
                        <h4>Total: {{ $order->total }}</h4>
                        <h4>Address: {{ $order->address }}</h4>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sr.no.</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $i }}</td>
                                <td><img src="{{ URL::to('/') }}/images/{{ $product->image }}" height="100" width="100"></td>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->price }}</td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
