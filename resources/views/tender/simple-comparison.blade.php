@extends('layouts.layout1')

@section('css_section')
@endsection

@section('page_title')
    Tender Comparison
@endsection

@section('sidebar-size', 'expanded')
@section('url_back', url('/projects'))

@section('content')

<div class="card card-body">
    <h2 class="fw-bolder">Filter Tender Records</h2>
    <div class="row align-items-end">
        <div class="col-lg-3">
            <label class="form-label">For Company</label>
            <select class="select2 form-control" multiple placeholder="All Companies" id="filter-companies">
                @foreach ($tenders as $t)
                    <option value="{{$t->pst_id}}" {{str_contains($filter_companies, $t->pst_id) ? 'selected' : ''}}>{{$t->psto_company_name}}</option>
                @endforeach
            </select>
            <small class="text-danger">* Leave it blank to filter all companies</small>
        </div>
        <div class="col-lg-3">
            <label class="form-label">For Spec</label>
            <select class="select2 form-control" multiple placeholder="All Speces" id="filter-speces">
                @foreach ($stage_product as $p)
                    <option value="{{$p->psp_pr_id}}" {{str_contains($filter_speces, $p->psp_pr_id) ? 'selected' : ''}}>{{$p->product->pr_code}}</option>
                @endforeach
            </select>
            <small class="text-danger">* Leave it blank to filter all speces</small>
        </div>
        <div class="col-lg-3">
            <label class="form-label">From Date</label>
            <input class="form-control mb-2" type="date" id="filter-date" value="{{$filter_date}}" />
        </div>
        <div class="col-lg-3 d-flex align-items-center" style="gap:10px">
            <button class="btn btn-primary mb-2 flex-fill" onclick="filterNow()">
                Filter Tenders
            </button>
            <button onclick="exportExcel()" target="_blank" class="btn btn-success mb-2 btn-icon">
                <i class="bx bxs-spreadsheet"></i>
            </button>
            <button onclick="exportPDF()" target="_blank" class="btn btn-danger btn-icon mb-2">
                <i class="bx bxs-file-pdf"></i>
            </button>
        </div>
    </div>
</div>


<div class="d-flex flex-wrap  align-items-center" style="gap:10px">
    <ul class="nav nav-tabs mb-0" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" href="{{url('/tender/comparison-simple/'.$id)}}">Comparison</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('/tender/comparison/'.$id)}}">Detailed Comparison</a>
        </li>
    </ul>
</div>
<div class="card table-responsive">
    <table class="table table-bordered">
        <tr class="table-dark">
            <th>SPEC</th>
            <th style="text-align:center">Description</th>
            @foreach ($project->tenders as $item)
                <th class="text-truncate" style="text-align:center">{{$item->psto_company_name}}</th>
            @endforeach
        </tr>
        @foreach ($project->stage_products as $product)
            <tr>
                <td style="background:#CCCCCC;width:80px" class="text-truncate">{{$product->product_offered->pr_code}}</td>
                <td style="text-align: center;width:300px">
                    <div style="font-weight:bolder">{{$product->product_offered->lumtype->ms_lum_types_name}}</div>
                    <div class="text-truncate">Wattage : {{$product->product_offered->pr_light_source}}</div>
                    <div class="text-truncate">Lumen : {{$product->product_offered->pr_lumen_output}}</div>
                    <div class="text-truncate">Col. Temp : {{$product->product_offered->pr_color_temperature}}</div>
                    <div class="text-truncate">Beam : {{$product->product_offered->pr_optical}}</div>
                    <div class="text-truncate">CRI : {{$product->product_offered->pr_color_rendering}}</div>
                    <div class="text-truncate">IPR : {{$product->product_offered->pr_ip_rating}}</div>
                    <div class="text-truncate">Driver : {{$product->product_offered->pr_driver}}</div>
                </td>
                @foreach ($project->tenders as $tender)
                    <td style="text-align:center">
                        @if($companies_product[$product->product_offered->pr_id][$tender->pst_id]->psto_supplied_as == 'as-specified')
                            <div style="color:#29C66F;font-weight:bolder">
                                AS SPECIFIED
                            </div>
                        @else
                            @if($companies_product[$product->product_offered->pr_id][$tender->pst_id]->psto_status == 'Comply')
                                <div style="color:#2A4C6B;font-weight:bolder">
                                    COMPLY
                                </div>
                            @else
                                <div style="color:red;font-weight:bolder">
                                    NOT COMPLY
                                </div>
                                <div style="color:red;font-weight:bolder">( {{$companies_product[$product->product_offered->pr_id][$tender->pst_id]->psto_error}} )
                                </div>
                            @endif
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>
</div>

<div class="py-2">
</div>

@endsection

@section('js_section')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });

        function filterNow(){
            let companies = $('#filter-companies').val();
            let speces = $('#filter-speces').val();
            let date = $('#filter-date').val();

            if(companies == null || companies.length == 0){
                companies = '';
            }else{
                companies = companies.join(',');
            }

            if(speces == null || speces.length == 0){
                speces = '';
            }else{
                speces = speces.join(',');
            }

            window.location.href = "{{url('tender/comparison-simple/'.$id)}}?companies="+companies+"&speces="+speces+"&date="+date;
        }

        function exportExcel(){
            let companies = $('#filter-companies').val();
            let speces = $('#filter-speces').val();
            let date = $('#filter-date').val();

            if(companies == null || companies.length == 0){
                companies = '';
            }else{
                companies = companies.join(',');
            }

            if(speces == null || speces.length == 0){
                speces = '';
            }else{
                speces = speces.join(',');
            }

            window.open("{{url('api/tender/comparison/excel-simple/'.$id)}}?companies="+companies+"&speces="+speces+"&date="+date)
        }

        function exportPDF(){
            let companies = $('#filter-companies').val();
            let speces = $('#filter-speces').val();
            let date = $('#filter-date').val();

            if(companies == null || companies.length == 0){
                companies = '';
            }else{
                companies = companies.join(',');
            }

            if(speces == null || speces.length == 0){
                speces = '';
            }else{
                speces = speces.join(',');
            }

            window.open("{{url('api/tender/comparison-simple/pdf/'.$id)}}?companies="+companies+"&speces="+speces+"&date="+date)

        }
    </script>
@endsection
