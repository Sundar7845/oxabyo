<div class="row">
    <div class="col-sm-12 table-responsive">
        <table class="table group_table sortable_table">
            <thead>
                <th>Group Name<i class="fas fa-sort-up sort m_l5"></i></th>
                <th>Admin<i class="fas fa-sort sort m_l5"></i></th>
                <th class="text-center">Members<i class="fas fa-sort sort m_l5"></i></th>
                <th>Last Message of<i class="fas fa-sort sort m_l5"></i></th>
                <th>Date<i class="fas fa-sort sort m_l5"></i></th>
                <th></th>
            </thead>
            <tbody>
 
            @foreach($groups as $group)
                <tr class="" style="background-color: {{ $group->group_color ?? "#0000fe !important" }}">
                    <td>
                         <a href="{{ route('groups.show', $group->id )}}">
                            <img src="{{ $group->group_image ?? 'https://via.placeholder.com/800x800' }}" class="avatar m_r10"
                                style="width:80px!important; height: 75px;">{{ $group->name }}
                        </a>
                    </td>
                    <td>{{ $group->users->name ?? '' }}</td>
                    <td class="text-center">{{ $group->group_members_count->count() ?? '0' }}</td>
                    <td>Last message Username</td>
                    <td>01/01/2022</td>
                    <td></td>
                </tr>
            @endforeach
                
            </tbody>
        </table>
    </div>
</div>