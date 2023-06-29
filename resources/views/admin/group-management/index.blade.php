@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                        <b>Group Management</b>
                    </div>
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
                        <input type="text" class="form-control" placeholder="Search by name" id="search" name="search"
                            value="{{ $search }}" />
                        <button type="submit" class="hidden">Search</button>
                    </form>
                    <p style="margin-left: 70.5%;">
                        <a class="btn btn-primary float-right" href="{{ route('group-management.create') }}"><span
                                class="glyphicon glyphicon-plus"></span> Add Group</a>
                    </p>
                </div>

                <div class="row mb-2">
                    <table class="table table-bordered table-hover home-page-table">
                        <thead>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Group Admin</th>
                            <th>Game</th>
                            <th>Actions</th>
                        </thead>
                        <tbody style="background-color: white;">
                            @if ($groups->count() == 0)
                                <tr>
                                    <td colspan="8">No groups</td>
                                </tr>
                            @endif

                            @foreach ($groups as $group)
                                <tr>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->description }}</td>
                                    <td>{{ $group->users->name ?? '' }}</td>
                                    <td>{{ $group->games->name ?? '' }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-success"
                                            href="{{ route('group-management.edit', $group->id) }}">Modify</a>

                                        @if ($group->status)
                                            <form style="display:inline-block"
                                                action="{{ route('group.hide', $group->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="padding: 4px 12px;"
                                                    onclick="return confirm('Are you sure want to hide {{ $group->name }}?')">Active</button>
                                            </form>
                                        @else
                                            <form style="display:inline-block"
                                                action="{{ route('group.unhide', $group->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="background-color: darkred;"
                                                    onclick="return confirm('Are you sure want to show {{ $group->name }}?')">Inactive</button>
                                            </form>
                                        @endif

                                        <form style="display:inline-block"
                                                action="{{ route('group-management.destroy', $group->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="padding: 4px 12px; background-color: darkred;"
                                                    onclick="return confirm('Are you sure want to delete {{ $group->name }}?')">Delete</button>
                                        </form>


                                        <a class="btn btn-sm btn-success"
                                            href="{{ route('group-management.members', $group->id) }}">Manage Members</a>

                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $groups->links() }}
                    <p>
                        Displaying {{ $groups->count() }} of {{ $groups->total() }} group(s).
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
