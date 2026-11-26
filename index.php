<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload de fichiers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5" style="max-width: 600px;">
    <h1 class="mb-4">Upload de fichiers</h1>

    <div class="card">
        <div class="card-body">
            <form action="upload.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="fichier" class="form-label">Choisir un document</label>
                    <input type="file" class="form-control" name="fichier" id="fichier" accept=".pdf,.jpg,.jpeg,.png,.txt,.docx" required>
                    <div class="form-text">Formats acceptés : PDF, JPG, PNG, TXT, DOCX. Taille max : 2 Mo.</div>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
