@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                         <a class="btn btn-sm btn-success"
                        href="{{ route('admin.subscription.index') }}">Back</a>
                        <b>Subscription-Permission</b>
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
                
                </div>

                <div class="row mb-2">
                    <table class="table table-bordered table-hover home-page-table">
                        <thead>
                            <th>ID</th>
                            <th>Free</th>
                            <th>Best-month </th>
                            <th>Gold-month</th>
                        </thead>
                        <tbody style="background-color: white;">
        

                          @foreach ($plans as $plan)
                                <tr>
                                    <td>{{$plan->id ?? '' }}</td>
                                    <td>{{$plan->Free ?? '' }}</td>
                                    <td>{{$plan->Best_month ?? '' }}</td>
                                    <td>{{$plan->Gold_month ?? '' }}</td>
                                   
                                    <td>
                                    <a class="btn btn-sm btn-success"
                                            href="{{ route('admin.subscription.edit', $plan->id) }}">Permission</a>

{{--                                 
                                        <form style="display:inline-block"
                                                action="{{ route('admin.setup-prizing.destroy',) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" style="padding: 4px 12px; background-color: darkred;"
                                                    onclick="return confirm('Are you sure want to delete {{ $plan->name }}?')">Delete</button>
                                        </form> --}}
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
