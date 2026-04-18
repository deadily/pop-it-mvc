<?php

$currentPath = $_SERVER['REQUEST_URI'] ?? '';

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление зданиями</title>

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

        nav a:hover { background-color: #cecece; }
        nav a.active { background-color: #BFBFBF; }

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
            font-size: 40px;
            font-weight: normal;
        }

        .table-grid,
        .header-row,
        .data-row {
            display: grid;
            grid-template-columns: 3fr 3fr 2fr 380px;
            column-gap: 0;
            align-items: center;
        }


        .summary-grid {
            display: grid;
            grid-template-columns: 3fr 3fr 2fr 380px;
            column-gap: 0;
            margin-bottom: 20px;
        }

        .summary-box {
            background-color: #D9D9D9;
            padding: 14px 0;
            text-align: center;
            font-size: 18px;
            color: #000;
        }

        .summary-area { grid-column: 1 / 3; }
        .summary-seats { grid-column: 3 / 4; }
        .summary-create { grid-column: 4 / 5; }

        .create-btn {
            display: block;
            width: 100%;
            height: 100%;
            text-decoration: none;
            color: #000;
            background-color: #D9D9D9;
            font-size: 18px;
            padding: 14px 0;
            text-align: center;
        }

        .header-row {
            background-color: #D9D9D9;
            padding: 12px 0;
            margin-bottom: 10px;
        }

        .cell {
            padding: 0 18px;
            font-size: 18px;
            color: #000;
            display: flex;
            justify-content: center;
        }

        .cell.fio { justify-content: flex-start; }

        .header-row .cell {
            font-weight: 400;
        }


        .data-row {
            background-color: #E6E6E6;
            margin-bottom: 22px;
            padding: 18px 0;
        }

        .data-row .cell {
            font-weight: 500;
        }

        .name-cell,
        .addr-cell,
        .area-cell {
            justify-content: center;
        }

        .actions-cell {
            justify-content: flex-end;
            padding-right: 20px;
        }

        .actions-inner {
            display: flex;
            gap: 18px;
            align-items: center;
        }

        .action-btn,
        .delete-btn {
            border: none;
            cursor: pointer;
            background-color: #8E8E8E;
            color: #000;
            font-size: 18px;
            padding: 12px 0;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .action-btn {
            width: 260px;
        }

        .delete-btn {
            width: 120px;
        }

        .delete-btn:hover,
        .action-btn:hover {
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

            <?php if (!app()->auth::check()): ?>
                <a href="<?= app()->route->getUrl('/login') ?>"
                   class="<?= ($currentPath === '/login') ? 'active' : '' ?>">
                    Вход
                </a>
            <?php endif; ?>

            <?php if (app()->auth::check() && !app()->auth::user()->isAdmin()): ?>
                <a href="<?= app()->route->getUrl('/staff_buildings') ?>"
                   class="<?= ($currentPath === '/staff_buildings') ? 'active' : '' ?>">
                    Здания
                </a>

                <a href="<?= app()->route->getUrl('/staff_rooms') ?>"
                   class="<?= ($currentPath === '/staff_rooms') ? 'active' : '' ?>">
                    Помещения
                </a>
            <?php endif; ?>

            <?php if (app()->auth::check() && app()->auth::user()->isAdmin()): ?>
                <a href="<?= app()->route->getUrl('/admin_main') ?>"
                   class="<?= ($currentPath === '/admin_main') ? 'active' : '' ?>">
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
                    <?= app()->auth::user()->isAdmin() ? 'admin' : 'staff' ?>
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
            <h1>Управление зданиями</h1>
        </div>

        <div class="summary-grid">
            <div class="summary-box summary-area">
                Общая площадь: <?= (int)$totalArea ?> м2
            </div>

            <div class="summary-box summary-seats">
                Общее кол-во посадочных мест: <?= (int)$totalSeats ?>
            </div>

            <div class="summary-box summary-create">
                <a class="create-btn" href="<?= app()->route->getUrl('/buildings') ?>?action=create">
                    Создать здание
                </a>
            </div>
        </div>

        <div class="header-row">
            <div class="cell">Название здания</div>
            <div class="cell">Адрес здания</div>
            <div class="cell">Площадь здания</div>
            <div class="cell" style="justify-content:flex-end; padding-right:20px;"></div>
        </div>

        <?php foreach ($buildings as $building): ?>
            <div class="data-row">
                <div class="cell name-cell">
                    <?= htmlspecialchars($building->name ?? '—') ?>
                </div>

                <div class="cell addr-cell">
                    <?= htmlspecialchars($building->address ?? '—') ?>
                </div>

                <div class="cell actions-cell">
                    <div class="actions-inner">
                        <a class="action-btn"
                           href="<?= app()->route->getUrl('staff_rooms') ?>?building_id=<?= (int)($building->id ?? 0) ?>">
                            Посмотреть помещения
                        </a>

                        <form action="<?= app()->route->getUrl('/staff_buildings') ?>" method="POST">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= (int)($building->id ?? 0) ?>">
                            <button type="submit" class="delete-btn" type="submit">Удалить</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</main>
</body>
</html>