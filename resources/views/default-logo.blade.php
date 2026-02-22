<!DOCTYPE html>
<html>
<head>
    <style>
        .default-logo {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 48px;
            font-weight: bold;
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="default-logo">
        {{ $initials }}
    </div>
</body>
</html>
