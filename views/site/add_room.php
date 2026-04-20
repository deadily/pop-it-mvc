<?php
$currentPath = $_SERVER['REQUEST_URI'] ?? '/rooms?action=create';
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание помещения</title>
    <link rel="stylesheet" href="assets/style/add_room.css">
</head>

<main>
    <div class="content-container">
        <div class="page-title-box">
            <h1>Создание помещения</h1>
        </div>

        <div class="form-container">
            <form action="<?= app()->route->getUrl('/store_room') ?>" method="POST">
                <input name="csrf_token" type="hidden" value="<?= app()->auth->generateCSRF() ?>"/>
                <div class="form-grid">
                    <label class="form-label">Здание</label>
                    <div class="form-input-wrapper select-wrapper">
                        <select name="building_id" required>
                            <option value="">Выберите здание</option>
                            <?php foreach ($buildings as $building): ?>
                                <option value="<?= $building->id ?>" <?= ($selectedBuildingId == $building->id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($building->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="empty-cell"></div>

                    <label class="form-label">Номер</label>
                    <div class="form-input-wrapper">
                        <input type="text" name="room_number" placeholder="Например: 010" required>
                    </div>
                    <div class="empty-cell"></div>


                    <label class="form-label">Тип</label>
                    <div class="form-input-wrapper select-wrapper">
                        <select name="room_type_id" required>
                            <option value="">Выберите тип</option>
                            <?php foreach ($roomTypes as $type): ?>
                                <option value="<?= $type->id ?>">
                                    <?= htmlspecialchars($type->type_name) ?>
                                    <?= $type->is_educational ? ' (учебное)' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="empty-cell"></div>

                    <label class="form-label">Площадь (м2)</label>
                    <div class="form-input-wrapper">
                        <input type="number" step="0.01" name="area" placeholder="63" required>
                    </div>
                    <div class="empty-cell"></div>

                    <label class="form-label">Кол-во мест</label>
                    <div class="form-input-wrapper">
                        <input type="number" name="seat_total" placeholder="67" required>
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