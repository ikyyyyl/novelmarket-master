@extends('admin.layouts.app')

@section('title' , 'Admin-Users')

@section('content')
<!-- Users list start -->
<div class="main-content-inner">
    <div class="row">
        <table class="table">
            <thead class="table-dark">
              <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Number</th>
                <th>Address</th>
                <th>Image</th>
                <th>Joined</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
                <tr>
                  <th>{{ $user->id }}</th>
                  <th>{{ $user->name }}</th>
                  <th>{{ $user->email }}</th>
                  <th>{{ $user->role }}</th>
                  <th>{{ $user->phone_number }}</th>
                  <th>{{ $user->address }}</th>
                  <th>
                  <img src="{{ asset('storage/' . $user->image_path) }}" alt="Profile Image" width="160" height="160">
           </th>
                  <th>{{ $user->created_at }}</th>
                  <th>{{ $user->is_active ? 'Active' : 'Inactive' }}</th>
                  <th>
                      @if($user->is_active)
                        <form action="{{ route('admin.users.deactivate', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                          <button type="submit" class="btn btn-danger">Deactivate</button>
                        </form>
                      @else
                        <span class="text-muted">Deactivated</span>
                      @endif
                  </th>
                  <th>
                    <form action="{{ route('admin.users.destroy' , $user->id ) }}" method="POST" id="prepare-form">
                      @csrf
                      @method('delete')
                        <button type="submit" id="button-delete"><span class="ti-trash"></span></button>
                    </form>
                    <a href="{{ route('admin.users.edit' , $user->id) }}" id="a-black"><span class="ti-pencil"></span></a>
                  </th>
                </tr>
              @endforeach
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            {{ $users->links() }}
          </ul>
        </nav>  
    </div>
</div>
<!-- Users list end -->
@endsection

