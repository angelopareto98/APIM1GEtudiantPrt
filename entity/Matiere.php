<?php

class Matiere
{
    private $connection;
    private $table = 'Matiere';

    public $codeMat;
    public $libelleMat;
    public $coefMat;


    public function __construct($db){
        $this->connection = $db;

    }


    /**
     * Fonction pour creer la matiere
     *
     * @return void
     */
    public function creerMatiere(){
        $sql = "INSERT INTO " . $this->table . " SET codeMat=:codeMat, libelleMat=:libelleMat, coefMat=:coefMat";

        $query = $this->connection->prepare($sql);

        $this->codeMat=htmlspecialchars(strip_tags($this->codeMat));
        $this->libelleMat=htmlspecialchars(strip_tags($this->libelleMat));
        $this->coefMat=htmlspecialchars(strip_tags($this->coefMat));

        $query->bindParam(":codeMat", $this->codeMat);
        $query->bindParam(":libelleMat", $this->libelleMat);
        $query->bindParam(":coefMat", $this->coefMat);

        if ($query->execute()) {
            return true;
        }
        return false;
    }


    /**
     * Fonction pour afficher les Matieres
     *
     * @return void
     */
    public function afficherMatiere(){
        $sql = "SELECT codeMat, libelleMat, coefMat FROM " . $this->table;

        $query = $this->connection->prepare($sql);

        $query->execute();

        return $query;
    }


  /**
     * methode pour modifier une matiere
     *
     * @return void
     */
    public function modifierMatiere()
    {
        // Requete
        $sql = "UPDATE " . $this->table . " SET libelleMat = :libelleMat, coefMat = :coefMat WHERE codeMat = :codeMat";
        
        // On prepare la requete
        $query = $this->connection->prepare($sql);

        // On securise les donnees
        $this->libelleMat=htmlspecialchars(strip_tags($this->libelleMat));
        $this->coefMat=htmlspecialchars(strip_tags($this->coefMat));
        $this->codeMat=htmlspecialchars(strip_tags($this->codeMat));

        // On attache les variables
        $query->bindParam(':libelleMat', $this->libelleMat);
        $query->bindParam(':coefMat', $this->coefMat);
        $query->bindParam(':codeMat', $this->codeMat);

        // Execution
        if ($query->execute()) {
            return true;

        }
        return false;
    }




    /**
     * methode pour supprimer une matiere
     *
     * @return void
     */
    public function supprimerMatiere(){
        // Requete
        $sql = "DELETE FROM " . $this->table . " WHERE codeMat = ?";

        // On prepare la requete
        $query = $this->connection->prepare($sql);

        // On securise les donnees
        $this->codeMat=htmlspecialchars(strip_tags($this->codeMat));

        // On attache le numero d'etudiant
        $query->bindParam(1, $this->codeMat);

        // Execution
        if ($query->execute()) {
            return true;
        }
        return false;
    }

}
