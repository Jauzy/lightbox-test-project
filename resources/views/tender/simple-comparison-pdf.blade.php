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
                    <th style="text-align:center">Description</th>
                    @foreach ($project->tenders as $idx_tender => $item)
                        @if($idx_tender > 8)
                        @else
                            <th style="text-align:center">{{$item->psto_company_name}}</th>
                        @endif
                    @endforeach
                </tr>
                @foreach ($project->stage_products as $product)
                    @php
                        $ori_wattage = (float)preg_replace("/[^0-9]/", "", $product->product_offered->pr_light_source);
                        $ori_lumen = (float)preg_replace("/[^0-9]/", "", $product->product_offered->pr_lumen_output);
                        $ori_beam = (float)preg_replace("/[^0-9]/", "", $product->product_offered->pr_optical);
                    @endphp
                    <tr>
                        <td style="background:#CCCCCC;width:50px;text-align:center" class="text-truncate">{{$product->product_offered->pr_code}}</td>
                        <td style="text-align: center;width:180px">
                            <div style="font-weight:bolder">{{$product->product_offered->lumtype->ms_lum_types_name}}</div>
                            <div>Wattage : {{$product->product_offered->pr_light_source}}</div>
                            <div>Lumen : {{$product->product_offered->pr_lumen_output}}</div>
                            <div>Col. Temp : {{$product->product_offered->pr_color_temperature}}</div>
                            <div>Beam : {{$product->product_offered->pr_optical}}</div>
                            <div>CRI : {{$product->product_offered->pr_color_rendering}}</div>
                            <div>IPR : {{$product->product_offered->pr_ip_rating}}</div>
                            <div>Driver : {{$product->product_offered->pr_driver}}</div>
                        </td>
                        @foreach ($project->tenders as $idx_tender => $tender)
                            @if($idx_tender > 8)
                            @else
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
                            @endif
                        @endforeach
                    </tr>
                @endforeach
        </table>
        @endforeach
    </body>
</html>
