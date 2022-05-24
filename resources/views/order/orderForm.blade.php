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

                    <form action="{{ route('addNewOrder') }}" method="post" enctype="multipart/form-data" class="">
                        @csrf
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sr.no.</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; $total = 0; ?>
                                @foreach($products as $product)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td><img src="{{ URL::to('/') }}/images/{{ $product->image }}" height="100" width="100"></td>
                                    <td>{{ $product->title }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>
                                        <a href="{{ route('removeProduct',['id'=>$product->id]) }}" class="btn btn-primary">Remove</a>
                                    </td>
                                </tr>
                                <?php $i++; $total = $total + $product->price; ?>
                                @endforeach

                                <tr>
                                    <td colspan="4">Total:</td>
                                    <td colspan="2">{{ $total }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" class="form-control" name="address" id="address">
                            <input type="hidden" class="form-control" name="total" id="total" value="{{ $total }}">
                        </div>
                         @error('address')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
