<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // On inclut les fichiers de configuratio et d'acces aux donnees
    include_once '../configuration/Connexion.php';
    include_once '../entity/Etudiant.php';

    // On instancie la base de donnees
    $database = new Connexion();
    $db = $database->getConnection();

    // On instancie l'etudiant
    $etudiant = new Etudiant($db);

    // On recupere les donnees
    $stmt = $etudiant->afficherEtudiant();

    // On verifie si on a au moins 1 etudiant
    if ($stmt->rowCount() > 0) {
        // On initialise un tableau associatif
        $tableauEtudiants = [];
        $tableauEtudiants['etudiant'] = [];

        // On parcourt l'etudiant
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $etud = [
                "numEt" => $numEt,
                "nomEt" => $nomEt,
                "niveauEt" => $niveauEt
            ];

            $tableauEtudiants['etudiant'][] = $etud;
        }

         // On envoie le code réponse 200 OK
         http_response_code(200);

         // On encode en json et on envoie
         echo json_encode($tableauEtudiants);
        }

    }else{
        // On gère l'erreur
        http_response_code(405);
        echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
