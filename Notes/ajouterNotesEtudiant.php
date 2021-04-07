<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    include_once '../configuration/Connexion.php';
    include_once '../entity/Notes.php';

    $database = new Connexion();
    $db = $database->getConnection();

    $notes = new Notes($db);

    $donnees = json_decode(file_get_contents("php://input"));

    if (!empty($donnees->numInscription) && !empty($donnees->numEt) && !empty($donnees->codeMat) && !empty($donnees->note)) {

        $notes->numInscription = $donnees->numInscription;
        $notes->numEt = $donnees->numEt;
        $notes->codeMat = $donnees->codeMat;
        $notes->note = $donnees->note;

        if ($notes->creerNotes()) {
            http_response_code(201);
            $moy = $notes->moyenneInsert();
            $moyenne = $moy->fetch(PDO::FETCH_ASSOC);
            echo json_encode(["message" => "L'ajout a été effectué avec success"]);
        }else{
            http_response_code(503);
            echo json_encode(["message" => "L'ajout n'a pas été effectué"]);
        }
    }else { echo json_encode(["message" => "Vous avez oublier une proprietée ou ..."]);} 
}else{
    // On gere l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La methode n'est pas autorisée"]);

}

?>