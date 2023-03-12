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
            <select class="select2 form-control" multiple placeholder="All Companies">
                @foreach ($project->tenders as $t)
                    <option value="{{$t->pst_id}}">{{$t->psto_company_name}}</option>
                @endforeach
            </select>
            <small class="text-danger">* Leave it blank to filter all companies</small>
        </div>
        <div class="col-lg-3">
            <label class="form-label">For Spec</label>
            <select class="select2 form-control" multiple placeholder="All Speces">
                @foreach ($project->stage_products as $p)
                    <option value="{{$p->psp_pr_id}}">{{$p->product->pr_code}}</option>
                @endforeach
            </select>
            <small class="text-danger">* Leave it blank to filter all speces</small>
        </div>
        <div class="col-lg-3">
            <label class="form-label">From Date</label>
            <input class="form-control mb-2" type="date" />
        </div>
        <div class="col-lg-3 d-flex align-items-center" style="gap:10px">
            <button class="btn btn-primary mb-2 flex-fill">
                Filter Tenders
            </button>
            <a href="{{url('api/tender/comparison/excel/'.$id)}}" target="_blank" class="btn btn-success mb-2 btn-icon">
                <i class="bx bxs-spreadsheet"></i>
            </a>
            <a href="{{url('api/tender/comparison/pdf/'.$id)}}" target="_blank" class="btn btn-danger btn-icon mb-2">
                <i class="bx bxs-file-pdf"></i>
            </a>
        </div>
    </div>
</div>


<div class="d-flex flex-wrap  align-items-center" style="gap:10px">
    <ul class="nav nav-tabs mb-0" role="tablist">
        <li class="nav-item">
            <a class="nav-link">Comparison</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active">Detailed Comparison</a>
        </li>
    </ul>
</div>
<div class="card table-responsive">
    <table class="table table-bordered">
        <tr class="table-dark">
            <th>SPEC</th>
            <th colspan="2">Original</th>
            @foreach ($project->tenders as $item)
                <th>{{$item->psto_company_name}}</th>
            @endforeach
        </tr>
        @foreach ($project->stage_products as $product)
            @foreach ($comparison_table as $key => $label)
                <tr>
                    @if ($key == 'ms_lum_types_name')
                    <td rowspan="15" style="background:#CCCCCC;width:80px" class="text-truncate">{{$product->product_offered->pr_code}}</td>
                    @endif
                    <td style="width:150px" class="text-white bg-secondary text-truncate">{{$label}}</td>
                    @if ($key == 'ms_lum_types_name')
                    <td class="text-truncate">{{$product->product_offered->lumtype[$key] ?? '-'}}</td>
                    @elseif ($key == 'ms_brand_name')
                    <td class="text-truncate">{{$product->product_offered->brand[$key] ?? '-'}}</td>
                    @elseif ($key == 'pr_main_photo' || $key == 'pr_dimension_photo' || $key == 'pr_photometric_photo')
                    <td>
                        <img src="{{url('getimage/'.base64_encode($product->product_offered[$key]))}}" style="width:100px" />
                    </td>
                    @else
                    <td class="text-truncate">{{$product->product_offered[$key] ?? '-'}}</td>
                    @endif
                    @foreach ($project->tenders as $tender)
                        @if ($key == 'pr_main_photo' || $key == 'pr_dimension_photo' || $key == 'pr_photometric_photo')
                            <td>
                                <img src="{{url('getimage/'.base64_encode($companies_product[$product->product_offered->pr_code][$tender->pst_id][$key]))}}" style="width:100px" />
                            </td>
                        @else
                            @php
                                if($key == 'ms_lum_types_name') $key = 'pr_luminaire_type';
                                else if($key == 'ms_brand_name') $key = 'pr_manufacturer';
                            @endphp
                            <td class="text-truncate">{{$companies_product[$product->product_offered->pr_code][$tender->pst_id][$key] ?? '-'}}</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
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
    </script>
@endsection
