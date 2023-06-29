@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                        <a class="btn btn-sm btn-success"
                        href="{{ route('team-management.index') }}">Back</a>
                        <b>Team Management</b>
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
                                        <form action="{{ route('team-management.store') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label><strong>Team Name : </strong></label>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Team Description : </strong></label>
                                                <input type="text" name="description" class="form-control">
                                            </div>
                                          
                                           
                                            <div class="form-group">
                                                <label><strong>Team Admin : </strong></label>
                                                <select name="admin_user_id" class="form-control">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                          
                                            <div class="form-group">
                                                <label><strong>Game : </strong></label>
                                                <select name="game_id" class="form-control">
                                                    @foreach ($games as $game)
                                                        <option value="{{ $game->id }}">{{ $game->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label><strong>Team Image : </strong></label>
                                                <input type="file" name="file" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label><strong>Team Color : </strong></label>
                                                <input type="color" name="team_color" class="form-control">
                                            </div>
                                           
                                            <div class="form-group text-center">
                                                <input type="submit" class="btn btn-primary" name="submit" value="Save & Add Members">
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
