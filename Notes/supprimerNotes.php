<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On verifie la methode
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // On inclut les fichiers de configuration et d'acces aux donnees
    include_once '../configuration/Connexion.php';
    include_once '../entity/Notes.php';

    // On instancie la base de donnees
    $database = new Connexion();
    $db = $database->getConnection();

    // On instancie l'etudiant
    $notes = new Notes($db);
    
    // On récupère le numero de l'etudiant
    $donnees = json_decode(file_get_contents("php://input"));
    
    if (!empty($donnees->numInscription) && !empty($donnees->numEt) && !empty($donnees->codeMat)) {
        $notes->numInscription = $donnees->numInscription;
        $notes->numEt = $donnees->numEt;
        $notes->codeMat = $donnees->codeMat;

        if ($notes->supprimerNotes()) {
            // Ici la suppression a fonctionné
            // On envoie un code 200
            http_response_code(200);
            echo json_encode(["message" => "Suppression effectuer avec success"]);
        }else{
            // Ici la création n'a pas fonctionné
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "La suppression n'a pas été effectuée"]);         
        }
    }else {echo json_encode(["message" => ".......Erreur......"]);}

}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}

?>