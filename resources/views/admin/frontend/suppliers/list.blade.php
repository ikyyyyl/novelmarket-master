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
                        <td>{{ $supplier->supplier_name }}</td>
                        <td>{{ $supplier->contact_number }}</td>
                        <td>{{ $supplier->address }}</td>
                        <td>
                            @if ($supplier->image_path)
                            <img src="{{ asset('images/users/' . $supplier->image_path) }}" alt="Supplier Image" width = "160" height = "160">
                            @else
                            No Image
                            @endif
                        </td>
                        <td>{{ $supplier->prod_id }}</td>
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
