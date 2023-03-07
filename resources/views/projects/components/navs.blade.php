<div class="d-flex flex-wrap  align-items-center" style="gap:10px">
    <ul class="nav nav-tabs mb-0" role="tablist">
        @if (!$project_stages)
            <li class="nav-item">
                <a class="nav-link active" href="#home">Default Level</a>
            </li>
        @else
            @foreach ($project_stages as $item)
                <li class="nav-item">
                    <a class="nav-link {{$item->ps_id == $selected_stage->ps_id ? 'active' : ''}}"
                            href="{{url('/projects/'.$item->ps_prj_id.'/form/'.$item->ps_id)}}">{{$item->ps_level_name ? $item->ps_level_name : 'No Name'}}</a>
                </li>
            @endforeach
        @endif
    </ul>
    @if($selected_stage)
    <button class="btn btn-primary btn-sm btn-icon" onclick="addNewLevel()">
        <i class="bx bx-plus"></i>
    </button>
    @endif
</div>
