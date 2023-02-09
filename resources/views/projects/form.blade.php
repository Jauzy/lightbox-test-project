@extends('layouts.layout1')

@section('css_section')

@endsection

@section('page_title')
    Project Form
@endsection

@section('sidebar-size', 'collapsed')
@section('url_back', url('/projects'))

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
                        <h4 class="mb-0 me-auto">Projects Form</h4>
                        <button class="btn btn-primary" onclick="save()">
                            <i class="bx bx-save"></i> Save Form
                        </button>
                        @if ($id)
                            <a class="btn btn-success" href="{{url('projects/'.$id.'/submit-form')}}">
                                <i class="bx bx-save"></i> Generate Submission Form
                            </a>
                            <button class="btn btn-danger" onclick="delF()">
                                <i class="bx bx-save"></i> Delete Projects
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
                        <input type="hidden" id="prj_id" name="id" />
                        <div class="row" style="gap: 10px 0">
                            <div class="col-lg-4">
                                <label class="form-label">Company Name</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[prj_name]"
                                    id="prj_name">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Contact Person</label>
                                <input type="text" placeholder='Input Someting' class="form-control"
                                    name="inp[prj_contact_person]" id="prj_contact_person">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Email Address</label>
                                <input type="text" placeholder='Input Someting' class="form-control"
                                    name="inp[prj_email]" id="prj_email">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Phone Number</label>
                                <input type="text" placeholder='Input Someting' class="form-control"
                                    name="inp[prj_phone]" id="prj_phone">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Address</label>
                                <input type="text" placeholder='Input Someting' class="form-control"
                                    name="inp[prj_address]" id="prj_address">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">City</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[prj_city]"
                                    id="prj_city">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">State</label>
                                <input type="text" placeholder='Input Someting' class="form-control"
                                    name="inp[prj_state]" id="prj_state">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Country</label>
                                <input type="text" placeholder='Input Someting' class="form-control"
                                    name="inp[prj_country]" id="prj_country">
                            </div>
                        </div>
                    </form>

                </div>

                @if ($id)
                <div class="card ">
                    <div class="table-responsive">
                        <table class="table table-striped" id="table">
                            <thead>
                                <tr>
                                    <th width="50%">LUMEN</th>
                                    <th>MANUFACTURER / SUPPLIER</th>
                                    <th>MODEL</th>
                                    <th>STAGE * TENDERING</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="frm-product">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Form Product</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frm-box-product" class="mt-2">
                    @csrf
                    <input type="hidden" id="pr_id" name="inp[pr_id]" />
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
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="saveProductChange()">Save changes</button>
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

        function assign_product() {
            if ($('#product_id').val() == 'Search Product' || $('#pr_prj_location').val() == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select product and application location!',
                })
            } else {
                $.ajax({
                    url: '{{ url("api/projects/assign-product") }}',
                    type: 'post',
                    data: {
                        prj_id: '{{ $id }}',
                        product_id: $('#product_id').val(),
                        pr_prj_location: $('#pr_prj_location').val(),
                    },
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(e) {
                        if (e.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: e.message,
                            })
                            dTable.draw()
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: e.message,
                            })
                        }
                    }
                })
            }
        }

        @if ($id)
            edit('{{ $id }}')
        @endif

        $(function() {
            dTable = $('#table').DataTable({
                ajax: {
                    url: "{{ url('api/products/list') }}",
                    type: 'post',
                    data: {
                        prj_id: '{{ $id }}'
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    {
                        data: 'lumen'
                    },
                    {
                        data: 'pr_manufacturer'
                    },
                    {
                        data: 'pr_model'
                    },
                    {
                        data: 'pr_prj_location'
                    },
                ],
                order: [
                    [1, 'desc']
                ],
                "bFilter": false,
            });

            @if ($id)
            $('.custom-button').append(`
                <div class="d-flex flex-wrap" style="gap:10px">
                    <div style="width:200px">
                        <select id="product_id" class="form-control select2-product">
                            <option>Search Product</option>
                        </select>
                    </div>
                    <div style="width:200px">
                        <input id="pr_prj_location" class="form-control" placeholder="Stage" />
                    </div>
                    <button class="btn btn-primary" onclick="assign_product()">
                        Assign Product
                    </button>
                </div>
            `)
            @endif

            $(".select2-product").select2({
                ajax: {
                    url: '{{ url('api/products/search') }}', //URL for searching companies
                    dataType: "json",
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    delay: 200,
                    data: function(params) {
                        return {
                            value: params.term, //params send to companies controller
                        };
                    },
                    processResults: function(data) {
                        data = data.data?.map(item => {
                            return ({
                                id: item.pr_id,
                                text: `${item?.pr_code} / ${item?.pr_manufacturer}`
                            })
                        })
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                placeholder: "Search Product",
                minimumInputLength: 0,
            });
        })

        function edit(id) {
            $.ajax({
                url: '{{ url('api/projects/') }}' + '/' + id,
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
                }
            });
        }

        function save() {
            if ($("#frm").valid()) {
                var formData = new FormData($('#frm')[0]);
                $.ajax({
                    url: '{{ url('api/projects') }}',
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
                                // reload this page
                                location.reload();
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

        function export_pdf() {
            window.open('{{ url("api/projects/$id/export/pdf") }}', '_blank');
        }

        function export_excel(){
            window.open('{{ url("api/projects/$id/export/excel") }}', '_blank');
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
                        url: '{{ url("api/projects/$id") }}',
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
                                    window.location.href = '{{ url('projects') }}';
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

        function delProduct(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this data!',
                showCancelButton: true,
                confirmButtonText: 'Proceed',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url("api/projects/product/") }}/' + id,
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
                                dTable.draw()
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

        function editProduct(id) {
            // reset form
            $('#frm-box-product')[0].reset();
            $.ajax({
                url: '{{ url('api/projects/product/submit') }}' + '/' + id + '/{{$id}}',
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
                    $('#frm-product').modal('show');
                }
            });
        }

        function saveProductChange(){
            if($('#frm-box-product').valid()){
                var formData = new FormData($('#frm-box-product')[0]);
                formData.append('inp[pr_content]', fullEditor.root.innerHTML)
                $.ajax({
                    url: '{{ url('api/projects/product/submit') }}' + '/{{$id}}',
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
                            dTable.draw()
                            $('#frm-product').modal('hide');
                            // setTimeout(function() {
                            //     // reload this page
                            //     location.reload();
                            // }, 1000);
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
    </script>
@endsection
