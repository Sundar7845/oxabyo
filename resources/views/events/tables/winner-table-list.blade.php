@foreach ($completedEventPhase as $completedPhase)
    <h3 class="text-center"><b>CALENDAR MATCH PHASE {{ $completedPhase->match }}
            ({{ $completedPhase->phases->value }}°)</b></h3>
    <div class="container text-left">
        <div class="row hidden-xs m_b10">
            <div class="col-sm-3 m_b10">DATE</div>
            <div class="col-sm-3 m_b10">CHALLENGER 1</div>
            <div class="col-sm-3 m_b10">CHALLENGER 2</div>
            <div class="col-sm-3 m_b10">WINNER</div>
        </div>

        @foreach ($completedPhase->fixtures as $fixtures)
            <div class="row parent-parent-winner-{{ $fixtures->fixture_results->fixture_id }}">
                <div class="col-sm-3 col-xs-12 m_b10">{{ $fixtures->date }}</div>


        <div id="challenger1-text-success"
             @if ($fixtures->fixture_results && $fixtures->challenger1_id != $fixtures->fixture_results->winner_id) class="col-sm-3 col-xs-6 m_b10 challenger1-text-success winners-text-decoration"
            @else
                        class="col-sm-3 col-xs-6 m_b10 challenger1-text-success" @endif>
                    <img src="{{ $fixtures->challenger1->players->profile_image ?? '/img/avatar.jpg' }}"
                        class="avatar m_r10" style="width:30px;">
                    {{ $fixtures->challenger1->players->name ?? '' }}
         </div>


        <div id="challenger2-text-success"
            @if ($fixtures->fixture_results && $fixtures->challenger2_id != $fixtures->fixture_results->winner_id) class="col-sm-3 col-xs-6 m_b10 challenger2-text-success winners-text-decoration"
        @else
        class="col-sm-3 col-xs-6 m_b10 challenger2-text-success" @endif>
            <img src="{{ $fixtures->challenger2->players->profile_image ?? '/img/avatar.jpg' }}"
                class="avatar m_r10" style="width:30px;">
            {{ $fixtures->challenger2->players->name ?? '' }}
        </div>


        <div class="col-sm-3 hidden-xs m_b10 parent-winner-{{ $fixtures->fixture_results->fixture_id }}">

            <span class="winner-success-{{ $fixtures->fixture_results->fixture_id }}">
            <img src="{{ $fixtures->fixture_results->winner->players->profile_image ?? '/img/avatar.jpg' }}"
                class="avatar m_r10" style="width:30px;">
            {{ $fixtures->fixture_results->winner->players->name ?? '' }}
            </span>

            <span class="winner-failure-{{ $fixtures->fixture_results->fixture_id }} hidden">
                <img src="{{ $fixtures->fixture_results->looser->players->profile_image ?? '/img/avatar.jpg' }}"
                    class="avatar m_r10" style="width:30px;">
                {{ $fixtures->fixture_results->looser->players->name ?? '' }}
            </span>


            <a style="float: right;" class="btn btn-icon toggle-class-switch-winner"
                data-id="{{ $fixtures->fixture_results->fixture_id ?? '' }}" data-event_id="{{ $event_id }}" data-toggle="tooltip"
                data-original-title="SWITCH WINNER">
                <i class="fas fa-toggle-off"></i></a>
        </div>


            </div>
            <hr class="m_t10 m_b20">
        @endforeach
    </div>
    <br> <br>
@endforeach
