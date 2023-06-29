@extends('admin.layouts.admin-layout')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 page-title-custom">
                        <a class="btn btn-sm btn-success"
                        href="{{ route('event-management.index') }}">Back</a>
                        <b>Event Management</b>
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
                                        <form action="{{ route('event-management.update', $event->id) }}" method="post"
                                            enctype="multipart/form-data">
                                            @method('put')
                                            @csrf
                                            <div class="form-group">
                                                <label><strong>Event Name : </strong></label>
                                                <input type="text" name="name" class="form-control" value = "{{ $event->name }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Event Description : </strong></label>
                                                <input type="text" name="description" class="form-control" value = "{{ $event->description }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Event Rules : </strong></label>
                                                <input type="text" name="rules" value = "{{ $event->rules }}" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Match Start Date : </strong></label>
                                                <input type="date" name="match_date" value = "{{ $event->match_date }}" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Match Hour : </strong></label>
                                                <input type="time" name="match_hour" value = "{{ $event->match_hour }}" class="form-control" required>
                                            </div>

                                            <div class="form-group">
                                                <label><strong>Event Type : </strong></label>
                                                <select name="event_type_id" class="form-control">
                                                    @foreach ($eventTypes as $eventType)
                                                        <option @if ($event->event_type_id) {{ 
                                                            $eventType->id == $event->event_type_id ? 'selected' : '' }} 
                                                    @endif
                                                    value="{{ $eventType->id }}">{{ $eventType->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label><strong>Event Admin : </strong></label>
                                                <select name="organizer_id" class="form-control">
                                                    @foreach ($users as $user)
                                                        <option @if ($event->organizer_id) {{ 
                                                            $user->id == $event->organizer_id ? 'selected' : '' }} 
                                                    @endif
                                                    value="{{ $user->id }}">{{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label><strong>Players Type : </strong></label>
                                                <select name="player_type_id" class="form-control">
                                                    @foreach ($playerTypes as $playerType)
                                                        <option @if ($event->player_type_id) {{ 
                                                            $playerType->id == $event->player_type_id ? 'selected' : '' }} 
                                                    @endif
                                                    value="{{ $playerType->id }}">{{ $playerType->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Game : </strong></label>
                                                <select name="game_id" class="form-control">
                                                    @foreach ($games as $game)
                                                        <option @if ($event->game_id) {{ 
                                                            $game->id == $event->game_id ? 'selected' : '' }} 
                                                    @endif
                                                    value="{{ $game->id }}">{{ $game->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label><strong>Prize Money (€) : </strong></label>
                                                <input type="text" name="prize_money" value = "{{ $event->prize_money }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label><strong>OXARATE Min : </strong></label>
                                                <input type="text" name="oxarate_min" value = "{{ $event->oxarate_min }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Performance Rating Min : </strong></label>
                                                <input type="text" name="performance_rating_min" value = "{{ $event->performance_rating_min }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Ynfluence Rating Min : </strong></label>
                                                <input type="text" name="ynfluence_rating_min" value = "{{ $event->ynfluence_rating_min }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Monetization Rating Min : </strong></label>
                                                <input type="text" name="monetization_rating_min" value = "{{ $event->monetization_rating_min }}" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label><strong>Ticket (€) : </strong></label>
                                                <input type="text" name="ticket" class="form-control" value = "{{ $event->ticket }}">
                                            </div>

                                            <div class="form-group">
                                                <label><strong>Event Image : </strong></label>
                                                <input type="file" name="file" class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <label><strong>Event Cover : </strong></label>
                                                <input type="file" name="cover" class="form-control">
                                            </div>

                                            
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-12 m_b10">
                                                        <input type="checkbox" value="1" name="allow_players_streaming" @if($event->allow_players_streaming) checked @endif><strong> Allow
                                                            Players Streaming </strong>
                                                    </div>
                                                </div>
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
