@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                        {{-- <a class="btn btn-sm btn-success"
                        href="{{ route('user-management.index') }}">Back</a> --}}
                        <b>User Management</b>
                    </div><!-- /.col -->
                </div>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="row mb-2">
                    <form class="inbox_search-form" method="get" style="width: 20%; !important">
                        <input type="text" class="form-control" placeholder="Search by name or email" id="search" name="search"
                            value="{{ $search }}" />
                        <button type="submit" class="hidden">Search</button>
                    </form>
                    <p style="margin-left:  72%;">
                        <a class="btn btn-primary float-right" href="{{ route('user-management.create') }}"><span
                                class="glyphicon glyphicon-plus"></span> Add User</a>
                    </p>
                </div>
                    <div class="row mb-2">
                    <table class="table table-bordered table-hover home-page-table">
                        <thead >
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Email</th>
                            <th>User Role</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </thead>
                        <tbody style="background-color: white;">
                            @if ($users->count() == 0)
                                <tr>
                                    <td colspan="5">No users</td>
                                </tr>
                            @endif

                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->surename }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->roles->name  }}</td>
                                    <td>{{ $user->address }}</td>

                                    <td>
                                        <a class="btn btn-sm btn-success"
                                            href="{{ route('user-management.edit', $user->id) }}">Modify</a>

                                        @if (!$user->user_blocked_status)
                                            <form style="display:inline-block"
                                                action="{{ route('user.block', $user->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="padding: 4px 12px;" onclick="return confirm('Are you sure want to block {{$user->name}}?')">Active</button>
                                            </form>
                                        @else
                                            <form style="display:inline-block"
                                                action="{{ route('user.unblock', $user->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="background-color: darkred;" onclick="return confirm('Are you sure want to unblock {{$user->name}}?')">Inactive</button>
                                            </form>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $users->links() }}

                    <p>
                        Displaying {{ $users->count() }} of {{ $users->total() }} user(s).
                    </p>

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    </div>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
