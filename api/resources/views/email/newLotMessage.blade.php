<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Renew success</title>
</head>
<body>
@component('mail::message')
    <table cellspacing="2" border="1" cellpadding="5">
        <div>
            <h2>One of the organization has created a new lot</h2>
            <p>Good afternoon! The <b>{{$lot->organization->name}}</b> organization has created a new lot:</p>
            <p><b>{{$lot->name}}</b></p>
            <p>{{$lot->description}}</p>
        </div>
    </table>
@endcomponent
</body>
</html>
