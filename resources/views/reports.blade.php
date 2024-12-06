<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        /* Styles for the footer */
        @page {
           
        }

        html * {
            font-family:Arial, Helvetica, sans-serif;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9px;
        }

      

        table,
        td,
        th {
            border: .5px solid black;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            padding: 3px;
            vertical-align: top;
        }
        td {
            padding: 3px;
            /* vertical-align: top; */
            /* text-align: center; */
        }
        label {
            display: block;
            padding-left: 15px;
            text-indent: -15px;
        }
        label {
            display: inline-block;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    
    <div class="content">
        <div style="font-family:Arial;">
        
            <center style="font-size: 10px; background-color: black; color:#fff; font-weight: bold; padding: 5px;">LIST OF OR FOR {{$year}}</center>
        </div>

        <table style="border: 1px solid black; font-size: 10px;">
            <thead style="background-color:#c8c8c8; padding: 5px; font-size: 9px;">
                <tr>    
                    <th style="vertical-align: middle;" width="8%">Code</th>
                    <th style="vertical-align: middle;" width="11%">Client</th>
                    <th style="vertical-align: middle;" width="40%">Service</th>
                    <th style="vertical-align: middle;" width="5%">Rating</th>
                    <th style="vertical-align: middle;" width="8%">Status</th>
                    <th style="vertical-align: middle;" width="8%">Total</th>
                </tr>
            </thead>
            <tbody>
            @foreach($lists as $index=>$list)
                <tr style="text-align: center; font-size: 9px; color: #072388;">
                    <td>{{$list['appointment']['code']}}</td>
                    <td>
                        {{$list['appointment']['user']['profile']['firstname']}} {{$list['appointment']['user']['profile']['lastname']}}
                    </td>
                    <td>{{$list['service']['service']}} </td>
                    <td>{{($list['rating']) ? $list['rating'] : '-'}}</td>
                    <td>{{$list['status']['name']}}</td>
                    <td><span style="font-family: DejaVu Sans;">&#8369;</span>{{number_format(trim(str_replace(',','',$list['price']),'₱ '),2,".",",")}}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                @php
                    $totalAmount = 0;

                    foreach ($lists as $list) {
                        $total = str_replace(['₱ ', '₱', ',', ' '], '', $list['price']);
                        $totalAmount += floatval($total);
                    }
                @endphp
                <tr style="font-weight: bold; text-align: center;">
                    <td colspan="5"></td>
                    <td><span style="font-family: DejaVu Sans;">&#8369;</span>{{ number_format($totalAmount, 2, ".", ",") }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>
</html>