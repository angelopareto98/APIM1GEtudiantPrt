<?php
// Headers requis
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// On vérifie que la méthode utilisée est correcte
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // On inclut les fichiers de configuratio et d'acces aux donnees
    include_once '../configuration/Connexion.php';
    include_once '../entity/Notes.php';

    // On instancie la base de donnees
    $database = new Connexion();
    $db = $database->getConnection();

    // On instancie l'etudiant
    $notes = new Notes($db);


      // On recupere les information envoyees
   $donnees = json_decode(file_get_contents("php://input"));
    
   if (!empty($donnees->numInscription)) {
    //  Ici on a recu les donnees
    // On hydrate notre objet
    $notes->numInscription = $donnees->numInscription;

       // On recupere les donnees
    $stmt = $notes->afficherNotesEtudiant();

    if ($stmt->rowCount() > 0) {
        // On initialise un tableau associatif
        $tableauEtudiants = [];

        // On parcourt l'etudiant
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $tableauEtudiants['numEt'] =$numEt;
            $tableauEtudiants['nomEt'] =$nomEt;
            $tableauEtudiants['niveauEt'] =$niveauEt;
            $note =[
                "libelle matiere" => $libelleMat,
                "Notes" => $note,
                "Coefficient matiere" => $coefMat
            ];

            $tableauEtudiants[$notes->numInscription][] = $note;
        }

         // On envoie le code réponse 200 OK
         http_response_code(200);

         // On encode en json et on envoie
         echo json_encode($tableauEtudiants);
        }
      
   }else { echo json_encode(["message" => "Vous devez entré le numero d'inscription de l'Etudiant"]);} 

    }else{
        // On gère l'erreur
        http_response_code(405);
        echo json_encode(["message" => "La méthode n'est pas autorisée"]);
}
