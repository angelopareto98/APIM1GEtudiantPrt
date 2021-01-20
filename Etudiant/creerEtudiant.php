<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// Verificatio de la methode
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // On inclut les fichiers de configuration et d'acces aux donnees
    include_once '../configuration/Connexion.php';
    include_once '../entity/Etudiant.php';

    // On instancie la base de donnees
    $database = new Connexion();
    $db = $database->getConnection();

    // On instancie les Etudiants
    $etudiant = new Etudiant($db);

    // On recupere les information envoyees
    $donnees = json_decode(file_get_contents("php://input"));

    if (!empty($donnees->numEt) && !empty($donnees->nomEt) && !empty($donnees->niveauEt)) {
        //  Ici on a recu les donnees
        // On hydrate notre objet
        $etudiant->numEt = $donnees->numEt;
        $etudiant->nomEt = $donnees->nomEt;
        $etudiant->niveauEt = $donnees->niveauEt;

        if ($etudiant->creerEtudiant()) {
            // Ici la creation a fonctionné
            // On envoie un code 201
            http_response_code(201);
            echo json_encode(["message" => "L'ajout a été effectué avec success"]);
        }else{
            // Ici la creation n'a pas fonctionné
            // On envoie un code 503
            http_response_code(503);
            echo json_encode(["message" => "L'ajout n'a pas été effectué (Ce numero appartient a quelqu'un d'autres)"]);
        }
    }else { echo json_encode(["message" => "Vous avez oublier une proprietée ou ..."]);} 
}else{
    // On gere l'erreur
    http_response_code(405);
    echo json_encode(["message" => "La methode n'est pas autorisée"]);

}

?>