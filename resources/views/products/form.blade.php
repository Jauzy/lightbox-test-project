@extends('layouts.layout1')

@section('css_section')

@endsection

@section('page_title')
    Product Form
@endsection

@section('sidebar-size', 'collapsed')
@section('url_back', url('/'))

@section('content')
    <div class="">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body pb-3">

                <div class="card card-body">

                    <div style="gap:10px" class="d-flex align-items-center flex-wrap">
                        <h4 class="mb-0 me-auto">Product Form</h4>
                        <button class="btn btn-primary" onclick="save()">
                            <i class="bx bx-save"></i> Save Form
                        </button>
                        @if($id)
                        <button class="btn btn-danger" onclick="delF()">
                            <i class="bx bx-save"></i> Delete Product
                        </button>
                        <button class="btn btn-secondary" onclick="export_pdf()">
                            <i class="bx bx-save"></i> Export PDF
                        </button>
                        <button class="btn btn-success" onclick="export_excel()">
                            <i class="bx bx-save"></i> Export Excel
                        </button>
                        @endif
                    </div>

                    <form id="frm" class="mt-2">
                        @csrf
                        <input type="hidden" id="pr_id" name="id" />
                        <div class="row" style="gap: 10px 0">
                            <div class="col-lg-4">
                                <label class="form-label">Code</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[pr_code]" id="pr_code">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Luminaire Type</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[pr_luminaire_type]" id="pr_luminaire_type">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Light Source</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[pr_light_source]" id="pr_light_source">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Application</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[pr_application]" id="pr_application">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Lumen Output</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[pr_lumen_output]" id="pr_lumen_output">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Lamp Type</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[pr_lamp_type]" id="pr_lamp_type">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Optical</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[pr_optical]" id="pr_optical">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Color Temperature</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[pr_color_temperature]" id="pr_color_temperature">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Color Rendering</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[pr_color_rendering]" id="pr_color_rendering">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Finishing</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[pr_finishing]" id="pr_finishing">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Lumen Maintenance</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[pr_lumen_maintenance]" id="pr_lumen_maintenance">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">IP Rating</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[pr_ip_rating]" id="pr_ip_rating">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Manufacturer</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[pr_manufacturer]" id="pr_manufacturer">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Model</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[pr_model]" id="pr_model">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Supplier</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[pr_supplier]" id="pr_supplier">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Unit Price</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[pr_unit_price]" id="pr_unit_price">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Driver</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[pr_driver]" id="pr_driver">
                            </div>
                            <div class="col-12 pb-1">
                                <label class="form-label">Product Content / Description</label>
                                <div id="full-wrapper">
                                    <div id="full-container">
                                        <div id="editor" style="min-height:200px">
                                            {{-- {!! $text !!} --}}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-xl-3">
                                <div style="height:300px" class="w-100 bg-secondary rounded mb-1">
                                    <img id="pr_main_photo_preview" class="w-100" style="object-fit: scale-down;height:300px" />
                                </div>
                                <label class="form-label">Main Photo</label>
                                <input type="file" class="form-control" name="pr_main_photo" accept=".png, .jpg">
                                <div class="form-text text-success" id="pr_main_photo">Already uploaded.</div>
                            </div>
                            <div class="col-lg-4 col-xl-3">
                                <div style="height:300px" class="w-100 bg-secondary rounded mb-1">
                                    <img id="pr_dimension_photo_preview" class="w-100" style="object-fit: scale-down;height:300px" />
                                </div>
                                <label class="form-label">Dimension Photo</label>
                                <input type="file" class="form-control" name="pr_dimension_photo" accept=".png, .jpg">
                                <div class="form-text text-success" id="pr_dimension_photo">Already uploaded.</div>
                            </div>
                            <div class="col-lg-4 col-xl-3">
                                <div style="height:300px" class="w-100 bg-secondary rounded mb-1">
                                    <img id="pr_photometric_photo_preview" class="w-100" style="object-fit: scale-down;height:300px" />
                                </div>
                                <label class="form-label">Photometric Photo</label>
                                <input type="file" class="form-control" name="pr_photometric_photo" accept=".png, .jpg">
                                <div class="form-text text-success" id="pr_photometric_photo">Already uploaded.</div>
                            </div>
                            <div class="col-lg-4 col-xl-3">
                                <div style="height:300px" class="w-100 bg-secondary rounded mb-1">
                                    <img id="pr_accessories_photo_preview" class="w-100" style="object-fit: scale-down;height:300px" />
                                </div>
                                <label class="form-label">Accessories Photo</label>
                                <input type="file" class="form-control" name="pr_accessories_photo" accept=".png, .jpg">
                                <div class="form-text text-success" id="pr_accessories_photo">Already uploaded.</div>
                            </div>

                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection

@section('js_section')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var select = $('.select2')

        var fullEditor = new Quill('#full-container #editor', {
            bounds: '#full-container #editor',
            modules: {
                formula: true,
                syntax: true,
                toolbar: []
            },
            theme: 'snow'
        });

        @if($id)
            edit('{{ $id }}')
        @endif

        function edit(id) {
            $.ajax({
                url: '{{ url('api/products/') }}' + '/' + id,
                type: 'get',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(e) {
                    $.each(e, function(key, value) {
                        if ($('#' + key).hasClass("select2")) {
                            $('#' + key).val(value).trigger('change');
                        } else if ($('input[type=radio]').hasClass(key)) {
                            if (value != "") {
                                $("input[name='inp[" + key + "]'][value='" + value + "']").prop(
                                    'checked', true);
                                $.uniform.update();
                            }
                        } else if ($('input[type=checkbox]').hasClass(key)) {
                            if (value != null) {
                                var temp = value.split('; ');
                                for (var i = 0; i < temp.length; i++) {
                                    $("input[name='inp[" + key + "][]'][value='" + temp[i] + "']").prop(
                                        'checked', true);
                                }
                                $.uniform.update();
                            }
                        } else {
                            $('#' + key).val(value);
                        }
                    });
                    if(e.pr_content) fullEditor.root.innerHTML = e.pr_content;
                    if(e.pr_main_photo) {
                        $('#pr_main_photo').show();
                        $('#pr_main_photo_preview').attr('src', '{{url("getimage")}}/' + btoa(e.pr_main_photo) );
                    } else {
                        $('#pr_main_photo').hide();
                    }
                    if(e.pr_dimension_photo) {
                        $('#pr_dimension_photo').show();
                        $('#pr_dimension_photo_preview').attr('src', '{{url("getimage")}}/' + btoa(e.pr_dimension_photo) );
                    } else {
                        $('#pr_dimension_photo').hide();
                    }
                    if(e.pr_photometric_photo){
                        $('#pr_photometric_photo').show();
                        $('#pr_photometric_photo_preview').attr('src', '{{url("getimage")}}/' + btoa(e.pr_photometric_photo) );
                    } else {
                        $('#pr_photometric_photo').hide();
                    }
                    if(e.pr_accessories_photo){
                        $('#pr_accessories_photo').show();
                        $('#pr_accessories_photo_preview').attr('src', '{{url("getimage")}}/' + btoa(e.pr_accessories_photo) );
                    } else {
                        $('#pr_accessories_photo').hide();
                    }
                }
            });
        }

        function save() {
            if ($("#frm").valid()) {
                var formData = new FormData($('#frm')[0]);
                formData.append('inp[pr_content]', fullEditor.root.innerHTML)
                $.ajax({
                    url: '{{ url('api/products') }}',
                    type: 'post',
                    data: formData,
                    contentType: false, //untuk upload image
                    processData: false, //untuk upload image
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
                                window.location.href = '{{ url('products') }}';
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
        }

        function export_pdf(){
            window.open('{{ url("api/products/$id/export/pdf") }}', '_blank');
        }

        function export_excel(){
            window.open('{{ url("api/products/$id/export/excel") }}', '_blank');
        }

        function delF() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this data!',
                showCancelButton: true,
                confirmButtonText: 'Proceed',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url("api/products/$id") }}',
                        type: 'delete',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
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
                                    window.location.href = '{{ url('products') }}';
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

    </script>
@endsection
