<?php
session_start();
require 'sensor.php';


if (isset($_POST['sensor_id'])) {
    $result = sensor_insert(
        $_POST['sensor_id'],
        $_POST['sensor_type'],
        $_POST['value'],
        $_POST['unit']
    );
    echo "<p style='color:green'>Данные сохранены! Ответ: $result</p>";
}


$latest = sensor_latest(10);
?>

<h2>Последние показания сенсоров</h2>

<?php if (!empty($latest['data'])): ?>
    <table border="1">
        <tr>
            <th>Время</th>
            <th>ID сенсора</th>
            <th>Тип</th>
            <th>Значение</th>
            <th>Ед.</th>
        </tr>
        <?php foreach ($latest['data'] as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row[0]) ?></td>
            <td><?= htmlspecialchars($row[1]) ?></td>
            <td><?= htmlspecialchars($row[2]) ?></td>
            <td><?= htmlspecialchars($row[3]) ?></td>
            <td><?= htmlspecialchars($row[4]) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Пока нет данных. Добавьте первый сенсор!</p>
<?php endif; ?>

<h3>Добавить новые показания</h3>
<form method="POST">
    <input type="number" name="sensor_id" placeholder="ID сенсора" required><br>
    <select name="sensor_type">
        <option value="temperature">Температура</option>
        <option value="humidity">Влажность</option>
        <option value="pressure">Давление</option>
    </select><br>
    <input type="number" step="0.01" name="value" placeholder="Значение" required><br>
    <input type="text" name="unit" placeholder="Единица" value="°C"><br>
    <button type="submit">Сохранить</button>
</form>

<h3>Средняя температура за 5 минут</h3>
<?php
$avg = sensor_avg('temperature', 5);
echo "<p>$avg °C</p>";
?>