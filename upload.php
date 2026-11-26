<?php
require 'config.php';

$formats = ['pdf', 'jpg', 'jpeg', 'png', 'txt', 'docx'];
$tailleMax = 2 * 1024 * 1024;
$dossier = __DIR__ . '/uploads/';

$erreur = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['fichier'])) {
    $erreur = "Aucun fichier envoyé.";
} elseif ($_FILES['fichier']['error'] !== UPLOAD_ERR_OK) {
    $erreur = "Erreur pendant l'envoi du fichier.";
} else {
    $nomOriginal = basename($_FILES['fichier']['name']);
    $extension = strtolower(pathinfo($nomOriginal, PATHINFO_EXTENSION));
    $taille = $_FILES['fichier']['size'];

    if (!in_array($extension, $formats)) {
        $erreur = "Format non autorisé. Formats acceptés : " . implode(', ', $formats) . ".";
    } elseif ($taille > $tailleMax) {
        $erreur = "Le fichier dépasse 2 Mo.";
    } else {
        $nomStocke = uniqid() . '.' . $extension;

        if (move_uploaded_file($_FILES['fichier']['tmp_name'], $dossier . $nomStocke)) {
            try {
                $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8", $dbUser, $dbPass);
                $requete = $pdo->prepare("INSERT INTO fichiers (nom_original, nom_stocke, extension, taille) VALUES (?, ?, ?, ?)");
                $requete->execute([$nomOriginal, $nomStocke, $extension, $taille]);
                $message = "Le fichier « " . htmlspecialchars($nomOriginal) . " » a bien été envoyé.";
            } catch (PDOException $e) {
                $erreur = "Fichier déposé, mais erreur de base de données : " . htmlspecialchars($e->getMessage());
            }
        } else {
            $erreur = "Impossible d'enregistrer le fichier sur le serveur.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Résultat de l'envoi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-secondary-subtle d-flex flex-column min-vh-100">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand"><i class="bi bi-cloud-arrow-up"></i> Dépôt de documents</span>
    </div>
</nav>

<main class="container my-auto py-5" style="max-width: 520px;">
    <div class="card shadow border-0 text-center">
        <div class="card-body p-4">
            <?php if ($erreur): ?>
                <i class="bi bi-x-circle text-danger" style="font-size: 3rem;"></i>
                <h2 class="h4 mt-2">Échec de l'envoi</h2>
                <p class="text-danger"><?= $erreur ?></p>
            <?php else: ?>
                <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                <h2 class="h4 mt-2">Envoi réussi</h2>
                <p><?= $message ?></p>
            <?php endif; ?>
            <a href="index.php" class="btn btn-dark"><i class="bi bi-arrow-left"></i> Envoyer un autre fichier</a>
        </div>
    </div>
</main>

<footer class="text-center text-muted small py-3">Yacine Harrache · Maintenance Applicative</footer>

</body>
</html>
