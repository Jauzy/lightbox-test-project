@extends('layouts.layout1')

@section('css_section')

@endsection

@section('page_title')
    Masterdata Categories
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
            <div class="content-body">
                <section class="">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table">
                                <thead>
                                    <tr>
                                        <th width="10%">Action</th>
                                        <th>Category Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <!-- add new card modal  -->
    <div class="modal fade" id="frmbox" tabindex="-1" aria-labelledby="frmbox-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <h5 class="modal-title">Form Masterdata Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-3 pb-2">
                    <!-- form -->
                    <form id="frm" class="row gy-1 gx-2">
                        @csrf
                        <input type="hidden" name="ms_cat_id" id="ms_cat_id">
                        <div class="col-12">
                            <label class="form-label" for="modalAddCardNumber">Category Name</label>
                            <div class="input-group input-group-merge">
                                <input id="ms_cat_name" name="inp[ms_cat_name]" class="form-control add-credit-card-mask"
                                    type="text" />
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-primary me-1 mt-1" onclick="save()">Submit</a>
                            <button type="reset" class="btn btn-outline-secondary mt-1" data-bs-dismiss="modal"
                                aria-label="Close">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ add new card modal  -->

    <div class="modal fade" id="modal-search-product" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <div class="modal-title"><i data-feather="filter"></i> <span id="file-title">Search Products</span></div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-2 position-relative">
                    <table class="table table-striped" id="table-product">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="50%">LUMEN</th>
                                <th>APPLICATION</th>
                                <th>MANUFACTURER / SUPPLIER</th>
                                <th>MODEL</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <input id="category_id" type="hidden" />
@endsection

@section('js_section')
    <script>
        var dTable = $('#table'),
            select = $('.select2'), tableProduct = $('#table-product')

        function searchProduct(id){
            $('#category_id').val(id)
            tableProduct.draw()
            $('#modal-search-product').modal('show')
        }

        // List datatable
        $(function() {
            tableProduct = $('#table-product').DataTable({
                ajax: {
                    url: "{{ url('api/masterdata/products/list') }}",
                    type: 'post',
                    data: function(d) {
                        d.category_id = $('#category_id').val()
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                buttons: [],
                columns: [
                    { data: 'checkbox' },
                    { data: 'lumen' },
                    { data: 'pr_application' },
                    { data: 'pr_manufacturer' },
                    { data: 'pr_model' },
                ],
                order: [
                    [1, 'desc']
                ],
                "bFilter": false,
            });

            dTable = $('#table').DataTable({
                ajax: {
                    url: "{{ url('api/masterdata/categories/dt') }}",
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'ms_cat_name',
                        name: 'ms_cat_name'
                    },
                ],
                order: [
                    [1, 'desc']
                ],
                buttons: [{
                    text: 'Add New',
                    className: 'add-new btn btn-primary',
                    action: function(e, dt, node, config) {
                        addnew()
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                    }
                }],
                "bFilter": false,
            });

            $('.dataTables_filter input[type=search]').attr('placeholder', 'Pencarian').attr('class', 'form-control form-control-sm');
            $('.dataTables_filter select[name=table_length]').attr('class', 'form-select form-select-sm');
        })

        function addnew() {
            $('#frmbox').modal('show');
            $('#frm')[0].reset();
            $('#frm input[name="inp[ms_cat_id]"]').val('');
        }

        function save() {
            if ($("#frm").valid()) {
                var formData = new FormData($('#frm')[0]);

                $.ajax({
                    url: '{{ url('api/masterdata/categories') }}',
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
                            $("#frmbox").modal('hide');
                            dTable.draw();
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

        function edit(id) {
            $.ajax({
                url: '{{ url('api/masterdata/categories/') }}' + '/' + id,
                type: 'get',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(e) {
                    $.each(e, function(key, value) {
                        if ($('#' + key).hasClass("select2")) {
                            $('#' + key).val(value).trigger('change');
                            $('#' + key).attr('disabled', true);
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
                                    $("input[n  ame='inp[" + key + "][]'][value='" + temp[i] + "']").prop(
                                        'checked', true);
                                }
                                $.uniform.update();
                            }
                        } else {
                            $('#' + key).val(value);
                        }
                    });

                    $("#frmbox").modal('show');
                }
            });
        }

        function del(id) {
            if (confirm('Apakah anda yakin akan menghapus data ini?')) {
                $.ajax({
                    url: '{{ url('api/masterdata/categories/') }}' + '/' + id,
                    type: 'delete',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(e) {
                        if (e.status == 'success') {
                            new Noty({
                                text: e.message,
                                type: 'info',
                                progressBar: true,
                                timeout: 1000
                            }).show();
                            dTable.draw();
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
