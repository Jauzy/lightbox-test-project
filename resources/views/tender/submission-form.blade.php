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
        <div class="d-flex justify-content-between flex-wrap mb-2">
            <h1 style="font-weight: 900" class="fw-bolder display-4">Tender Form</h1>
            <img src="{{asset('lightbox.png')}}" style="max-width: 300px;object-fit:contain" />
        </div>

        <div class="card">
            <div class="card-header p-1 mb-1 fw-bolder" style="background:#D2E4FC" >
                Company Details
            </div>
            <div class="card-body row">
                <div class="row" style="gap: 10px 0">
                    @foreach (['Company Name', 'Contact person', 'Email Address', 'Phone Number', 'Address', 'City', 'State', 'Country'] as $item)
                    <div class="col-lg-4">
                        <label class="form-label">{{$item}}</label>
                        <input type="text" placeholder='Input Someting' class="form-control" name="inp[prj_name]" required id="prj_name">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="">
            <div class="">
                <div class="accordion accordion-margin" id="accordionMargin" data-toggle-hover="true">
                    @foreach ($project->stage_products as $item)
                        <div class="accordion-item mb-1">
                            <h2 class="accordion-header" id="heading{{ $item->product_offered->pr_id }}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    style="background:#D2E4FC" data-bs-target="#accordion{{ $item->product_offered->pr_id }}">

                                    <div class="d-flex align-items-center w-100 justify-content-between flex-wrap"
                                        style="gap:10px">
                                        <div>
                                            Spec. Code <strong class="ms-1">HSP1</strong>
                                        </div>
                                    </div>

                                </button>
                            </h2>

                            <div id="accordion{{ $item->product_offered->pr_id }}" class="accordion-collapse show"
                                aria-labelledby="heading{{ $item->product_offered->pr_id }}">
                                <div class="accordion-body p-0">
                                    <input type="hidden" id="pr_id" name="id"
                                        value="{{ $item->product_offered->pr_id }}" />

                                    <div class="d-flex   flex-wrap align-items-center my-1 mx-2" style="gap:10px">
                                        <h1 class="fw-bolder h6 mb-0 me-auto">Please enter product details for tender</h1>
                                        <h6 class="mb-0">Tendering</h6>
                                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                            <input type="radio" class="btn-check" name="btnradio" id="btnradio1"
                                                autocomplete="off" checked="">
                                            <label class="btn btn-primary btn-sm waves-effect" for="btnradio1">As
                                                Specified</label>

                                            <input type="radio" class="btn-check" name="btnradio" id="btnradio2"
                                                autocomplete="off">
                                            <label class="btn btn-primary btn-sm waves-effect"
                                                for="btnradio2">Alternative</label>
                                        </div>
                                    </div>

                                    <table class="table table-striped table-bordered">
                                        <tr>
                                            <th colspan="2">Product Required</th>
                                            <th>Product Tendered</th>
                                        </tr>
                                        @foreach ([1, 2, 3] as $field)
                                            <tr>
                                                <td align="">
                                                    <label class="h6 mb-0 text-center">Luminaire type</label>
                                                </td>
                                                <td align="center">
                                                    <label class="h6 mb-0 text-center fw-bolder">SPIKE LIGHT</label>
                                                </td>
                                                <td>
                                                    <input type="text"
                                                        value="{{ $item->product_offered->brand->ms_brand_name }}"
                                                        placeholder='Input Someting' class="form-control" required
                                                        name="inp[pr_color_temperature]" id="pr_color_temperature">
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td align="">
                                                <label class="h6 mb-0 text-center">Photo</label>
                                            </td>
                                            <td align="center">
                                                <label class="h6 mb-0 text-center fw-bolder">
                                                    <img src="{{ asset('/storage/product/DL1-66.main.png') }}"
                                                        style="height:150px;width:150px;object-fit:contain" />
                                                </label>
                                            </td>
                                            <td>
                                                <input type="file" placeholder='Input Someting' class="form-control" required
                                                    name="inp[pr_color_temperature]" id="pr_color_temperature">
                                                <small class="text-danger">
                                                    *Please upload image in .jpg, .png format
                                                </small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="">
                                                <label class="h6 mb-0 text-center">Dimension</label>
                                            </td>
                                            <td align="center">
                                                <label class="h6 mb-0 text-center fw-bolder">
                                                    <img src="{{ asset('/storage/product/DL1-66.dimension.png') }}"
                                                        style="height:150px;width:150px;object-fit:contain" />
                                                </label>
                                            </td>
                                            <td>
                                                <input type="file" placeholder='Input Someting' class="form-control" required
                                                    name="inp[pr_color_temperature]" id="pr_color_temperature">
                                                <small class="text-danger">
                                                    *Please upload image in .jpg, .png format
                                                </small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="">
                                                <label class="h6 mb-0 text-center">Photometric</label>
                                            </td>
                                            <td align="center">
                                                <label class="h6 mb-0 text-center fw-bolder">
                                                    <img src="{{ asset('/storage/product/DL1-66.photometric.png') }}"
                                                        style="height:150px;width:150px;object-fit:contain" />
                                                </label>
                                            </td>
                                            <td>
                                                <input type="file" placeholder='Input Someting' class="form-control" required
                                                    name="inp[pr_color_temperature]" id="pr_color_temperature">
                                                <small class="text-danger">
                                                    *Please upload image in .jpg, .png format
                                                </small>
                                            </td>
                                        </tr>
                                        @foreach ([1, 2, 3] as $field)
                                            <tr>
                                                <td align="">
                                                    <label class="h6 mb-0 text-center">Luminaire type</label>
                                                </td>
                                                <td align="center">
                                                    <label class="h6 mb-0 text-center fw-bolder">SPIKE LIGHT</label>
                                                </td>
                                                <td>
                                                    <input type="text"
                                                        value="{{ $item->product_offered->brand->ms_brand_name }}"
                                                        placeholder='Input Someting' class="form-control" required
                                                        name="inp[pr_color_temperature]" id="pr_color_temperature">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
        <div class="d-flex">
            <button class="btn btn-primary ms-auto"><i class="bx bx-save"></i> Submit Form</button>
        </div>
    </form>
@endsection

@section('js_section')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </script>
@endsection
