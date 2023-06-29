@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                        <a class="btn btn-sm btn-success"
                        href="{{ route('game-management.index') }}">Back</a>
                        <b>Game Management</b>
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
                    <p style="margin-left: 71.5%;">
                        <a class="btn btn-primary float-right" href="{{ route('game-management.create') }}"><span
                                class="glyphicon glyphicon-plus"></span> Add Game</a>
                    </p>
                </div>

                <div class="row mb-2">
                    <table class="table table-bordered table-hover home-page-table">
                        <thead>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </thead>
                        <tbody style="background-color: white;">
                            @if ($games->count() == 0)
                                <tr>
                                    <td colspan="8">No games</td>
                                </tr>
                            @endif

                            @foreach ($games as $game)
                                <tr>
                                    <td>{{ $game->name }}</td>
                                    <td>{{ $game->description }}</td>
                                    <td>{{ $game->category }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-success"
                                            href="{{ route('game-management.edit', $game->id) }}">Modify</a>

                                        @if ($game->status)
                                            <form style="display:inline-block"
                                                action="{{ route('game.hide', $game->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="padding: 4px 12px;"
                                                    onclick="return confirm('Are you sure want to hide {{ $game->name }}?')">Active</button>
                                            </form>
                                        @else
                                            <form style="display:inline-block"
                                                action="{{ route('game.unhide', $game->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="background-color: darkred;"
                                                    onclick="return confirm('Are you sure want to show {{ $game->name }}?')">Inactive</button>
                                            </form>
                                        @endif

                                        <form style="display:inline-block"
                                                action="{{ route('game-management.destroy', $game->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="padding: 4px 12px; background-color: darkred;"
                                                    onclick="return confirm('Are you sure want to delete {{ $game->name }}?')">Delete</button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $games->links() }}
                    <p>
                        Displaying {{ $games->count() }} of {{ $games->total() }} game(s).
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
