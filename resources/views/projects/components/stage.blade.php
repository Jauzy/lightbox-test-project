@if($selected_stage)
<form id="form-stage">
    @csrf
    <input type="hidden" value="{{$selected_stage->ps_id}}" name="id" required />
    <input type="hidden" value="{{$selected_stage->ps_prj_id}}" name="inp[ps_prj_id]" required />
    <div class="row">
        <div class="col-lg-4 col-xl-3">
            <label class="form-label">Level Name</label>
            <input type="text" placeholder='Level Name' value="{{$selected_stage->ps_level_name}}" class="form-control" name="inp[ps_level_name]" required id="ps_level_name">
        </div>
        <div class="col-lg-4 col-xl-3">
            <label class="form-label">Stage</label>
            <select class="form-control select2" value="{{$selected_stage->ps_stage_id}}" id="ps_stage_id" name="inp[ps_stage_id]" required>
                <option value="">Select Stage</option>
                @foreach ($stages as $item)
                <option value="{{$item->stage_id}}" {{$selected_stage->ps_stage_id == $item->stage_id? 'selected':''}}>{{$item->stage_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-4 d-flex flex-column">
            <label class="form-label" style="opacity:0">Level Name</label>
            <button class="btn btn-primary me-auto" type="button" onclick="saveStageForm()">Save Stage Info</button>
        </div>
    </div>
</form>
@else
<form>
    @csrf
    <div class="row">
        <div class="col-lg-4 col-xl-3">
            <label class="form-label">Level Name</label>
            <input type="text" placeholder='Level Name' disabled class="form-control" name="inp[ps_level_name]" required id="ps_level_name">
        </div>
        <div class="col-lg-4 col-xl-3">
            <label class="form-label">Stage</label>
            <select class="form-control select2" disabled id="ps_stage_id" name="inp[ps_stage_id]" required>
                <option value="">Select Stage</option>
            </select>
        </div>
        <div class="col-lg-4 d-flex flex-column">
            <label class="form-label" style="opacity:0">Level Name</label>
            <button class="btn btn-primary me-auto" type="button" disabled>Save Stage Info</button>
        </div>
    </div>
</form>
@endif
