@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                        <!-- <a class="btn btn-sm btn-success"
                        href="{{ route('admin.permission.index') }}">Back</a> -->
                        <b>Setup Permissions</b>
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
                            <th>PLANS / PERMISSIONS </th>
                            @foreach ($plans as $plan)
                                <th>{{ strtoupper($plan->key) }}</th>
                            @endforeach

                            <th>ACTION</th>

                        </thead>
                        <tbody style="background-color: white;">

                            @foreach ($permissions as $permission)
                                <tr>
                                    <td>                                    
                                    {{ strtoupper($permission->name) }}
                                    </td>

                                    <td>
                                        @if($subscriptionPermissionsForNoob[$permission->id]['is_unlimited'])
                                            Unlimited
                                        @else
                                            {{ $subscriptionPermissionsForNoob[$permission->id]['value'] }}
                                        @endif                                     
                                    </td>

                                    <td>
                                        @if($subscriptionPermissionsForGeek[$permission->id]['is_unlimited'])
                                            Unlimited
                                        @else
                                            {{ $subscriptionPermissionsForGeek[$permission->id]['value'] }}
                                        @endif                                        
                                    </td>

                                    <td>
                                        @if($subscriptionPermissionsForPro[$permission->id]['is_unlimited'])
                                            Unlimited
                                        @else
                                            {{ $subscriptionPermissionsForPro[$permission->id]['value'] }}
                                        @endif                                        
                                    </td>

                                    <td>
                                    <a class="btn btn-sm btn-success"
                                            href="{{ route('admin.permission.edit', $permission->id) }}">Modify</a>


                                    </td>
                                                                       
                                
                                </tr>
                            @endforeach
                
                         
                        </tbody>
                    </table>
                    

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
