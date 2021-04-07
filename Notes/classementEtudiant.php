<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if($_SERVER['REQUEST_METHOD'] == 'GET'){

    include_once '../configuration/Connexion.php';
    include_once '../entity/Notes.php';


    $database = new Connexion();
    $db = $database->getConnection();


    $etudiant = new Notes($db);

   $donnees = json_decode(file_get_contents("php://input"));
    
   if (!empty($donnees->niveauEt)) {

    $etudiant->niveauEt = $donnees->niveauEt;

    $stmt = $etudiant->classementEtudiant();


    if ($stmt->rowCount() > 0) {
 
        $tableauEtudiants = [];
        $tableauEtudiants['Class'] = [];

      
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $etud =$nomEt;

            $tableauEtudiants[$etudiant->niveauEt][] = $etud;
        }

 
         http_response_code(200);


         echo json_encode($tableauEtudiants);
        }


      
   }else { echo json_encode(["message" => "Vous devez entré le niveau a Afficher"]);} 


    }else{
 
        http_response_code(405);
        echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
