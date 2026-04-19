<?php
$currentPath = $_SERVER['REQUEST_URI'] ?? '/staff_rooms';

$buildingId = $_GET['building_id'] ?? null;
$buildingName = null;

if ($buildingId && !empty($buildings)) {
    foreach ($buildings as $building) {
        if ((int)$building->id === (int)$buildingId) {
            $buildingName = $building->name ?? 'Здание';
            break;
        }
    }
}

$isBuildingView = !empty($buildingName);
$numDataColumns = $isBuildingView ? 4 : 5; 
$totalColumns = $numDataColumns + 1; 
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $buildingName ? htmlspecialchars($buildingName) : 'Управление помещениями' ?></title>

</head>
<body>



<main>
    <div class="content-container">
        <div class="page-title-box">
            <h1><?= $buildingName ? htmlspecialchars($buildingName) : 'Управление помещениями' ?></h1>
        </div>

        <div class="header-row" style="grid-template-columns: repeat(<?= $numDataColumns ?>, 1fr) 150px;">
            <div class="cell">Номер</div>
            <?php if (!$isBuildingView): ?>
                <div class="cell">Здание</div>
            <?php endif; ?>
            <div class="cell">Тип помещения</div>
            <div class="cell">Площадь</div>
            <div class="cell">Кол-во мест</div>
            <div class="cell summary-create">
                <a class="create-btn" href="<?= app()->route->getUrl('/add_room') ?>?action=create<?= $buildingId ? '&building_id=' . (int)$buildingId : '' ?>">
                    Создать помещение
                </a>
            </div>
        </div>

        <?php if (!empty($rooms)): ?>
            <?php foreach ($rooms as $room): ?>
                <div class="data-row" style="grid-template-columns: repeat(<?= $numDataColumns ?>, 1fr) 150px;">
                    <div class="cell">
                        <?= htmlspecialchars($room->room_number ?? '—') ?>
                    </div>

                    <?php if (!$isBuildingView): ?>
                        <div class="cell">
                            <?php
                            $bName = '—';
                            if (!empty($buildings)) {
                                foreach ($buildings as $building) {
                                    if ((int)$building->id === (int)($room->building_id ?? 0)) {
                                        $bName = $building->name ?? '—';
                                        break;
                                    }
                                }
                            }
                            ?>
                            <?= htmlspecialchars($bName) ?>
                        </div>
                    <?php endif; ?>

                    <div class="cell">
                        <?php
                        $typeName = '—';
                        if (!empty($roomTypes)) {
                            foreach ($roomTypes as $type) {
                                if ((int)$type->id === (int)($room->room_type_id ?? 0)) {
                                    $typeName = $type->type_name ?? '—';
                                    break;
                                }
                            }
                        }
                        ?>
                        <?= htmlspecialchars($typeName) ?>
                    </div>

                    <div class="cell">
                        <?= htmlspecialchars($room->area ?? '—') ?> м2
                    </div>

                    <div class="cell">
                        <?= htmlspecialchars($room->seat_total ?? '—') ?> чел.
                    </div>

                    <div class="cell actions-cell">
                        <form action="<?= app()->route->getUrl('/staff_rooms') ?>" method="POST">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= (int)($room->id ?? 0) ?>">
                            <?php if ($buildingId): ?>
                                <input type="hidden" name="building_id" value="<?= (int)$buildingId ?>">
                            <?php endif; ?>
                            <button type="submit" class="delete-btn">Удалить</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="data-row" style="grid-template-columns: repeat(<?= $totalColumns ?>, 1fr);">
                <div class="cell" style="text-align:center; grid-column: 1 / -1;">Помещений не найдено</div>
            </div>
        <?php endif; ?>

    </div>
</main>

</body>
</html>