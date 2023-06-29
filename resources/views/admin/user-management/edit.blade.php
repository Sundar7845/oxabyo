@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                        <a class="btn btn-sm btn-success"
                        href="{{ route('user-management.index') }}">Back</a>
                        <b>User Management</b>
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
                                        <form action="{{ route('user-management.update',$user->id) }}" method="post"
                                            enctype="multipart/form-data">
                                            @method('put')
                                            @csrf
                                            <div class="form-group">
                                                <label><strong>Username : </strong></label>
                                                <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Surname : </strong></label>
                                                <input type="text" name="surename" class="form-control" value="{{ $user->surename }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Email : </strong></label>
                                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                            </div>

                                            <div class="form-group">
                                                <label><strong>Password : </strong></label>
                                                <input type="password" name="password" class="form-control" id="id_password" placeholder="*************">
                                                <i class="far fa-eye eye_password fa-eye-slash" id="togglePassword"></i>
                                            </div>

                                            <div class="form-group">
                                                <label><strong>Confirm Password : </strong></label>
                                                <input type="password" name="password_confirm" class="form-control" id="id_password_confirmation" placeholder="*************">
                                                <i class="far fa-eye eye_password fa-eye-slash" id="togglePasswordConfirmation"></i>
                                            </div>

                                            <div class="form-group">
                                                <label><strong>User Role : </strong></label>
                                                <select name="user_role_id" class="form-control">

                                                    @foreach ($roles as $role)
                                                        <option @if ($user->user_role_id) {{ 
                                                            $role->id == $user->user_role_id ? 'selected' : '' }} 
                                                    @endif
                                                        value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label><strong>Birth Date : </strong></label>
                                                <input type="date" name="dob" class="form-control" value="{{ $user->dob }}">
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Address : </strong></label>
                                                <input type="address" name="address" class="form-control" value="{{ $user->address }}">
                                            </div>
                                            <div class="form-group">
                                                <label><strong>City : </strong></label>
                                                <input type="city" name="city" class="form-control" value="{{ $user->city }}">
                                            </div>
                                            <div class="form-group">
                                                <label><strong>BIO</strong></label>
                                                <textarea class="form-control" name="bio_data"
                                                    rows="5">{{ $user->bio_data }}</textarea>
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
