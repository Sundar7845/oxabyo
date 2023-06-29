@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                        <b>Team Management</b>
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
                        <a class="btn btn-primary float-right" href="{{ route('team-management.create') }}"><span
                                class="glyphicon glyphicon-plus"></span> Add Team</a>
                    </p>
                </div>

                <div class="row mb-2">
                    <table class="table table-bordered table-hover home-page-table">
                        <thead>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Team Admin</th>
                            <th>Game</th>
                            <th>Actions</th>
                        </thead>
                        <tbody style="background-color: white;">
                            @if ($teams->count() == 0)
                                <tr>
                                    <td colspan="8">No teams</td>
                                </tr>
                            @endif

                            @foreach ($teams as $team)
                                <tr>
                                    <td>{{ $team->name }}</td>
                                    <td>{{ substr($team->description,0,50) }}</td>
                                    <td>{{ $team->users->name ?? '' }}</td>
                                    <td>{{ $team->games->name ?? '' }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-success"
                                            href="{{ route('team-management.edit', $team->id) }}">Modify</a>

                                        @if ($team->status)
                                            <form style="display:inline-block"
                                                action="{{ route('team.hide', $team->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="padding: 4px 12px;"
                                                    onclick="return confirm('Are you sure want to hide {{ $team->name }}?')">Active</button>
                                            </form>
                                        @else
                                            <form style="display:inline-block"
                                                action="{{ route('team.unhide', $team->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="background-color: darkred;"
                                                    onclick="return confirm('Are you sure want to show {{ $team->name }}?')">Inactive</button>
                                            </form>
                                        @endif

                                        <form style="display:inline-block"
                                                action="{{ route('team-management.destroy', $team->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="padding: 4px 12px; background-color: darkred;"
                                                    onclick="return confirm('Are you sure want to delete {{ $team->name }}?')">Delete</button>
                                        </form>

                                        <a class="btn btn-sm btn-success"
                                            href="{{ route('team-management.members', $team->id) }}">Manage Members</a>

                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $teams->links() }}
                    <p>
                        Displaying {{ $teams->count() }} of {{ $teams->total() }} teams(s).
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
