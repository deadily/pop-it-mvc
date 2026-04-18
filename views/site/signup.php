<?php
$currentPath = $_SERVER['REQUEST_URI'] ?? '';
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление сотрудниками</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #fff;
        }

        aside {
            width: 320px;
            background-color: #D9D9D9;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100vh;
        }

        .logo {
            padding: 50px 40px;
            font-size: 32px;
            line-height: 1.1;
            font-weight: 500;
        }

        nav {
            flex-grow: 1;
            margin-top: 20px;
        }

        nav a {
            display: block;
            padding: 15px 40px;
            text-decoration: none;
            color: #000;
            font-size: 18px;
            transition: background 0.2s;
        }

        nav a:hover {
            background-color: #cecece;
        }

        nav a.active {
            background-color: #BFBFBF;
        }

        .sidebar-footer {
            padding: 20px 0;
        }

        .user-info {
            padding: 0 40px 15px 40px;
            font-size: 14px;
            color: #333;
        }

        .logout-link {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            text-decoration: none;
            color: #000;
            border-top: 1px solid #BDBDBD;
            font-size: 16px;
        }

        main {
            flex-grow: 1;
            padding: 60px;
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
        }

        .content-container {
            width: 100%;
            max-width: 1120px;
        }

        .page-title-box {
            background-color: #D9D9D9;
            padding: 25px;
            text-align: center;
            margin-bottom: 25px;
        }

        .page-title-box h1 {
            font-size: 32px;
            font-weight: normal;
        }

        .table-row {
            display: grid;
            grid-template-columns: 3.2fr 1.8fr 1.8fr 220px; /* ФИО | Логин | Роль | Действия */
            align-items: center;
            column-gap: 0;
        }

        .header-row {
            background-color: #D9D9D9;
            padding: 12px 0;
            margin-bottom: 12px;
        }

        .user-row {
            background-color: #E6E6E6;
            padding: 18px 0;
            margin-bottom: 12px;
        }

        .cell {
            display: flex;
            justify-content: center;
            padding: 0 18px;
            font-size: 16px;
            color: #000;
        }

        .cell.fio {
            justify-content: flex-start;
            padding-left: 40px;
        }

        .header-row .cell {
            font-weight: 400;
            color: #000;
        }

        .action-box {
            justify-content: center;
        }

        .create-btn {
            text-decoration: none;
            color: #000;
            font-size: 16px;
            background-color: #D9D9D9;
            width: 100%;
            text-align: center;
            display: inline-block;
            padding: 12px 0;
        }

        .delete-btn {
            background-color: #8E8E8E;
            color: #000;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 10px 0;
            width: 150px;
            transition: background 0.2s;
        }

        .delete-btn:hover {
            background-color: #7a7a7a;
        }

        form { margin: 0; }
    </style>
</head>

<body>
<aside>
    <div>
        <div class="logo">
            Учебно-<br>методическое<br>управление
        </div>

        <nav>
            <a href="<?= app()->route->getUrl('/hello') ?>"
               class="<?= ($currentPath == '/hello' || $currentPath == '/') ? 'active' : '' ?>">
                Главная
            </a>

            <?php if (!app()->auth::check()): ?>
                <a href="<?= app()->route->getUrl('/login') ?>"
                   class="<?= ($currentPath == '/login') ? 'active' : '' ?>">
                    Вход
                </a>
            <?php endif; ?>

            <?php if (app()->auth::check() && app()->auth::user()->isAdmin()): ?>
                <a href="<?= app()->route->getUrl('/signup') ?>"
                   class="<?= ($currentPath == '/signup') ? 'active' : '' ?>">
                    Управление пользователями
                </a>
            <?php endif; ?>
        </nav>
    </div>

    <div class="sidebar-footer">
        <?php if (app()->auth::check()): ?>
            <div class="user-info">
                <div><?= htmlspecialchars(app()->auth::user()->login ?? 'login') ?></div>
                <div style="opacity: 0.6;">
                    <?= app()->auth::user()->isAdmin() ? 'Администратор' : 'Пользователь' ?>
                </div>
            </div>

            <a href="<?= app()->route->getUrl('/logout') ?>" class="logout-link">
                <span>Выйти</span>
                <span>&rarr;</span>
            </a>
        <?php endif; ?>
    </div>
</aside>

<main>
    <div class="content-container">
        <div class="page-title-box">
            <h1>Управление сотрудниками</h1>
            <div style="text-align: center;">
        </div>

        <div class="description-text" style="max-width: 700px; margin: 0 auto; color: #000;">
            <p style="margin-bottom: 10px;">Ваши возможности:</p>
            
            <p style="margin-bottom: 20px;">
                Управление доступом: Создавайте учетные записи для новых сотрудников деканата. 
                Назначайте логины и пароли, обеспечивая безопасный доступ к системе только авторизованным пользователям.
            </p>
        </div>
        </div>

        <div class="table-row header-row">
            <div class="cell fio">ФИО</div>
            <div class="cell">Логин</div>
            <div class="cell">Роль</div>
            <div class="cell action-box">
                <a class="create-btn" href="<?= app()->route->getUrl('/signup') ?>">Создать сотрудника</a>
            </div>
        </div>

        <?php foreach ($users as $user): ?>
            <div class="table-row user-row">
                <div class="cell fio"><?= htmlspecialchars($user->name ?: '—') ?></div>
                <div class="cell"><?= htmlspecialchars($user->login) ?></div>
                <div class="cell">
                    <?= $user->isAdmin() ? 'Администратор' : 'Сотрудник' ?>
                </div>

                <div class="cell action-box">
                    <form action="<?= app()->route->getUrl('/delete-user') ?>" method="POST">
                        <input type="hidden" name="id" value="<?= $user->id ?>">
                        <button type="submit" class="delete-btn">Удалить</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
</body>
</html>