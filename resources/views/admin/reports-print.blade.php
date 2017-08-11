<html>
<head>
    <title></title>
    <style type="text/css">
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
<p dir="rtl" style="text-align: center;"><img alt="" src="{{ asset('img/logo-small.png') }}" /></p>
<p dir="rtl" style="text-align: center;">تعداد شاغلین از شهرهای مختلف به تفکیک محل سکونت</p>
<table align="center" style="width:80%; direction: rtl; text-align: center;">
    <tbody>
        <tr>
            @foreach($results['headers'] as $header)
                <th>{{$header}}</th>
            @endforeach
        </tr>
        @foreach($results['data'] as $row)
            <tr>
                @foreach($row as $item)
                    <td>{{$item}}</td>
                @endforeach
            </tr>    
        @endforeach
    </tbody>
</table>
<p dir="rtl" style="text-align: right;"><span style="font-size:11px;">نسخه چاپی</span></p>
<p>&nbsp;</p>
</body>
</html>
