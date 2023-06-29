@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                        <a class="btn btn-sm btn-success"
                        href="{{ route('admin.setup-prizing.index') }}">Back</a>
                        <b>Setup Subscriptions</b>
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
                                      
                                        <form action="{{ route('admin.setup-prizing.update', $plan->id) }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label><strong>Plan Name: </strong></label>
                                                <input type="text" name="plan_name" class="form-control" value="{{ $plan->plan_name }}" >
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Month Prize: </strong></label>
                                                <input type="text" name="month_price" class="form-control" value="{{ $plan->month_price }}" >
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Year Prize: </strong></label>
                                                <input type="text" name="year_price" class="form-control" value="{{ $plan->year_price }}" >
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
