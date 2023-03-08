@extends('layouts.layout1')

@section('css_section')

@endsection

@section('page_title')
    Project Form
@endsection

@section('sidebar-size', 'expanded')
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
                        <h4 class="mb-0 me-auto fw-bolder">Project Form</h4>
                        <button class="btn btn-primary" onclick="save()">
                            <i class="bx bx-save"></i> Save Project Info
                        </button>
                        {{-- @if ($id)
                            <button class="btn btn-danger" onclick="delF()">
                                <i class="bx bx-save"></i> Delete Projects
                            </button>
                        @endif --}}
                    </div>

                    <form id="frm" class="mt-2">
                        @csrf
                        <input type="hidden" id="prj_id" name="id" />
                        <div class="row" style="gap: 10px 0">
                            <div class="col-lg-4">
                                <label class="form-label">Project Name</label>
                                <input type="text" placeholder='Input Someting' class="form-control" name="inp[prj_name]" required id="prj_name">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Location</label>
                                <input type="text" placeholder='Input Someting' class="form-control" required name="inp[prj_location]" id="prj_location">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">Company</label>
                                <select class="form-control select2" id="prj_company_id" name="inp[prj_company_id]" required>
                                    <option value="">Select Company</option>
                                    @foreach ($company as $item)
                                        <option value="{{$item->ms_company_id}}">{{$item->ms_company_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>

                </div>


                <div class="">
                    @include('projects.components.navs')
                    <div class="card card-body">
                        @include('projects.components.stage')
                        <hr/>
                        @include('projects.components.products')
                    </div>
                </div>

                @include('projects.components.modal-add-product')


            </div>
        </div>
    </div>
@endsection

@section('js_section')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function(){
            $('#ps_stage_id').trigger('change')
        })

        var select = $('.select2')

        @if ($id)
            edit('{{ $id }}')
        @endif

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
                                window.location.href = '{{url("projects/")}}/'+e.id+'/form'
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

        function saveStageForm() {
            if ($("#form-stage").valid()) {
                var formData = new FormData($('#form-stage')[0]);
                $.ajax({
                    url: '{{ url('api/projects/stage') }}',
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

        @if($selected_stage)
        function export_pdf() {
            window.open('{{ url("api/projects/$id/export/pdf/$selected_stage->ps_id") }}', '_blank');
        }

        function export_excel(){
            window.open('{{ url("api/projects/$id/export/excel/$selected_stage->ps_id") }}', '_blank');
        }
        @endif

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

        @if($selected_stage)
        function addNewLevel(){
            let formData = new FormData()
            formData.append('inp[ps_level_name]', 'Default Level')
            formData.append('inp[ps_prj_id]', '{{$selected_stage->ps_prj_id}}')
            $.ajax({
                url: '{{ url('api/projects/stage') }}',
                type: 'post',
                data: formData,
                contentType: false, //untuk upload image
                processData: false, //untuk upload image
                timeout: 300000, // sets timeout to 3 seconds
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
                        setTimeout(function() {
                            window.location.href = '{{url("projects/")}}/{{$selected_stage->ps_prj_id}}/form/'+e.id
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
        @endif

        let dTable = null
        function searchProduct(){
            $('#modal-search-product').modal('show')
            if(!dTable){
                dTable = $('#table-product').DataTable({
                    ajax: {
                        url: "{{ url('api/masterdata/products/list') }}",
                        type: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    },
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
                $('.custom-button').append(`
                    <div class="btn btn-primary" onclick="assign_product()">
                        Assign Product
                    </div>
                `)
            }
        }

        @if($selected_stage)
        function assign_product(){
            let selected_product = []
            $('input[name="selected_products[]"]').each(function(){
                if($(this).is(':checked')){
                    selected_product.push($(this).val())
                }
            })

            let formData = new FormData()
            formData.append('ps_id', '{{$selected_stage->ps_id}}')
            formData.append('pr_ids', selected_product)
            $.ajax({
                url: '{{ url('api/projects/stage/product') }}',
                type: 'post',
                data: formData,
                contentType: false, //untuk upload image
                processData: false, //untuk upload image
                timeout: 300000, // sets timeout to 3 seconds
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
                        $('#modal-search-product').modal('hide')
                        setTimeout(function() {
                            location.reload()
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
        @endif

        function saveFormProduk(id) {
            if ($('#'+id).valid()) {
                var formData = new FormData($('#'+id)[0]);
                $.ajax({
                    url: '{{ url('api/projects/product-offered') }}',
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
                                location.reload()
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

        function delFormProduk(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this data!',
                showCancelButton: true,
                confirmButtonText: 'Proceed',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url("api/projects/product-offered/") }}/'+id,
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
                                    location.reload()
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
