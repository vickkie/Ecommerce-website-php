

<?php
include('config.php');



if (isset($_GET['search'])) {
    $search = $_GET['search'];

    $sql = "SELECT username FROM users WHERE username LIKE :search";
    $query = $dbh->prepare($sql);
    $query->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_COLUMN);

    foreach ($results as $result) {
        echo "<p onclick='selectUsername(\"$result\")'>" . htmlentities($result) . "</p>";
    }
}

?>
