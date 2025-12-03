<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO(
    "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
    $username,
    $password
);

$country = isset($_GET['country']) ? $_GET['country'] : "";
$lookup = isset($_GET['lookup']) ? $_GET['lookup'] : "";

if ($lookup === "cities") {
    if ($country !== "") {
        $stmt = $conn->prepare("
            SELECT ci.name AS city_name, ci.district, ci.population
            FROM cities ci
            JOIN countries co ON ci.country_code = co.code
            WHERE co.name LIKE :country
        ");
        $stmt->execute(['country' => "%$country%"]);
    } else {
        $stmt = $conn->query("
            SELECT ci.name AS city_name, ci.district, ci.population
            FROM cities ci
            JOIN countries co ON ci.country_code = co.code
        ");
    }

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<table border='1'>
            <tr>
                <th>City Name</th>
                <th>District</th>
                <th>Population</th>
            </tr>";

    foreach ($results as $row) {
        echo "<tr>
                <td>{$row['city_name']}</td>
                <td>{$row['district']}</td>
                <td>{$row['population']}</td>
              </tr>";
    }

    echo "</table>";
    exit;
}

if ($country !== "") {
    $stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%'");
} else {
    $stmt = $conn->query("SELECT * FROM countries");
}

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="1">
    <tr>
        <th>Country Name</th>
        <th>Continent</th>
        <th>Independence Year</th>
        <th>Head of State</th>
    </tr>

    <?php foreach ($results as $row): ?>
        <tr>
            <td><?= $row['name']; ?></td>
            <td><?= $row['continent']; ?></td>
            <td><?= $row['indep_year'] ?? 'N/A'; ?></td>
            <td><?= $row['head_of_state'] ?? 'N/A'; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
