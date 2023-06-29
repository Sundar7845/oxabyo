@extends('admin.layouts.admin-layout')

@section('content')


<div class="modal fade" id="memberModal"    role="dialog" aria-labelledby="memberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header"> Add Member to {{ $group->name }}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="mediumBody">
                    <div>
                        

                        <form action="{{ route('group-member-management.store') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf

                                            <div class="form-group">
                                                <label><strong>Choose Members : </strong></label>

                                                <select multiple="multiple" name="users[]" id="groupMembers" required>

                                                    @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach

                                                </select>

                                                {{-- <input type="text" name="name" class="form-control"> --}}


                                                <input type="hidden" name="group_id" class="form-control" value="{{ $id }}">
                                            </div>
                                           
                                           
                                            <div class="form-group text-center">
                                                <input type="submit" class="btn btn-primary" name="submit" value="Add Members">
                                            </div>
                                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                        <a class="btn btn-sm btn-success"
                        href="{{ route('group-management.index') }}">Back</a>
                        <b>Group Management / {{ $group->name }}</b>
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
                    <p style="margin-left: 69.5%;">

                        
                    @if($users->count() != 0)
                        <a class="btn btn-primary float-right" data-toggle="modal" id="memberModal1" data-target="#memberModal" href=""><span
                                class="glyphicon glyphicon-plus"></span> Add Member</a>
                                @endif
                    </p>
                </div>

                <div class="row mb-2">
                    <table class="table table-bordered table-hover home-page-table">
                        <thead>
                            <th>Name</th>
                            <th>Actions</th>
                        </thead>
                        <tbody style="background-color: white;">

                            @if ($members->count() == 0)
                                <tr>
                                    <td colspan="8">No members</td>
                                </tr>
                            @endif


                            @foreach ($members as $member)
                            @if($member->users)
                                <tr>
                                    <td>{{ $member->users->name }}</td>
                                    <td>
                                        @if ($member->status)
                                            <form style="display:inline-block"
                                                action="{{ route('group-member-management.hide', $member->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="padding: 4px 12px;"
                                                    onclick="return confirm('Do you want to Deactivate {{ $member->users->name }} from {{ $group->name }}?')">Active</button>
                                            </form>
                                        @else
                                            <form style="display:inline-block"
                                                action="{{ route('group-member-management.unhide', $member->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="background-color: darkred;"
                                                    onclick="return confirm('Do you want to Activate {{ $member->users->name }} from {{ $group->name }}?')">Inactive</button>
                                            </form>
                                        @endif

                                        <form style="display:inline-block"
                                                action="{{ route('group-member-management.destroy', $member->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="padding: 4px 12px; background-color: darkred;"
                                                    onclick="return confirm('Are you sure want to remove {{ $member->users->name }} from {{ $group->name }}?')">Remove</button>
                                        </form>

                                    </td>

                                </tr>
                                @endif
                            @endforeach
                      
                        </tbody>
                    </table>
                    {{ $members->links() }}
                    <p>
                        Displaying {{ $members->count() }} of {{ $members->total() }} member(s).
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
