<?php
class Etudiant{
    // Connexion
    private $connexion;
    private $table = "Etudiant";

    // Proprietés
    public $numEt;
    public $nomEt;
    public $niveauEt;

    /**
     * constructeur avec $db pour la connexion à la bd
     *
     * @param [type] $db
     */
    public function __construct($db)
    {
        $this->connexion = $db;
    }


    /**
     * methode pour creer un nouveau etudiant
     *
     * @return void
     */
    public function creerEtudiant(){
        // Requete
        $sql = "INSERT INTO " . $this->table . " SET numEt=:numEt, nomEt=:nomEt, niveauEt=:niveauEt";

        // Preparation de la requete
        $query = $this->connexion->prepare($sql);

        // Protection cotre les injections
        $this->numEt=htmlspecialchars(strip_tags($this->numEt));
        $this->nomEt=htmlspecialchars(strip_tags($this->nomEt));
        $this->niveauEt=htmlspecialchars(strip_tags($this->niveauEt));

        // Ajout des donnees protegees
        $query->bindParam(":numEt", $this->numEt);
        $query->bindParam(":nomEt", $this->nomEt);
        $query->bindParam(":niveauEt", $this->niveauEt);

        // Execution de la query
        if ($query->execute()) {
            return true;
        }
        return false;
    }


    
    /**
     * methode pour afficher tous les etudiant
     *
     * @return void
     */
    public function afficherEtudiant(){
        // requete
        $sql = "SELECT numEt, nomEt, niveauEt FROM " . $this->table;

       // On prépare la requête
       $query = $this->connexion->prepare($sql);

       // On exécute la requête
       $query->execute();

       // On retourne le résultat
       return $query;
    }


    /**
     * methode pour modifier un etudiant
     *
     * @return void
     */
    public function modifierEtudiant()
    {
        // Requete
        $sql = "UPDATE " . $this->table . " SET nomEt = :nomEt, niveauEt = :niveauEt WHERE numEt = :numEt";

        // On prepare la requete
        $query = $this->connexion->prepare($sql);

        // On securise les donnees
        $this->nomEt=htmlspecialchars(strip_tags($this->nomEt));
        $this->niveauEt=htmlspecialchars(strip_tags($this->niveauEt));
        $this->numEt=htmlspecialchars(strip_tags($this->numEt));

        // On attache les variables
        $query->bindParam(':nomEt', $this->nomEt);
        $query->bindParam(':niveauEt', $this->niveauEt);
        $query->bindParam(':numEt', $this->numEt);

        // Execution
        if ($query->execute()) {
            return true;
        }

        return false;
    }


    /**
     * methode pour supprimer un etudiant
     *
     * @return void
     */
    public function supprimerEtudiant(){
        // Requete
        $sql = "DELETE FROM " . $this->table . " WHERE numEt = ?";

        // On prepare la requete
        $query = $this->connexion->prepare($sql);

        // On securise les donnees
        $this->numEt=htmlspecialchars(strip_tags($this->numEt));

        // On attache le numero d'etudiant
        $query->bindParam(1, $this->numEt);

        // Execution
        if ($query->execute()) {
            return true;
        }
        return false;
    }



    /**
     * Rechere d' Etudiant par son numero ou son nom
     */
    public function recherheEtudiantNumNom(){
        // requete
        $sql = "SELECT numEt, nomEt, niveauEt FROM " . $this->table. " WHERE numEt=:numEt OR nomEt=:nomEt";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On securise les donnees
        $this->numEt=htmlspecialchars(strip_tags($this->numEt));
        $this->nomEt=htmlspecialchars(strip_tags($this->nomEt));

        // On attache le numero d'etudiant
        $query->bindParam(':nomEt', $this->nomEt);
        $query->bindParam(':numEt', $this->numEt);

        // Execution
        if ($query->execute()) {
            return $query;
        }
        return false;
    }



    /**
     * Affichage des listes des Etudiant par niveau
     */
    public function afficheEtudiantParNiveau(){
        // requete
        $sql = "SELECT nomEt FROM " . $this->table. " WHERE niveauEt=:niveauEt ORDER BY nomET ASC";

        // On prépare la requête
        $query = $this->connexion->prepare($sql);

        // On securise les donnees
        $this->numEt=htmlspecialchars(strip_tags($this->niveauEt));

        // On attache le numero d'etudiant
        $query->bindParam(':niveauEt', $this->niveauEt);

        // Execution
        if ($query->execute()) {
            return $query;
        }
        return false;
    }




    /**
     * Fonction pour la classification des étudiants par ordre de merite
     *
     * @return void
     */
    public function classementEtudiant(){
        $sql = "SELECT numEt, nomEt, moyenne
        FROM " .$this->table. " WHERE niveauEt=:niveauEt ORDER BY moyenne DESC
        ";

        $query = $this->connexion->prepare($sql);

        $this->niveauEt=htmlspecialchars(strip_tags($this->niveauEt));
        $query->bindParam(":niveauEt", $this->niveauEt);

        if ($query->execute()) {
            return $query;
        }
        return false;

    }



}

?>