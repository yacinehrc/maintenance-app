CREATE TABLE fichiers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_original VARCHAR(255) NOT NULL,
    nom_stocke VARCHAR(255) NOT NULL,
    extension VARCHAR(10) NOT NULL,
    taille INT NOT NULL,
    date_upload DATETIME DEFAULT CURRENT_TIMESTAMP
);
