@foreach ($teams as $item)
    <div class="col-md-3 col-sm-6 p_x0 text-center shadow_r" style="background-color:<?php echo $item->team_color; ?>">
        <div class="p_20">
            <a href="{{ route('teams.show', $item->id) }}">
                <img src="{{ $item->team_image ?? 'https://via.placeholder.com/800x800' }}" class="avatar" alt="avatar"
                style="height: 339px;">
                <h4><strong>{{ $item->name }}</strong></h4>
            </a>
        </div>
    </div>
@endforeach
