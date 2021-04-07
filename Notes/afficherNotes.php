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


    $notes = new Notes($db);


    $stmt = $notes->afficherNotes();

    if ($stmt->rowCount() > 0) {
        // On initialise un tableau associatif
        $tableauNotes = [];


        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $noteNum = [
                "numInscription" => $numInscription,
                "numEt" => $numEt,
                "codeMat" => $codeMat,
                "note" => $note
            ];

            $tableauNotes['Notes des Etudiant'][] = $noteNum;
        }


         http_response_code(200);

   
         echo json_encode($tableauNotes);
        }

    }else{
 
        http_response_code(405);
        echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
