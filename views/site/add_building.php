<?php
$currentPath = $_SERVER['REQUEST_URI'] ?? '/buildings?action=create';
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание помещения</title>
    <link rel="stylesheet" href="assets/style/add_building.css">
</head>

<body>

<main>
    <div class="content-container">
        <div class="page-title-box">
            <h1>Создание здания</h1>
        </div>

        <div class="form-container">
            <form action="<?= app()->route->getUrl('/store_building') ?>" method="POST">
                <div class="form-grid">
                    <label class="form-label">Название</label>
                    <div class="form-input-wrapper">
                        <input type="text" name="name" placeholder="Например: Корпус А" required>
                    </div>
                    <div class="empty-cell"></div>

                    <label class="form-label">Адрес</label>
                    <div class="form-input-wrapper">
                        <input type="text" name="address" placeholder="Район X, улица Y, дом 5" required>
                    </div>
                    <div class="button-wrapper">
                        <button type="submit" class="confirm-btn">Подтвердить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

</body>
</html>