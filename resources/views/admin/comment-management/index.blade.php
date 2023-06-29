@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                        <b>Comment Management</b>
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
                    {{-- <p style="margin-left: 69.5%;">
                        <a class="btn btn-primary float-right" href="{{ route('comment-management.create') }}"><span
                                class="glyphicon glyphicon-plus"></span> Add Comment</a>
                    </p> --}}
                </div>

                <div class="row mb-2">
                    <table class="table table-bordered table-hover home-page-table">
                        <thead>
                            <th>Event Name</th>
                            <th>User Name</th>
                            <th>Comment</th>
                            <th>Actions</th>
                        </thead>
                        <tbody style="background-color: white;">
                            @if ($comments->count() == 0)
                                <tr>
                                    <td colspan="8">No comments</td>
                                </tr>
                            @endif

                            @foreach ($comments as $comment)
                                <tr>
                                    <td>{{ $comment->event_name }}</td>
                                    <td>{{ $comment->user_name }}</td>
                                    <td>{{ $comment->comment }}</td>
                                    <td>
                                     
                                        @if ($comment->can_hide)
                                            <form style="display:inline-block"
                                                action="{{ route('comment.hide', $comment->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="padding: 4px 12px;"
                                                    onclick="return confirm('Are you sure want to show {{ $comment->comment }}?')">Show</button>
                                            </form>
                                        @else
                                            <form style="display:inline-block"
                                                action="{{ route('comment.unhide', $comment->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="background-color: darkred;"
                                                    onclick="return confirm('Are you sure want to hide {{ $comment->comment }}?')">Hide</button>
                                            </form>
                                        @endif

                              
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $comments->links() }}
                    <p>
                        Displaying {{ $comments->count() }} of {{ $comments->total() }} comment(s).
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
