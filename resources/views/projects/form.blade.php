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
                                    <th>STAGE</th>
                                    <th>ACTION</th>
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
@endsection

@section('js_section')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var select = $('.select2')


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
                    {
                        data: 'action_del'
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
    </script>
@endsection
