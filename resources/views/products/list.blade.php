@extends('layouts.layout1')

@section('css_section')

@endsection

@section('page_title')
    Product List
@endsection

@section('sidebar-size', 'expanded')
@section('url_back', url('/'))

@section('content')
    <div class="">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body pb-3">
                <section class="">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table">
                                <thead>
                                    <tr>
                                        {{-- <th width="5%">#</th> --}}
                                        <th width="50%">LUMEN</th>
                                        <th>APPLICATION</th>
                                        <th>MANUFACTURER / SUPPLIER</th>
                                        <th>MODEL</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- list and filter end -->
                </section>
                <!-- users list ends -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="frmbox" tabindex="-1" aria-labelledby="frmbox-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <h5 class="modal-title">Product Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-3 pb-2">
                    <div class="row" style="gap: 10px 0">
                        <div class="col-lg-4">
                            <label class="form-label">Code</label>
                            <div id="pr_code">-</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Luminaire Type</label>
                            <div id="pr_luminaire_type">-</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Light Source</label>
                            <div id="pr_light_source">-</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Application</label>
                            <div id="pr_application">-</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Lumen Output</label>
                            <div id="pr_lumen_output">-</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Lamp Type</label>
                            <div id="pr_lamp_type">-</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Optical</label>
                            <div id="pr_optical">-</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Color Temperature</label>
                            <div id="pr_color_temperature">-</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Color Rendering</label>
                            <div id="pr_color_rendering">-</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Finishing</label>
                            <div id="pr_finishing">-</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Lumen Maintenance</label>
                            <div id="pr_lumen_maintenance">-</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">IP Rating</label>
                            <div id="pr_ip_rating">-</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Manufacturer</label>
                            <div id="pr_manufacturer">-</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Model</label>
                            <div id="pr_model">-</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Supplier</label>
                            <div id="pr_supplier">-</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Unit Price</label>
                            <div id="pr_unit_price">-</div>
                        </div>
                        <div class="col-lg-4">
                            <label class="form-label">Driver</label>
                            <div id="pr_driver">-</div>
                        </div>
                        <div class="col-12 pb-1">
                            <label class="form-label">Product Content / Description</label>
                            <div id="pr_content">-</div>
                        </div>

                        <div class="col-lg-4 col-xl-3">
                            <label class="form-label">Main Photo</label>
                            <div style="height:200px" class="w-100 bg-secondary rounded mb-1">
                                <img id="pr_main_photo_preview" class="w-100" style="object-fit: scale-down;height:200px" />
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-3">
                            <label class="form-label">Dimension Photo</label>
                            <div style="height:200px" class="w-100 bg-secondary rounded mb-1">
                                <img id="pr_dimension_photo_preview" class="w-100" style="object-fit: scale-down;height:200px" />
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-3">
                            <label class="form-label">Photometric Photo</label>
                            <div style="height:200px" class="w-100 bg-secondary rounded mb-1">
                                <img id="pr_photometric_photo_preview" class="w-100" style="object-fit: scale-down;height:200px" />
                            </div>
                        </div>
                        <div class="col-lg-4 col-xl-3">
                            <label class="form-label">Accessories Photo</label>
                            <div style="height:200px" class="w-100 bg-secondary rounded mb-1">
                                <img id="pr_accessories_photo_preview" class="w-100" style="object-fit: scale-down;height:200px" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="frm-import" enctype="multipart/form-data">
        @csrf
        <input type="file" id="file" name="file" accept=".xlsx" style="display:none;" />
    </form>
@endsection

@section('js_section')
    <script>
        var dTable = $('#table'),
            select = $('.select2')

        // List datatable
        $(function() {
            dTable = $('#table').DataTable({
                ajax: {
                    url: "{{ url('api/masterdata/products/list') }}",
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: 'lumen' },
                    { data: 'pr_application' },
                    { data: 'pr_manufacturer' },
                    { data: 'pr_model' },
                    { data: 'action' },
                ],
                order: [
                    [1, 'desc']
                ],
                "bFilter": false,
            });

            $('.custom-button').append(`
                <div class="d-flex flex-wrap" style="gap:10px">
                    <button class="btn btn-success font-weight-semibold text-nowrap" onclick="impor_template()">
                        <i class="bx bx-spreadsheet"></i> <span class="d-none d-lg-inline-block">Import Products</span>
                    </button>
                    <button class="btn btn-primary font-weight-semibold text-nowrap" onclick="addnew()">
                        <i class="bx bx-plus"></i> <span class="d-none d-lg-inline-block">Add New Product</span>
                    </button>
                </div>
            `)
        })

        function addnew(){
            window.location.href = "{{ url('masterdata/products/new') }}";
        }

        function edit(code){
            window.location.href = "{{ url('masterdata/products/') }}/" + code + '/form';
        }

        function impor_template() {
            document.getElementById("file").click();
        };

        $('#file').change(function(){
            if ($("#frm-import").valid()) {
                var formData = new FormData($('#frm-import')[0]);
                $.ajax({
                    url: '{{ url("api/masterdata/products/import") }}',
                    type: 'post',
                    data: formData,
                    contentType: false, //untuk upload image
                    processData: false, //untuk upload image
                    timeout: 300000, // sets timeout to 3 seconds
                    success: function(e) {
                        new Noty({
                            text: 'Berhasil impor data',
                            type: 'success',
                            timeout: 3000,
                            layout: 'topRight'
                        }).show();
                        dTable.draw()
                    }
                });
            }
        })

        function detail(id){
            $.ajax({
                url: '{{ url('api/masterdata/products/') }}' + '/' + id,
                type: 'get',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(e) {
                    $.each(e, function(key, value) {
                        $('#' + key).html(value);
                    });
                    if(e.pr_main_photo) {
                        $('#pr_main_photo_preview').attr('src', '{{url("getimage")}}/' + btoa(e.pr_main_photo) );
                    }
                    if(e.pr_dimension_photo) {
                        $('#pr_dimension_photo_preview').attr('src', '{{url("getimage")}}/' + btoa(e.pr_dimension_photo) );
                    }
                    if(e.pr_photometric_photo){
                        $('#pr_photometric_photo_preview').attr('src', '{{url("getimage")}}/' + btoa(e.pr_photometric_photo) );
                    }
                    if(e.pr_accessories_photo){
                        $('#pr_accessories_photo_preview').attr('src', '{{url("getimage")}}/' + btoa(e.pr_accessories_photo) );
                    }
                    $('#frmbox').modal('show');
                }
            });
        }
    </script>
@endsection
