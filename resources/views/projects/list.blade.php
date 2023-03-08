@extends('layouts.layout1')

@section('css_section')

@endsection

@section('page_title')
    Project List
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
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>Company</th>
                                        <th>Level</th>
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
@endsection

@section('js_section')
    <script>
        var dTable = $('#table'),
            select = $('.select2')

        // List datatable
        $(function() {
            dTable = $('#table').DataTable({
                ajax: {
                    url: "{{ url('api/projects/list') }}",
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [
                    { data: 'name' },
                    { data: 'prj_location' },
                    { data: 'company' },
                    { data: 'level' },
                ],
                order: [
                    [1, 'desc']
                ],
                "bFilter": false,
            });
            $('.custom-button').append(`
                <div class="d-flex flex-wrap" style="gap:10px">
                    <button class="btn btn-primary font-weight-semibold text-nowrap" onclick="addnew()">
                        <i class="bx bx-plus"></i> <span class="d-none d-lg-inline-block">Add New Project</span>
                    </button>
                </div>
            `)
        })

        function addnew(){
            window.location.href = "{{ url('projects/new') }}";
        }

        function edit(code){
            window.location.href = "{{ url('projects/') }}/" + code + '/form';
        }

        function toggleTender(id){
            $.ajax({
                url: "{{ url('api/projects/stage/toggle-tender') }}",
                type: 'post',
                data: {
                    id: id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data){
                    if(data.status == 'success'){
                        dTable.draw();
                    }
                }
            })
        }

    </script>
@endsection
