<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truy cập không hợp lệ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .error-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .error-box {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 40px 30px;
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .icon-large {
            font-size: 72px;
            color: #dc3545;
            animation: pulse 1.2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .btn-back {
            padding: 12px 28px;
            font-size: 16px;
            border-radius: 30px;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-box">
            <div class="icon-large mb-4">⛔</div>
            <h2 class="mb-3 text-danger">Không thể truy cập chức năng này</h2>
            <p class="text-muted mb-4">
                Bạn không thể thực hiện thao tác xoá bằng cách dán URL trên trình duyệt.<br>
                Vui lòng sử dụng chức năng hợp lệ trong hệ thống.
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php /**PATH D:\BE2\hotel_management\resources\views/errors/invalid.blade.php ENDPATH**/ ?>