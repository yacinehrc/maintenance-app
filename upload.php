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
</head>
<body class="bg-light">
<div class="container py-5" style="max-width: 600px;">
    <h1 class="mb-4">Résultat de l'envoi</h1>

    <?php if ($erreur): ?>
        <div class="alert alert-danger"><?= $erreur ?></div>
    <?php else: ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary">Retour</a>
</div>
</body>
</html>
