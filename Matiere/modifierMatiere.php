<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'PUT') { 
   include_once '../configuration/Connexion.php';
   include_once '../entity/Matiere.php';

   $database = new Connexion();
   $db = $database->getConnection();


   $matiere = new Matiere($db);


   $donnees = json_decode(file_get_contents("php://input"));
    
    if (!empty($donnees->codeMat) && !empty($donnees->libelleMat) && !empty($donnees->coefMat)) {

        $matiere->codeMat = $donnees->codeMat;
        $matiere->libelleMat = $donnees->libelleMat;
        $matiere->coefMat = $donnees->coefMat;


        if ($matiere->modifierMatiere()) {
            http_response_code(200);
            echo json_encode(["message" => "La modification de la matiere a été effectuée"]);
        }else{
            http_response_code(503);
            echo json_encode(["message" => "La modification de la matiere n'a pas été effectuée"]); 
        }
    }else { echo json_encode(["message" => "Vous avez oublier une proprietée ou ..."]);} 

}else{
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}