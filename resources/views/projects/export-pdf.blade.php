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
    <body style="border:2px solid #DDDDDD">

        {{-- <div class="page_break"></div> --}}


        <img src="{{$main_photo}}" style="height:150px;width:250px;position:absolute;top:140px;left:50px" />
        <img src="{{$dimension_photo}}" style="height:150px;width:250px;position:absolute;top:140px;left:400px" />
        <img src="{{$photometric_photo}}" style="height:150px;width:250px;position:absolute;top:350px;left:400px" />

        {{-- <img src="https://pict.sindonews.net/dyn/850/pena/news/2022/05/15/700/769971/6-serial-anime-yang-produksinya-dibuat-2-studio-berbeda-ayl.jpg" /> --}}

        <div style="padding:.5em 3em;background:#DDDDDD">
            <h2>LIGHTING SPECIFICATION</h2>
        </div>

        <div style="background:#DDDDDD;padding:.5em;position:absolute;top:330px;width:336px">
            <table>
                <tr>
                    <td style=";font-weight:700;width:180px">LUMINAIRE TYPE</td> <td>{{$db->pr_luminaire_type}}</td>
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
                    <td style=";font-weight:700">BRAND</td> <td>{{$db->pr_manufacturer}}</td>
                </tr>
                <tr>
                    <td style=";font-weight:700">DRIVER</td> <td>{{$db->pr_driver}}</td>
                </tr>
                <tr>
                    <td style=";font-weight:700">IP RATING</td> <td>{{$db->pr_ip_rating}}</td>
                </tr>
            </table>
        </div>
        <table style="position:absolute;top:680px;width:100%;left:0">
            <tr style="background:#DDDDDD">
                <td style="font-weight:700;background:#DDDDDD;padding: .5em 1.2em">DESCRIPTION</td>
                <td style="font-weight:700;background:#DDDDDD;padding: .5em 1.2em" colspan="2">ACCESSORIES</td>
            </tr>
            <tr>
                <td style="padding: 0em 1.2em;font-size:9px;height:170px;width:330px;" rowspan="3">
                    With Linear One, we set out to produce a series that works with your vision
                    instead of crowding it. Acclaim Lighting continually strives for simple goals
                    during the design process be useful, stay out of the way, and function
                    wonderfully. Creativity begins with great design and Linear One is
                    streamlined to work for you. We meticulously craft linear lights that install
                    with no visible cables and create the clutter-free space your work deserves.
                    This means that subtlety enhances your aesthetic as Linear One remains
                    hidden while serving as the powerhouse behind your visual creation. Rened
                    to work with your creativity, Linear One provides end-to-end modular
                    functionality that adapts to your needs and never works against them.
                    Acclaim Lighting is motivated by the passion of its users and strives to
                    produce the very best solutions in architectural lighting. We create beautiful
                    products that work for creativity. IK Rating IK10, protection against 5 joule
                    impact 40cm distance. CERTIFICATION INTERTEK, CE.
                    DIMENSION : L305mm x W50mm x H63mm
                </td>
                <td>
                    na
                </td>
            </tr>
            <tr style="background:#DDDDDD">
                <td style="font-weight:700;background:#DDDDDD;" colspan="2">NOTES</td>
            </tr>
            <tr>
                <td>na</td>
            </tr>
            <tr style="background:#DDDDDD">
                <td style="font-weight:700;background:#DDDDDD;padding: .5em 1.2em">SUPPLIER</td>
                <td style="font-weight:700;background:#DDDDDD;padding: .5em 1.2em" colspan="2">UNIT RATE</td>
            </tr>
            <tr style="">
                <td>{{$db->pr_supplier}}</td>
                <td>{{$db->pr_unit_price}}</td>
            </tr>
            <tr style="background:#DDDDDD">
                <td style="font-weight:700;background:#DDDDDD;padding: .5em 1.2em">DATE</td>
                <td style="font-weight:700;background:#DDDDDD;padding: .5em 1.2em">REVISION</td>
                <td style="font-weight:700;background:#DDDDDD;padding: .5em 1.2em">STAGE</td>
            </tr>
            <tr style="">
                <td>- -</td>
                <td>- -</td>
                <td>- -</td>
            </tr>

        </table>
    </body>
</html>
