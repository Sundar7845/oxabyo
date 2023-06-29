@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                        <a class="btn btn-sm btn-success"
                        href="{{ route('group-management.index') }}">Back</a>
                        <b>Group Management</b>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 offset-3 mt-5">
                                <div class="card">
                                    <div class="card-body">
                                        @if (count($errors) > 0)
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        @if ($message = Session::get('success'))
                                            <div class="alert alert-success alert-block">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @endif
                                        <form action="{{ route('group-management.update', $group->id) }}" method="post"
                                            enctype="multipart/form-data">
                                            @method('put')
                                            @csrf
                                            <div class="form-group">
                                                <label><strong>Group Name : </strong></label>
                                                <input type="text" name="name" class="form-control" value = "{{ $group->name }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Group Description : </strong></label>
                                                <input type="text" name="description" class="form-control" value = "{{ $group->description }}">
                                            </div>
                                
                                            <div class="form-group">
                                                <label><strong>Group Admin : </strong></label>
                                                <select name="group_admin_id" class="form-control">
                                                    @foreach ($users as $user)
                                                        <option @if ($group->group_admin_id) {{ 
                                                            $user->id == $group->group_admin_id ? 'selected' : '' }} 
                                                    @endif
                                                    value="{{ $user->id }}">{{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label><strong>Game : </strong></label>
                                                <select name="game_id" class="form-control">
                                                    @foreach ($games as $game)
                                                        <option @if ($group->game_id) {{ 
                                                            $game->id == $group->game_id ? 'selected' : '' }} 
                                                    @endif
                                                    value="{{ $game->id }}">{{ $game->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label><strong>Group Image : </strong></label>
                                                <input type="file" name="file" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label><strong>Group Color : </strong></label>
                                                <input type="color" name="group_color" class="form-control"  value="{{ $group->group_color }}">
                                            </div>

                                            
                                            <div class="form-group text-center">
                                                <input type="submit" class="btn btn-primary" name="submit" value="Save">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
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
