@extends('layouts.app')

@section('title','Products')

@section('content')
<div class="section">
    <div class="row mb-2">
        <div class="col s12">
            <a href="{{ route('products.create') }}" class="btn">
                <i class="material-icons left">add</i> Add Product
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="card green lighten-4 green-text text-darken-4">
        <div class="card-content">{{ session('success') }}</div>
    </div>
    @endif

    <div class="card">
        <div class="card-content">
            <span class="card-title">Product List</span>
            <table class="highlight responsive-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Regency</th>
                        <th>Categories</th>
                        <th>Price</th>
                        <th class="center-align">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            @if($product->images->first())
                                <img src="{{ asset('storage/' . $product->images->first()->path) }}" 
                                    alt="{{ $product->title }}" 
                                    style="width:60px; height:60px; object-fit:cover; border-radius:6px;">
                            @else
                                <span class="grey-text">No Image</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ $product->url }}" target="_blank">
                                {{ $product->title }}
                            </a>
                        </td>
                        <td>{{ $product->regency->name ?? '-' }}</td>
                        <td>
                            @if($product->category)
                            <span class="new badge" data-badge-caption="">{{ $product->category->name }}</span>
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td class="center-align">
                            <a href="{{ route('products.edit', $product) }}" class="btn-small blue">
                                <i class="material-icons">edit</i>
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-small red" onclick="return confirm('Delete this product?')">
                                    <i class="material-icons">delete</i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection