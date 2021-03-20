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
    include_once '../entity/Matiere.php';

    // On instancie la base de donnees
    $database = new Connexion();
    $db = $database->getConnection();

    $matiere = new Matiere($db);

    $stmt = $matiere->afficherMatiere();


    if ($stmt->rowCount() > 0) {

        $tableauMatieres = [];
        $tableauMatieres['matiere'] = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $mat = [
                "codeMat" => $codeMat,
                "libelleMat" => $libelleMat,
                "coefMat" => $coefMat
            ];

            $tableauMatieres['matiere'][] = $mat;
        }


         http_response_code(200);

         echo json_encode($tableauMatieres);
        }

    }else{
        http_response_code(405);
        echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
