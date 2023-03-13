@extends('layouts.layout1')

@section('css_section')
    <style>
        tr td {
            padding: 1em 5em !important
        }

        tr td img {
            border-radius: 5px
        }
    </style>
@endsection

@section('page_title')
    Tender Form
@endsection

@section('sidebar-size', 'collapsed')
@section('url_back', url('/projects'))

@section('content')

    <form id="frm-produk" class="py-2">
        @csrf
        <input type="hidden" name="psp_id" value="{{$id}}" />
        <div class="d-flex justify-content-between flex-wrap mb-2">
            <h1 style="font-weight: 900" class="fw-bolder display-4">Tender Form</h1>
            <img src="{{ asset('lightbox.png') }}" style="max-width: 300px;object-fit:contain" />
        </div>

        <div class="card">
            <div class="card-header p-1 mb-1 fw-bolder" style="background:#D2E4FC">
                Company Details
            </div>
            <div class="card-body row">
                <div class="row" style="gap: 10px 0">
                    <input type="hidden" name="psto[pst_ps_id]" value="{{$id}}" />
                    @foreach (['Company Name', 'Contact person', 'Email Address', 'Phone Number', 'Address', 'City', 'State', 'Country'] as $item)
                        <div class="col-lg-4">
                            <label class="form-label">{{ $item }}</label>
                            <input type="text" placeholder='Input Someting' class="form-control"
                                name="psto[{{ 'psto_' . strtolower(str_replace(' ', '_', $item)) }}]" required
                                id="{{ 'psto_' . strtolower(str_replace(' ', '_', $item)) }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-2">
            <button type="button" class="btn btn-primary" id="collapse-button">
                Toggle Products
            </button>
        </div>

        <div class="">
            <div class="">
                <div class="accordion accordion-margin" id="accordionMargin" data-toggle-hover="true">
                    @foreach ($project->stage_products as $item)
                        @php
                            $offered = $item->product_offered;
                        @endphp
                        <div class="accordion-item mb-1">
                            <h2 class="accordion-header" id="heading{{ $offered->pr_id }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" style="background:#D2E4FC" data-bs-target="#accordion{{ $offered->pr_id }}">
                                    <div class="d-flex align-items-center w-100 justify-content-between flex-wrap"
                                        style="gap:10px">
                                        <div>
                                            Spec. Code <strong class="ms-1">{{$offered->pr_code}}</strong>
                                        </div>
                                    </div>
                                </button>
                            </h2>

                            <div id="accordion{{ $offered->pr_id }}" class="accordion-collapse "
                                aria-labelledby="heading{{ $offered->pr_id }}">
                                <div class="accordion-body p-0">
                                    <input type="hidden" name="inp[{{$offered->pr_id}}][pr_id]" value="{{ $offered->pr_id }}" />

                                    <div class="d-flex   flex-wrap align-items-center my-1 mx-2" style="gap:10px">
                                        <h1 class="fw-bolder h6 mb-0 me-auto">Please enter product details for tender</h1>
                                        <h6 class="mb-0">Tendering</h6>
                                        <div class="btn-group" role="group">
                                            <input type="radio" class="btn-check" name="inp[{{$offered->pr_id}}][psto_supplied_as]" id="{{$offered->pr_id}}-psto_supplied_as-1" autocomplete="off" value="as-specified" checked>
                                            <label class="btn btn-primary btn-sm waves-effect" for="{{$offered->pr_id}}-psto_supplied_as-1">As Specified</label>
                                            <input type="radio" class="btn-check" name="inp[{{$offered->pr_id}}][psto_supplied_as]" id="{{$offered->pr_id}}-psto_supplied_as-2" autocomplete="off" value="alternative">
                                            <label class="btn btn-primary btn-sm waves-effect" for="{{$offered->pr_id}}-psto_supplied_as-2">Alternative</label>
                                        </div>
                                    </div>

                                    <table class="table table-striped table-bordered" id="{{$offered->pr_id}}-as-specified">
                                        <tr>
                                            <th colspan="2">Product Required</th>
                                            <th>Product Tendered</th>
                                        </tr>
                                        @foreach ([
                                            ['Luminaire type', 'ms_lum_types_name'],
                                            ['Brand', 'ms_brand_name'],
                                            ['Model', 'pr_model'],
                                        ] as $field)
                                            <tr>
                                                <td align="">
                                                    <label class="h6 mb-0 text-center">{{$field[0]}}</label>
                                                </td>
                                                <td align="center">
                                                    @if($field[1] == 'ms_lum_types_name')
                                                        <label class="h6 mb-0 text-center fw-bolder">{{$offered->lumtype[$field[1]] ?? '-'}}</label>
                                                    @elseif($field[1] == 'ms_brand_name')
                                                        <label class="h6 mb-0 text-center fw-bolder">{{$offered->brand[$field[1]] ?? '-'}}</label>
                                                    @else
                                                        <label class="h6 mb-0 text-center fw-bolder">{{$offered[$field[1]] ?? '-'}}</label>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($field[1] == 'ms_lum_types_name')

                                                    @else
                                                        <input value="{{ $field[1] == 'ms_brand_name' ?  $offered->brand->ms_brand_name : $offered[$field[1]] }}" placeholder='Input Someting'
                                                            class="form-control product-{{$offered->pr_id}}-inputs" name="inp[{{$offered->pr_id}}][{{$field[1]}}]" disabled />
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ([['Photo', 'pr_main_photo'], ['Dimension', 'pr_dimension_photo'], ['Photometric', 'pr_photometric_photo']] as $photo)
                                        <tr>
                                            <td align="">
                                                <label class="h6 mb-0 text-center">{{$photo[0]}}</label>
                                            </td>
                                            <td align="center">
                                                <label class="h6 mb-0 text-center fw-bolder">
                                                    <img src="{{ url('getimage/'.base64_encode($offered[$photo[1]])) }}" style="height:150px;width:150px;object-fit:contain" />
                                                </label>
                                            </td>
                                            <td>
                                                <input type="file" class="form-control" name="inp[{{$offered->pr_id}}][{{$photo[1]}}]" disabled>
                                                <small class="text-danger">
                                                    *Please upload image in .jpg, .png format
                                                </small>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @foreach ([
                                            ['Wattage', 'pr_light_source'],
                                            ['Lumen Output', 'pr_lumen_output'],
                                            ['Color Temperature', 'pr_color_temperature'],
                                            ['Beam Angle', 'pr_optical'],
                                            ['CRI', 'pr_color_rendering'],
                                            ['IP Rating', 'pr_ip_rating'],
                                            ['Driver Type', 'pr_driver'],
                                            ['Notes', 'pspo_notes'],
                                        ] as $field)
                                            <tr>
                                                <td align="">
                                                    <label class="h6 mb-0 text-center">{{$field[0]}}</label>
                                                </td>
                                                <td align="center">
                                                    @if($field[1] == 'ms_lum_types_name')
                                                        <label class="h6 mb-0 text-center fw-bolder">{{$offered->lumtype[$field[1]] ?? '-'}}</label>
                                                    @elseif($field[1] == 'ms_brand_name')
                                                        <label class="h6 mb-0 text-center fw-bolder">{{$offered->brand[$field[1]] ?? '-'}}</label>
                                                    @else
                                                        <label class="h6 mb-0 text-center fw-bolder">{{$offered[$field[1]] ?? '-'}}</label>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input value="{{$offered[$field[1]] }}" placeholder='Input Someting'
                                                        class="form-control product-{{$offered->pr_id}}-inputs" name="inp[pr_color_temperature]" disabled />
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                    <table class="table table-striped table-bordered alternative" id="{{$offered->pr_id}}-alternative">
                                        <tr>
                                            <th colspan="2">Product Required</th>
                                            <th>Product Tendered</th>
                                        </tr>
                                        @foreach ([
                                            ['Luminaire type', 'ms_lum_types_name'],
                                            ['Brand', 'ms_brand_name'],
                                            ['Model', 'pr_model'],
                                        ] as $field)
                                            <tr>
                                                <td align="">
                                                    <label class="h6 mb-0 text-center">{{$field[0]}}</label>
                                                </td>
                                                <td align="center">
                                                    @if($field[1] == 'ms_lum_types_name')
                                                        <label class="h6 mb-0 text-center fw-bolder">{{$offered->lumtype[$field[1]] ?? '-'}}</label>
                                                    @elseif($field[1] == 'ms_brand_name')
                                                        <label class="h6 mb-0 text-center fw-bolder">{{$offered->brand[$field[1]] ?? '-'}}</label>
                                                    @else
                                                        <label class="h6 mb-0 text-center fw-bolder">{{$offered[$field[1]] ?? '-'}}</label>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($field[1] == 'ms_lum_types_name')

                                                    @else
                                                    <input placeholder='Input Someting' class="form-control product-{{$offered->pr_id}}-inputs"
                                                        name="inp[{{$offered->pr_id}}][{{$field[1]}}]" required />
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ([['Photo', 'pr_main_photo'], ['Dimension', 'pr_dimension_photo'], ['Photometric', 'pr_photometric_photo']] as $photo)
                                        <tr>
                                            <td align="">
                                                <label class="h6 mb-0 text-center">{{$photo[0]}}</label>
                                            </td>
                                            <td align="center">
                                                <label class="h6 mb-0 text-center fw-bolder">
                                                    <img src="{{ url('getimage/'.base64_encode($offered[$photo[1]])) }}" style="height:150px;width:150px;object-fit:contain" />
                                                </label>
                                            </td>
                                            <td>
                                                <input type="file" class="form-control" name="inp[{{$offered->pr_id}}][{{$photo[1]}}]" required accept="image/*">
                                                <small class="text-danger">
                                                    *Please upload image in .jpg, .png format
                                                </small>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @foreach ([
                                            ['Wattage', 'pr_light_source'],
                                            ['Lumen Output', 'pr_lumen_output'],
                                            ['Color Temperature', 'pr_color_temperature'],
                                            ['Beam Angle', 'pr_optical'],
                                            ['CRI', 'pr_color_rendering'],
                                            ['IP Rating', 'pr_ip_rating'],
                                            ['Driver Type', 'pr_driver'],
                                            ['Notes', 'pspo_notes'],
                                        ] as $field)
                                            <tr>
                                                <td align="">
                                                    <label class="h6 mb-0 text-center">{{$field[0]}}</label>
                                                </td>
                                                <td align="center">
                                                    @if($field[1] == 'ms_lum_types_name')
                                                        <label class="h6 mb-0 text-center fw-bolder">{{$offered->lumtype[$field[1]] ?? '-'}}</label>
                                                    @elseif($field[1] == 'ms_brand_name')
                                                        <label class="h6 mb-0 text-center fw-bolder">{{$offered->brand[$field[1]] ?? '-'}}</label>
                                                    @else
                                                        <label class="h6 mb-0 text-center fw-bolder">{{$offered[$field[1]] ?? '-'}}</label>
                                                    @endif
                                                </td>
                                                <td>
                                                    <input placeholder='Input Someting' class="form-control product-{{$offered->pr_id}}-inputs"
                                                        name="inp[{{$offered->pr_id}}][{{$field[1]}}]" required />
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td align="">
                                                <label class="h6 mb-0 text-center">Product Support Attachment</label><br/>
                                                <small class="text-info">example: Accessories, Drivers, etc...</small>
                                            </td>
                                            <td align="center">
                                                -
                                            </td>
                                            <td>
                                                <input type="file" class="form-control" name="inp[{{$offered->pr_id}}][pr_accessories_photo]" accept="image/*">
                                                <small class="text-danger">
                                                    *Please upload image in .jpg, .png format
                                                </small>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="d-flex">
            <button class="btn btn-primary ms-auto" type="button" onclick="submitForm()"><i class="bx bx-save"></i> Submit Form</button>
        </div>
    </form>
@endsection

@section('js_section')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let select = null
        let toggleAccordion = true

        $('.alternative').hide()

        $('.btn-check').click(function() {
            select = $(this).attr('id').replace('-psto_supplied_as-1','').replace('-psto_supplied_as-2','')
            if($(this).val() != 'as-specified'){
                $('#'+select+'-alternative').show()
                $('#'+select+'-as-specified').hide()
            }
            else {
                $('#'+select+'-as-specified').show()
                $('#'+select+'-alternative').hide()
            }
        })

        function collapseAll(){
            if(toggleAccordion){
                closeAllAccordion()
                toggleAccordion = false
            }
            else {
                openAllAccordion()
                toggleAccordion = true
            }
        }

        document.getElementById("collapse-button").addEventListener ("click", collapseAll);

        function openAllAccordion(){
            var acc = $(".accordion-collapse");
            var i;

            for (i = 0; i < acc.length; i++) {
                $(acc[i]).addClass("show");
                $(acc[i]).removeClass("collapse");
            }

        }

        function closeAllAccordion(){
            var acc = $(".accordion-collapse");
            var i;

            for (i = 0; i < acc.length; i++) {
                $(acc[i]).removeClass("show");
                $(acc[i]).addClass("collapse");
            }

        }

        function submitForm(){
            if ($('#frm-produk').valid()) {
                Swal.fire({
                    title: 'Do you want to save the changes?',
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData($('#frm-produk')[0]);
                        $.ajax({
                            url: "{{ url('api/tender/form') }}",
                            type: 'post',
                            data: formData,
                            contentType: false, //untuk upload image
                            processData: false, //untuk upload image
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            timeout: 300000, // sets timeout to 3 seconds
                            dataType: 'json',
                            success: function(e) {
                                if (e.status == 'success') {
                                    new Noty({
                                        text: e.message,
                                        type: 'info',
                                        progressBar: true,
                                        timeout: 1000
                                    }).show();
                                    setTimeout(function() {
                                        window.location.href = "{{ url('tender/submission-form/success') }}"
                                    }, 1000);
                                } else {
                                    new Noty({
                                        text: e.message,
                                        type: 'info',
                                        progressBar: true,
                                        timeout: 1000
                                    }).show();;
                                }
                            }
                        });
                    }
                })
            }
        }

    </script>
@endsection
