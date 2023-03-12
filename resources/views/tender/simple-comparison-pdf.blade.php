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
                    @foreach ($project->tenders as $item)
                        <th style="text-align:center">{{$item->psto_company_name}}</th>
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
                        <td style="text-align: center;width:300px">
                            <div style="font-weight:bolder">{{$product->product_offered->lumtype->ms_lum_types_name}}</div>
                            <div>Wattage : {{$product->product_offered->pr_light_source}}</div>
                            <div>Lumen : {{$product->product_offered->pr_lumen_output}}</div>
                            <div>Col. Temp : {{$product->product_offered->pr_color_temperature}}</div>
                            <div>Beam : {{$product->product_offered->pr_optical}}</div>
                            <div>CRI : {{$product->product_offered->pr_color_rendering}}</div>
                            <div>IPR : {{$product->product_offered->pr_ip_rating}}</div>
                            <div>Driver : {{$product->product_offered->pr_driver}}</div>
                        </td>
                        @foreach ($project->tenders as $tender)
                            <td style="text-align:center">
                                @if($tender->tender_product->psto_supplied_as == 'as-specified')
                                    <div style="color:#29C66F">
                                        AS SPECIFIED
                                    </div>
                                @else
                                    @php
                                        $valid = true;
                                        $not_valid_reason = [];
                                        $wattage = (float)preg_replace("/[^0-9]/", "", $tender->tender_product->pr_light_source);
                                        $lumen = (float)preg_replace("/[^0-9]/", "", $tender->tender_product->pr_lumen_output);
                                        $beam = (float)preg_replace("/[^0-9]/", "", $tender->tender_product->pr_optical);

                                        $accepted_gap_wattage = $ori_wattage * 0.1;
                                        $diff_wattage = abs($wattage - $ori_wattage);
                                        if($diff_wattage > $accepted_gap_wattage){
                                            $valid = false;
                                            $not_valid_reason[] = 'Wattage';
                                        }

                                        $accepted_gap_lumen = $ori_lumen * 0.1;
                                        $diff_lumen = abs($lumen - $ori_lumen);
                                        if($diff_lumen > $accepted_gap_lumen){
                                            $valid = false;
                                            $not_valid_reason[] = 'Lumen';
                                        }

                                        $accepted_gap_beam = $ori_beam * 0.15;
                                        $diff_beam = abs($beam - $ori_beam);
                                        if($diff_beam > $accepted_gap_beam){
                                            $valid = false;
                                            $not_valid_reason[] = 'Beam';
                                        }

                                        if($product->product_offered->pr_color_temperature != $tender->tender_product->pr_color_temperature){
                                            $valid = false;
                                            $not_valid_reason[] = 'Color Temp';
                                        }

                                        if($product->product_offered->pr_color_rendering != $tender->tender_product->pr_color_rendering){
                                            $valid = false;
                                            $not_valid_reason[] = 'CRI';
                                        }

                                        if($product->product_offered->pr_ip_rating != $tender->tender_product->pr_ip_rating){
                                            $valid = false;
                                            $not_valid_reason[] = 'IPR';
                                        }

                                        if($product->product_offered->pr_driver != $tender->tender_product->pr_driver){
                                            $valid = false;
                                            $not_valid_reason[] = 'Driver';
                                        }

                                    @endphp
                                    @if($valid)
                                        <div style="color:#2A4C6B">
                                            COMPLY
                                        </div>
                                    @else
                                        <div style="color:red">
                                            NOT COMPLY
                                        </div>
                                        <div style="color:red">(
                                            {{join(",", $not_valid_reason)}}
                                            )
                                        </div>
                                    @endif
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
        </table>
        @endforeach
    </body>
</html>
