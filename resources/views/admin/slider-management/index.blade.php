@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                        <b>Slider Management</b>
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
                        <a class="btn btn-primary float-right" href="{{ route('slider-management.create') }}"><span
                                class="glyphicon glyphicon-plus"></span> Add Slide</a>
                    </p>
                </div>

                <div class="row mb-2">
                    <table class="table table-bordered table-hover home-page-table">
                        <thead>
                            <th>Event Name</th>
                            <th>Game</th>
                            <th>Players Type</th>
                            <th>Date</th>
                            <th>Ticket</th>
                            <th>Prize Money</th>
                            <th>Slider Position</th>
                            <th>Actions</th>
                        </thead>
                        <tbody style="background-color: white;">
                            @if ($sliders->count() == 0)
                                <tr>
                                    <td colspan="8">No sliders</td>
                                </tr>
                            @endif

                            @foreach ($sliders as $slider)
                                <tr>

                                    <td>{{ $slider->events->name ?? '' }}</td>
                                    <td>{{ $slider->events->games->name ?? '' }}</td>
                                    <td>{{ $slider->events->player_types->name ?? '' }}</td>
                                    <td>{{ $slider->events->match_date ?? ''}}</td>    
                                    <td>{{ $slider->events->ticket ?? '' }}</td>                               
                                    <td>{{ $slider->events->prize_money ?? '' }}</td>
                                    <td>{{ $slider->position ?? '' }}</td>
                                    


                                    <td>
                                        {{-- <a class="btn btn-sm btn-success"
                                            href="{{ route('slider-management.edit', $slider->id) }}">Modify</a> --}}

                                       

                                        <form style="display:inline-block"
                                                action="{{ route('slider-management.destroy', $slider->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="padding: 4px 12px; background-color: darkred;"
                                                    onclick="return confirm('Are you sure want to delete {{ $slider->title }}?')">Delete</button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $sliders->links() }}
                    <p>
                        Displaying {{ $sliders->count() }} of {{ $sliders->total() }} slider(s).
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
