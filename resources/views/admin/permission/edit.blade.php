@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                        <a class="btn btn-sm btn-success"
                        href="{{ route('admin.permission.index') }}">Back</a>
                        <b>Setup Permission</b>
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
                                      
                                        <form action="{{ route('admin.permission.update', $permission->id) }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label><strong>Plan/Permission : </strong></label>
                                                <input type="text" name="permission_name" class="form-control" value="{{ $permission->permission_name }}" >
                                            </div>
                                            <div class="form-group">
                                                <label><strong>NOOB: </strong></label>
                                                <input type="text" name="noob" class="form-control" value="{{ $permission->noob }}" >
                                            </div>
                                            <div class="form-group">
                                                <label><strong>GEEK: </strong></label>
                                                <input type="text" name="geek" class="form-control" value="{{ $permission->geek }}" >
                                            </div>
                                            <div class="form-group">
                                                <label><strong>PRO: </strong></label>
                                                <input type="text" name="pro" class="form-control" value="{{ $permission->pro }}" >
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
