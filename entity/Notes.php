<?php
class Notes{
    private $connexion;
    private $table = "Notes";

    public $numInscription;
    public $numEt;
    public $codeMat;
    public $note;


    /**
     * Constructeur pour la classe Notes
     *
     * @param [type] $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }

    

    /**
     * Fonction pour l'assignation de la note
     *
     * @return void
     */
    public function creerNotes(){
         // Requete
         $sql = "INSERT INTO " . $this->table . " SET numInscription=:numInscription, numEt=:numEt, codeMat=:codeMat, note=:note";

         // Preparation de la requete
         $query = $this->connexion->prepare($sql);
 
         // Protection contre les injections
         $this->numInscription=htmlspecialchars(strip_tags($this->numInscription));
         $this->numEt=htmlspecialchars(strip_tags($this->numEt));
         $this->codeMat=htmlspecialchars(strip_tags($this->codeMat));
         $this->note=htmlspecialchars(strip_tags($this->note));
 
         // Ajout des donnees protegees
         $query->bindParam(":numInscription", $this->numInscription);
         $query->bindParam(":numEt", $this->numEt);
         $query->bindParam(":codeMat", $this->codeMat);
         $query->bindParam(":note", $this->note);
         
         // Execution de la query
         if ($query->execute()) {
             return true;
            }
            return false;
    }




    /**
     * methode pour afficher l'information sur la table Notes
     *
     * @return void
     */
    public function afficherNotes(){
        // requete
        $sql = "SELECT numInscription, numEt, codeMat, note FROM " . $this->table;

       // On prépare la requête
       $query = $this->connexion->prepare($sql);

       // On exécute la requête
       $query->execute();

       // On retourne le résultat
       return $query;
    }








    // // Variable pour les Jointures
    // public $nomEt;
    // public $niveauEt;
    // public $libelleMat;
    // public $coefMat;
    // /**
    //  * Fonction pour afficher les informations sur l'Etudiant, Matiere, Notes en utilisant le Jointure
    //  *
    //  * @return void
    //  */
    // public function afficherNotesEtudiant(){
    //     // $sql = "SELECT e.numEt, e.nomEt, e.niveauEt, m.libelleMat, m.coefMat, n.notes FROM" 
    //     //         .$this->table.
    //     //         " AS n LEFT JOIN Matiere AS m ON n.codeMat = m.codeMat
    //     //          LEFT JOIN Etudiant AS e ON n.numEt = e.numEt
    //     //           WHERE numInscription = :numInscription";
    //     $sql = "SELECT e.numEt AS numEt, e.nomEt AS nomEt, e.niveauEt AS niveauEt,
    //     m.libelleMat AS libelleMat, m.coefMat AS coefMat,
    //     n.note AS note
    //     FROM Notes AS n
    //     INNER JOIN Etudiant AS e
    //     ON n.numEt = e.numEt
    //     INNER JOIN Matiere AS m
    //     ON n.codeMat = m.codeMat
    //     ";

    //     $query = $this->connexion->prepare($sql);

    //     $this->numInscription=htmlspecialchars(strip_tags($this->numInscription));
    //     $query->bindParam(":numInscription", $this->numInscription);

    //     if ($query->execute()) {
    //         return true;
    //     }
    //     return false;

    // }




    public function modifierNotes(){
       // Requete
       $sql = "UPDATE " . $this->table . " SET  note=:note WHERE numInscription=:numInscription AND numEt=:numEt AND codeMat=:codeMat";

       // On prepare la requete
       $query = $this->connexion->prepare($sql);

       $this->numInscription=htmlspecialchars(strip_tags($this->numInscription));
       $this->numEt=htmlspecialchars(strip_tags($this->numEt));
       $this->codeMat=htmlspecialchars(strip_tags($this->codeMat));
       $this->note=htmlspecialchars(strip_tags($this->note));

       // Ajout des donnees protegees
       $query->bindParam(":numInscription", $this->numInscription);
       $query->bindParam(":numEt", $this->numEt);
       $query->bindParam(":codeMat", $this->codeMat);
       $query->bindParam(":note", $this->note);

       // Execution
       if ($query->execute()) {
           return true;
       }

       return false;
    }


    public function supprimerNotes(){
        $sql = "DELETE FROM " . $this->table . " WHERE numInscription=:numInscription AND numEt=:numEt AND codeMat=:codeMat";

        // On prepare la requete
        $query = $this->connexion->prepare($sql);

        $this->numInscription=htmlspecialchars(strip_tags($this->numInscription));
        $this->numEt=htmlspecialchars(strip_tags($this->numEt));
        $this->codeMat=htmlspecialchars(strip_tags($this->codeMat));
 
        // Ajout des donnees protegees
        $query->bindParam(":numInscription", $this->numInscription);
        $query->bindParam(":numEt", $this->numEt);
        $query->bindParam(":codeMat", $this->codeMat);
        // Execution
        if ($query->execute()) {
            return true;
        }
        return false;
    }

}


?>