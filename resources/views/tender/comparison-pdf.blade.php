<!DOCTYPE html>
<html>
    <head>
        <title>Export PDF</title>
        <style>
            .page_break { page-break-before: always; }
            td {
                font-size: 12px;
                padding: .5em
            }
            :root {
                font-family: Arial, Helvetica, sans-serif
            }
            .bg-secondary {
                background: #82868B;
                border-radius: 5px
            }
            .bg-muted {

            }
            .text-center {
                text-align: center
            }
            .text-white {
                color: white
            }
            .text-truncate {
                /* white-space: nowrap; */
            }
            .table-dark {
                background: #4B4B4B;
                color: white;
            }
            table {
                font-size: 13px;
                text-align: start
            }
            table td, table th {
                padding: .5em;
                border-radius: 5px
            }
        </style>
    </head>
    <body style="">
        @foreach ($project->stage_products as $idx => $product)
        @if($idx != 0)
        <div class="page_break"></div>
        @endif
        <table style="width:100%">
            <tr>
                <td style="width:100px">
                    <img src="lightbox.png" style="width:100px" />
                </td>
                <td style="width:300px;font-weight:bolder">
                    <span>
                        DAMANSARA HEIGHTS OFFICE PUBLIC AREA
                    </span>
                    <span style="color:red">
                        TENDERER COMPLIANCE TABLE 01
                    </span>
                </td>
                <td align="right" style="color:red;font-weight:bolder;font-size:18px">
                    06.02.2022
                </td>
            </tr>
        </table>
        <table style="border:1px solid #4B4B4B;border-radius:5px;width:100%">
                <tr class="table-dark">
                    <th>SPEC</th>
                    <th colspan="2">Original</th>
                    @foreach ($project->tenders as $item)
                        <th>{{$item->psto_company_name}}</th>
                    @endforeach
                </tr>
                @foreach ($comparison_table as $key => $label)
                    <tr>
                        @if ($key == 'ms_lum_types_name')
                        <td rowspan="15" style="background:#CCCCCC;width:50px;text-align:center" class="text-truncate">{{$product->product_offered->pr_code}}</td>
                        @endif
                        <td style="width:150px" class="text-white bg-secondary text-truncate">{{$label}}</td>
                        @if ($key == 'ms_lum_types_name')
                        <td class="text-truncate">{{$product->product_offered->lumtype[$key] ?? '-'}}</td>
                        @elseif ($key == 'ms_brand_name')
                        <td class="text-truncate">{{$product->product_offered->brand[$key] ?? '-'}}</td>
                        @elseif ($key == 'pr_main_photo' || $key == 'pr_dimension_photo' || $key == 'pr_photometric_photo')
                        <td>
                            @if($product->product_offered[$key])
                            @php
                                $db = $product->product_offered;
                                $url = storage_path('app\\'.$db[$key]);
                            @endphp
                            <img src="{{$url}}" style="height:70px;border-radius:5px" />
                            @else
                            -
                            @endif
                        </td>
                        @else
                        <td class="text-truncate">{{$product->product_offered[$key] ?? '-'}}</td>
                        @endif
                        @foreach ($project->tenders as $tender)
                        @if ($key == 'pr_main_photo' || $key == 'pr_dimension_photo' || $key == 'pr_photometric_photo')
                            <td>
                                @if($companies_product[$product->product_offered->pr_code][$tender->pst_id][$key])
                                @php
                                    $url = storage_path('app\\'.$companies_product[$product->product_offered->pr_code][$tender->pst_id][$key]);
                                @endphp
                                <img src="{{$url}}" style="height:70px;border-radius:5px" />
                                @else
                                -
                                @endif
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
        </table>
        @endforeach
    </body>
</html>
