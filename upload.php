<?php
require 'config.php';

$formats = ['pdf', 'jpg', 'jpeg', 'png', 'txt', 'doc', 'docx'];
$tailleMax = 2 * 1024 * 1024;
$dossier = __DIR__ . '/travaux/';

if (!is_dir($dossier)) {
    mkdir($dossier, 0755, true);
}

$erreur = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['fichier'])) {
    $erreur = "Aucun fichier envoyé.";
} elseif ($_FILES['fichier']['error'] !== UPLOAD_ERR_OK) {
    $erreur = "Erreur pendant l'envoi du fichier.";
} else {
    $nomOriginal = basename($_FILES['fichier']['name']);
    $extension = strtolower(pathinfo($nomOriginal, PATHINFO_EXTENSION));
    $taille = (int) $_FILES['fichier']['size'];

    if (!in_array($extension, $formats, true)) {
        $erreur = "Format non autorisé. Formats acceptés : " . implode(', ', $formats) . ".";
    } elseif ($taille > $tailleMax) {
        $erreur = "Le fichier dépasse 2 Mo.";
    } else {
        $nomStocke = uniqid('epsilon_', true) . '.' . $extension;
        $cheminDestination = $dossier . $nomStocke;

        if (move_uploaded_file($_FILES['fichier']['tmp_name'], $cheminDestination)) {
            try {
                $pdo = new PDO(
                    "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4",
                    $dbUser,
                    $dbPass,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );

                $requete = $pdo->prepare(
                    "INSERT INTO fichiers (nom_original, nom_stocke, extension, taille)
                     VALUES (:nom_original, :nom_stocke, :extension, :taille)"
                );
                $requete->execute([
                    ':nom_original' => $nomOriginal,
                    ':nom_stocke'   => $nomStocke,
                    ':extension'    => $extension,
                    ':taille'       => $taille,
                ]);

                $message = "Le fichier « " . htmlspecialchars($nomOriginal) . " » a bien été enregistré dans <strong>travaux/</strong> et référencé en base de données.";
            } catch (PDOException $e) {
                $erreur = "Fichier déposé dans travaux/, mais erreur de base de données : " . htmlspecialchars($e->getMessage());
            }
        } else {
            $erreur = "Impossible d'enregistrer le fichier dans le dossier travaux.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EPSILON — Résultat de l'envoi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-secondary-subtle d-flex flex-column min-vh-100">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
            <img src="Documents/epsilon.png" alt="Logo EPSILON" height="32" class="rounded">
            <span>EPSILON</span>
        </a>
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

<footer class="text-center text-muted small py-3">
    Copyright &copy; 2026 EPSI LILLE · Yacine Harrache · Maintenance Applicative
</footer>

</body>
</html>