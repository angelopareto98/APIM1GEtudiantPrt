<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On verifie la methode
if ($_SERVER['REQUEST_METHOD'] == 'PUT') { 
   // On inclut les fichiers de configuration et d'acces aux donnees
   include_once '../configuration/Connexion.php';
   include_once '../entity/Notes.php';

   // On instancie la base de donnees
   $database = new Connexion();
   $db = $database->getConnection();

   // On instancie les Etudiants
   $notes = new Notes($db);

   // On recupere les information envoyees
   $donnees = json_decode(file_get_contents("php://input"));
    
    if (!empty($donnees->numInscription) && !empty($donnees->numEt) && !empty($donnees->codeMat) && !empty($donnees->note)) {
        //  Ici on a recu les donnees
        // On hydrate notre objet
        $notes->numInscription = $donnees->numInscription;
        $notes->numEt = $donnees->numEt;
        $notes->codeMat = $donnees->codeMat;
        $notes->note = $donnees->note;


        if ($notes->modifierNotes()) {
            /// Ici la creation a fonctionné
            // On envoie un code 200
            http_response_code(200);
            echo json_encode(["message" => "La modification a été effectuée"]);
        }else{
            // Ici la création n'a pas fonctionné
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "La modification n'a pas été effectuée"]); 
        }
    }else { echo json_encode(["message" => "Vous avez oublier une proprietée ou ..."]);} 

}else{
    // On gère l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}