<div class="d-flex align-items-center flex-wrap" style="gap:10px">
    <h4 class="mb-0 fw-bolder me-auto">Assigned Products</h4>
    @if ($selected_stage)
    <button class="btn btn-primary" onclick="searchProduct()">Add New Products</button>
    <button class="btn btn-secondary" onclick="export_pdf()">
        <i class="bx bxs-file-pdf"></i> Export PDF
    </button>
    <button class="btn btn-success" onclick="export_excel()">
        <i class="bx bxs-spreadsheet"></i> Export Excel
    </button>
    @else
    <button class="btn btn-primary" disabled>Add New Products</button>
    @endif
</div>

<style>
    .accordion-item {
        background: #e9e9e9 !important;

    }
    .accordion-button.collapsed {
        background: #e9e9e9 !important;
    }
</style>

<hr/>
@if ($selected_stage && count($selected_stage->stage_products) > 0)
<div class="accordion accordion-margin" id="accordionMargin" data-toggle-hover="true">
    @foreach ($selected_stage->stage_products as $item)
        <div class="accordion-item mb-1">
            <h2 class="accordion-header" id="heading{{$item->psp_id}}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#accordion{{$item->psp_id}}">
                    <div class="d-flex align-items-center flex-wrap w-100" style="gap:20px">
                        <img src="{{url('getimage/'.base64_encode($item->product_offered->pr_main_photo))}}" class="rounded" style="height:70px;width:70px" />
                        <div>
                            <a class="text-primary fw-bolder"><strong>{{$item->product_offered->pr_code}}</strong></a>
                            <div>{{$item->product_offered->lumtype->ms_lum_types_name}}</div>
                            <div>{{$item->product_offered->pr_lamp_type}} | {{$item->product_offered->pr_light_source}} | {{$item->product_offered->pr_lumen_output}}</div>
                        </div>
                        <div class="mx-3">
                            <div>{{$item->product_offered->brand->ms_brand_name}}</div>
                            <div>{{$item->product_offered->pr_supplier}}</div>
                        </div>
                        <div>
                            <div>{{$item->product_offered->pr_model}}</div>
                            <div>{{$item->product_offered->pr_finishing}}</div>
                        </div>
                    </div>
                </button>
            </h2>

            <div id="accordion{{$item->psp_id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$item->psp_id}}">
                <div class="accordion-body">
                    <form id="frm-produk-{{$item->product_offered->pr_id}}" class="mt-2">
                        @csrf
                        <input type="hidden" id="pr_id" name="id" value="{{$item->product_offered->pr_id}}" />
                        <div class="row" style="gap: 10px 0">
                            <div class="col-lg-4">
                                <label class="form-label">Code</label>
                                <input type="text" value="{{$item->product_offered->pr_code}}" required placeholder='Input Someting' class="form-control form-control-sm" name="inp[pr_code]" id="pr_code">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Supplier</label>
                                <input type="text" placeholder='Input Someting' required value="{{$item->product_offered->pr_supplier}}" class="form-control form-control-sm" name="inp[pr_supplier]" id="pr_supplier">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Luminaire Type</label>
                                <select class="select2 form-control form-control-sm" name="inp[pr_luminaire_type]" id="pr_luminaire_type" required value="{{$item->product_offered->pr_luminaire_type}}">
                                    <option>Select Luminaire Type</option>
                                    @foreach ($lumtypes as $lumtype)
                                        <option value="{{$lumtype->ms_lum_types_id}}" {{$item->product_offered->pr_luminaire_type == $lumtype->ms_lum_types_id ? 'selected': ''}}>{{$lumtype->ms_lum_types_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Color Temperature</label>
                                <input type="text" value="{{$item->product_offered->pr_color_temperature}}" placeholder='Input Someting' class="form-control form-control-sm" name="inp[pr_color_temperature]" id="pr_color_temperature">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">IP Rating</label>
                                <input type="text" value="{{$item->product_offered->pr_ip_rating}}" placeholder='Input Someting' class="form-control form-control-sm" name="inp[pr_ip_rating]" id="pr_ip_rating">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Color Rendering</label>
                                <input type="text" value="{{$item->product_offered->pr_color_rendering}}" placeholder='Input Someting' class="form-control form-control-sm" name="inp[pr_color_rendering]" id="pr_color_rendering">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Light Source</label>
                                <input type="text" value="{{$item->product_offered->pr_light_source}}" placeholder='Input Someting' class="form-control form-control-sm" name="inp[pr_light_source]" id="pr_light_source">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Finishing</label>
                                <input type="text" value="{{$item->product_offered->pr_finishing}}" placeholder='Input Someting' class="form-control form-control-sm" name="inp[pr_finishing]" id="pr_finishing">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Driver</label>
                                <input type="text" value="{{$item->product_offered->pr_driver}}" placeholder='Input Someting' class="form-control form-control-sm" name="inp[pr_driver]" id="pr_driver">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Unit Price</label>
                                <input type="text" value="{{$item->product_offered->pr_unit_price}}" placeholder='Input Someting' class="form-control form-control-sm" name="inp[pr_unit_price]" id="pr_unit_price">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Quantity</label>
                                <input type="number" value="{{$item->product_offered->pspo_quantity}}" placeholder='Input Someting' class="form-control form-control-sm" name="inp[pspo_quantity]" id="pspo_quantity">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Accessories Photo</label>
                                <input type="file" class="form-control form-control-sm" name="pr_accessories_photo" accept=".png, .jpg">
                                @if($item->product_offered->pr_accessories_photo)
                                <a class="form-text text-success" target="_blank" href="{{
                                    asset('storage/'.str_replace('public\\', '', $item->product_offered->pr_accessories_photo))
                                }}">File preview.</a>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Accessories</label>
                                <textarea type="text" placeholder='Input Someting' class="form-control form-control-sm" name="inp[pspo_accessories]" id="pspo_accessories">{{$item->product_offered->pspo_accessories}}</textarea>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">Notes</label>
                                <textarea type="text" placeholder='Input Someting' class="form-control form-control-sm" name="inp[pspo_notes]" id="pspo_notes">{{$item->product_offered->pspo_notes}}</textarea>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap mt-1" style="gap:10px">
                            <button type="button" class="btn btn-flat-danger btn-sm me-auto" onclick="delFormProduk('{{$item->product_offered->pr_id}}')"><i class="bx bx-trash"></i> Delete</button>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="saveFormProduk('frm-produk-{{$item->product_offered->pr_id}}')"><i class="bx bx-save"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    @endforeach
</div>
@else
    <div class="text-center fw-bolder">
        No Product Assigned Yet
    </div>
@endif
