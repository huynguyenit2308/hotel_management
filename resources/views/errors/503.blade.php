<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Máy chủ không khả dụng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .error-container {
            min-height: 100vh;
        }

        .icon-large {
            font-size: 64px;
            color: #dc3545;
        }

        .btn-retry {
            padding: 10px 24px;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="container d-flex flex-column justify-content-center align-items-center error-container text-center">
        <div class="icon-large mb-4">⚠️</div>
        <h1 class="mb-3">Máy chủ hiện không khả dụng</h1>
        <p class="text-muted mb-4">Hệ thống đang tạm ngừng hoạt động hoặc XAMPP chưa được bật.<br>Vui lòng kiểm tra lại
            hoặc thử làm mới trang.</p>
        <a href="javascript:location.reload()" class="btn btn-warning btn-retry">Thử lại</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
