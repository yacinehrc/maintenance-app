<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dépôt de documents</title>
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
    <div class="card shadow border-0">
        <div class="card-header bg-dark text-white">
            <i class="bi bi-file-earmark-arrow-up"></i> Envoyer un fichier
        </div>
        <div class="card-body p-4">
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="fichier" class="form-label fw-semibold">Votre document</label>
                    <input type="file" class="form-control form-control-lg" name="fichier" id="fichier" accept=".pdf,.jpg,.jpeg,.png,.txt,.docx" required>
                </div>
                <div class="mb-4">
                    <span class="badge text-bg-light border">PDF</span>
                    <span class="badge text-bg-light border">JPG</span>
                    <span class="badge text-bg-light border">PNG</span>
                    <span class="badge text-bg-light border">TXT</span>
                    <span class="badge text-bg-light border">DOCX</span>
                    <small class="text-muted ms-1">2 Mo max</small>
                </div>
                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-send"></i> Envoyer
                </button>
            </form>
        </div>
    </div>
</main>

<footer class="text-center text-muted small py-3">Yacine Harrache · Maintenance Applicative</footer>

</body>
</html>
