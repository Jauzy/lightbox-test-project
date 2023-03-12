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
        </style>
    </head>
    <body style="">


        @foreach ($products as $idx => $db)
            @if($idx != 0)
            <div class="page_break"></div>
            @endif
            @php
                $db = $db->product_offered;
                $main_photo = storage_path('app\\'.$db->pr_main_photo);
                $dimension_photo = storage_path('app\\'.$db->pr_dimension_photo);
                $photometric_photo = storage_path('app\\'.$db->pr_photometric_photo);
            @endphp

            <img src="{{$main_photo}}" style="height:150px;width:200px;position:absolute;top:140px;left:470px;object-fit:cover" />
            <img src="{{$dimension_photo}}" style="height:150px;width:200px;position:absolute;top:340px;left:470px;object-fit:cover" />
            <img src="{{$photometric_photo}}" style="height:150px;width:200px;position:absolute;top:550px;left:470px;object-fit:cover" />

            {{-- <img src="https://pict.sindonews.net/dyn/850/pena/news/2022/05/15/700/769971/6-serial-anime-yang-produksinya-dibuat-2-studio-berbeda-ayl.jpg" /> --}}

            <div style="padding:.25em 3em;background:#DDDDDD">
                <table style="width:100%">
                    <tr>
                        <td>
                            <h2 style="max-width:100px">{{$db->pr_code}}</h2>
                        </td>
                        <td align="center">
                            <h2>{{$data->prj_name}}<br/> {{$data->prj_location}}</h2>
                        </td>
                        <td align="right">
                            <img src="lightbox.png" style="width:100px" />
                        </td>
                    </tr>
                </table>
            </div>

            <div style="background:#DDDDDD;padding:.5em;position:absolute;top:130px;width:400px">
                <table>
                    <tr>
                        <td style=";font-weight:700;width:150px">DATE</td> <td>{{$data->prj_last_upd}}</td>
                    </tr>
                    <tr>
                        <td style=";font-weight:700;">LUMINAIRE TYPE</td> <td>{{$db->lumtype->ms_lum_types_name}}</td>
                    </tr>
                    <tr>
                        <td style=";font-weight:700">LAMP TYPE</td> <td>{{$db->pr_lamp_type}}</td>
                    </tr>
                    <tr>
                        <td style=";font-weight:700">WATTAGE</td> <td>{{$db->pr_light_source}}</td>
                    </tr>
                    <tr>
                        <td style=";font-weight:700">LUMEN OUTPUT</td> <td>{{$db->pr_lumen_output}}</td>
                    </tr>
                    <tr>
                        <td style=";font-weight:700">BEAM ANGLE</td> <td>-</td>
                    </tr>
                    <tr>
                        <td style=";font-weight:700">COLOR TEMPERATURE</td> <td>{{$db->pr_color_temperature}}</td>
                    </tr>
                    <tr>
                        <td style=";font-weight:700">FINISHES</td> <td>{{$db->pr_finishing}}</td>
                    </tr>
                    <tr>
                        <td style=";font-weight:700">CRI</td> <td>{{$db->pr_color_rendering}}</td>
                    </tr>
                    <tr>
                        <td style=";font-weight:700">MODEL</td> <td>{{$db->pr_model}}</td>
                    </tr>
                    <tr>
                        <td style=";font-weight:700">BRAND</td> <td>{{$db->brand->ms_brand_name}}</td>
                    </tr>
                    <tr>
                        <td style=";font-weight:700">DRIVER</td> <td>{{$db->pr_driver}}</td>
                    </tr>
                    <tr>
                        <td style=";font-weight:700">IP</td> <td>{{$db->pr_ip_rating}}</td>
                    </tr>
                    <tr>
                        <td style=";font-weight:700">STAGE</td> <td>{{$project->stage->stage_name}}</td>
                    </tr>
                    <tr>
                        <td style=";font-weight:700">DESCRIPTION</td> <td>{{$db->pr_content}}</td>
                    </tr>
                    <tr>
                        <td style=";font-weight:700">ACCESSORIES</td> <td>{{$db->pspo_accessories}}</td>
                    </tr>
                    <tr>
                        <td style=";font-weight:700">NOTES</td> <td>{{$db->pspo_notes}}</td>
                    </tr>
                </table>
            </div>
        @endforeach

    </body>
</html>
