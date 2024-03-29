@extends('admin.layouts.app')

@section('title', 'Admin - Suppliers')

@section('content')
{{-- Suppliers table start --}}
<div class="col-12 mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">List of Suppliers</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Supplier Name</th>
                        <th>Contact Number</th>
                        <th>Address</th>
                        <th>Image</th>
                        <th>Product ID</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($suppliers as $supplier)
                    <tr>
                        <th>{{ $supplier->supplier_name }}</th>
                        <th>{{ $supplier->contact_number }}</th>
                        <th>{{ $supplier->address }}</th>
                        <th>
                            @if ($supplier->image_path)
                            <img src="{{ asset($supplier->image_path) }}" alt="Supplier Image" style="max-width: 100px; max-height: 100px;">
                            @else
                            No Image
                            @endif
                        </th>
                        <th>{{ $supplier->prod_id }}</th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination Links -->
<div class="mt-3">
    {{ $suppliers->links() }}
</div>
<!-- Suppliers table end -->
@endsection
