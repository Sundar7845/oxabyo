@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                        <a class="btn btn-sm btn-success"
                        href="{{ route('comment-management.index') }}">Back</a>
                        <b>Comment Management</b>
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
                                        <form action="{{ route('comment-management.store') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label><strong>Comment Name : </strong></label>
                                                <input type="text" name="name" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Comment Description : </strong></label>
                                                <input type="text" name="description" class="form-control">
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
