<?php
$message = $_SESSION['message'] ?? '';
if ($message) unset($_SESSION['message']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация | Учебно-методическое управление</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
        }

        body {
            background-color: #ededed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #000;
        }

        .page-title {
            font-size: 24px;
            font-weight: 400;
            margin-bottom: 40px;
            text-align: center;
        }

        .login-card {
            background-color: #ffffff;
            width: 100%;
            max-width: 400px;
            padding: 60px 45px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .login-card h2 {
            font-size: 18px;
            font-weight: 400;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 16px;
            border: none;
            background-color: #f0f0f0;
            font-size: 16px;
            outline: none;
        }

        input::placeholder {
            color: #a0a0a0;
        }

        .btn-submit {
            display: inline-block;
            width: 180px;
            margin-top: 20px;
            padding: 12px;
            border: none;
            background-color: #f0f0f0;
            font-size: 16px;
            cursor: pointer;
            color: #000;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background-color: #e5e5e5;
        }
    </style>
</head>
<body>

<div class="page-title">Учебно-методическое управление</div>

<div class="login-card">
    <h2>Авторизация</h2>

    <form method="POST" action="<?= app()->route->getUrl('/login') ?>">
        <div class="form-group">
            <input type="text" name="login" placeholder="Логин" required>
        </div>

        <div class="form-group">
            <input type="password" name="password" placeholder="Пароль" required>
        </div>

        <button type="submit" class="btn-submit">Войти</button>
    </form>
</div>

</body>
</html>