<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <style>
        .container {
            padding: 20px;
        }
        .info {
            padding: 0 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Cảm ơn bạn đã sử dụng dịch vụ của Gemifx</p>
        <p>Mã otp của bạn là: <span>{{$otp}}</span></p>
        <p>Trân trọng,</p>
        <p>Đội ngũ GemiFx</p>
        <br>
        <b>Điện thoại: 1-800-123-4567 </b>
        <br>
        <b>Email: support@gemifx.com</b>
    </div>
</body>
</html>
