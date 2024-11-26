<!DOCTYPE html>
<html lang="et">

<head>
    <meta charset="UTF-8">
    <meta nimi="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tallinna Maraton Andmed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Tallinna Maraton Andmed</h1>
        <p class="text-center">Allpool kuvatakse SQL-päringute tulemused, mis analüüsivad Tallinna Maratoni osalejate infot.</p>

        <?php
        include('config.php');

        if ($conn->connect_error) {
            die("Ühendus ebaõnnestus: " . $conn->connect_error);
       }

        // päring 1: kuvab esimesed 10 osalejat
        echo "<h3>1. Esimesed 10 osalejat (ID, nimi, riik):</h3>";
        $query1 = "SELECT id, nimi, riik FROM tallinn_marathon LIMIT 10";
        $result1 = $conn->query($query1);

        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>ID</th><th>Nimi</th><th>Riik</th></tr></thead>";
        echo "<tbody>";
        while ($row = $result1->fetch_assoc()) {
            echo "<tr><td>{$row['id']}</td><td>{$row['nimi']}</td><td>{$row['riik']}</td></tr>";
        }
        echo "</tbody></table>";

        // päring 2: Soome osalejad, registreeritud pärast 1. märtsi 2024
        echo "<h3>2. Soome osalejad, kes registreerusid pärast 1. märtsi 2024:</h3>";
        $query2 = "SELECT nimi, finish FROM tallinn_marathon WHERE riik = 'Finland' AND registreerimine > '2024-03-01' ORDER BY finish";
        $result2 = $conn->query($query2);

        echo "<table class='table table-bordered'>";
        echo "<thead><tr><th>Nimi</th><th>Finišiaeg</th></tr></thead>";
        echo "<tbody>";
        while ($row = $result2->fetch_assoc()) {
            echo "<tr><td>{$row['nimi']}</td><td>{$row['finish']}</td></tr>";
        }
        echo "</tbody></table>";

        // päring 3: osalejate arv vanusegrupis 18-30
        echo "<h3>3. Osalejate arv vanusegrupis 18-30:</h3>";
        $query3 = "SELECT COUNT(*) AS count FROM tallinn_marathon WHERE vanus = '18-30'";
        $result3 = $conn->query($query3);
        $count = $result3->fetch_assoc()['count'];

        echo "<p>Vanusegrupis 18-30 on kokku: <strong>{$count}</strong> osalejat.</p>";

        // päring 4: juhuslikud naisosalejad
        echo "<h3>4. 3 juhuslikku naisosalejat, kes lõpetasid maratoni:</h3>";
        $query4 = "SELECT nimi FROM tallinn_marathon WHERE sugu = 'Female' AND finish IS NOT NULL ORDER BY RAND() LIMIT 3";
        $result4 = $conn->query($query4);

        echo "<ul>";
        while ($row = $result4->fetch_assoc()) {
            echo "<li>{$row['nimi']}</li>";
        }
        echo "</ul>";

        // sulgeb ühendused
        $conn->close();
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
