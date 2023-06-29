@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                        <b>Event Management</b>
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
                        <a class="btn btn-primary float-right" href="{{ route('event-management.create') }}"><span
                                class="glyphicon glyphicon-plus"></span> Add Event</a>
                    </p>
                </div>

                <div class="row mb-2">
                    <table class="table table-bordered table-hover home-page-table">
                        <thead>
                            <th>Name</th>
                            <th>Players Type</th>
                            <th>Match Date</th>
                            <th>Match Hour</th>
                            <th>Game</th>
                            <th>Prize Money</th>
                            <th>Ticket</th>
                            <th>Actions</th>
                        </thead>
                        <tbody style="background-color: white;">
                            @if ($events->count() == 0)
                                <tr>
                                    <td colspan="8">No events</td>
                                </tr>
                            @endif

                            @foreach ($events as $event)
                                <tr>
                                    <td>{{ $event->name }}</td>
                                    <td>{{ $event->player_types->name ?? '' }}</td>
                                    <td>{{ $event->match_date }}</td>
                                    <td>{{ $event->match_hour }}</td>
                                    <td>{{ $event->games->name ?? '' }}</td>
                                    <td>{{ $event->prize_money }}</td>
                                    <td>{{ $event->ticket }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-success"
                                            href="{{ route('event-management.edit', $event->id) }}">Modify</a>

                                        @if ($event->status)
                                            <form style="display:inline-block"
                                                action="{{ route('event.hide', $event->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="padding: 4px 12px;"
                                                    onclick="return confirm('Are you sure want to hide {{ $event->name }}?')">Active</button>
                                            </form>
                                        @else
                                            <form style="display:inline-block"
                                                action="{{ route('event.unhide', $event->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="background-color: darkred;"
                                                    onclick="return confirm('Are you sure want to show {{ $event->name }}?')">Inactive</button>
                                            </form>
                                        @endif

                                        <form style="display:inline-block"
                                                action="{{ route('event-management.destroy', $event->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="padding: 4px 12px; background-color: darkred;"
                                                    onclick="return confirm('Are you sure want to delete {{ $event->name }}?')">Delete</button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $events->links() }}
                    <p>
                        Displaying {{ $events->count() }} of {{ $events->total() }} event(s).
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
