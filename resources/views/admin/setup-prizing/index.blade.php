@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                         {{-- <a class="btn btn-sm btn-success"
                        href="{{ route('admin.setup-prizing.index') }}">Back</a> --}}
                        <b>Setup Subscriptions</b>
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
                    <table class="table table-bordered table-hover home-page-table">
                        <thead>
                            <th>Id</th>
                            <th>Plan Name</th>
                            <th>Month Price</th>
                            <th>Year Price</th>
                            <th>Action</th>
                        </thead>
                        <tbody style="background-color: white;">
        

                          @foreach ($plans as $plan)
                                <tr>
                                    <td>{{$plan->id ?? '' }}</td>
                                    <td>{{$plan->plan_name ?? '' }}</td>
                                    <td>{{$plan->month_price ?? '' }}</td>
                                    <td>{{$plan->year_price ?? '' }}</td>
                                   
                                    <td>
                                    <a class="btn btn-sm btn-success"
                                            href="{{ route('admin.setup-prizing.edit', $plan->id) }}">Edit</a>


                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $plans->links() }}
                    <p>
                        Displaying {{ $plans->count() }} of {{ $plans->total() }} plan(s).
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
