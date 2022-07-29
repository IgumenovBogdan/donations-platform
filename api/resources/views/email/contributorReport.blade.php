<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TestMail</title>
</head>
<body>
@component('mail::message')
<table cellspacing="2" border="1" cellpadding="5">
    <tr>
        <th>Организация</th>
        <th>Цель для сбора</th>
        <th>Всего отправлено</th>
        <th>Статус</th>
    </tr>
    @foreach($report as $item)
        <tr>
            <td style="text-align: center;vertical-align: middle;">{{$item['organization']}}</td>
            <td style="text-align: center;vertical-align: middle;">{{$item['lot']}}</td>
            <td style="text-align: center;vertical-align: middle;">{{$item['total_sent']}}</td>
            <td style="text-align: center;vertical-align: middle;">{{$item['status']}}</td>
        </tr>
    @endforeach
</table>
@endcomponent
</body>
</html>
