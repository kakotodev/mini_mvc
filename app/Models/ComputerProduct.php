<?php

namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class ComputerProduct {

    private $id_ordinateur;
    private $nom;
    private $prix;
    private $description;
    private $composants;
    private $stock;
    private $url_img;
    private $disponible;
    
    public function getIdOrdinateur(){
        return $this->id_ordinateur;
    }

    public function setIdOrdinateur($id_ordinateur){
        $this->id_ordinateur = $id_ordinateur;
    }

    public function getNom(){
        return $this->nom;
    }

    public function setNom($nom){
        $this->nom = $nom;
    }

    public function setPrix($prix){
        $this->prix = $prix;
    }

    public function getPrix(){
        return $this->prix;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getComposants(){
        return $this->composants;
    }

    public function setComposants($composants){
        $this->composants = $composants;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function getUrlImg(){
        return $this->url_img;
    }

    public function setUrlImg($url_img){
        $this->url_img = $url_img;
    }

    public function getDisponible(){
        return $this->disponible;
    }

    public function setDisponible($disponible){
        $this->disponible = $disponible;
    }

    /**
     * @return array
     */
    public static function getAll($sort = 'default', $onlyAvailable = false){
        $pdo = Database::getPDO();
        $query = "SELECT * FROM ordinateurproduit";
        
        if ($onlyAvailable) {
            $query .= " WHERE disponible = 'disponible'";
        }
        
        switch($sort) {
            case 'price_asc':
                $query .= " ORDER BY prix ASC";
                break;
            case 'price_desc':
                $query .= " ORDER BY prix DESC";
                break;
            case 'stock_asc':
                $query .= " ORDER BY stock ASC";
                break;
            case 'stock_desc':
                $query .= " ORDER BY stock DESC";
                break;
            default:
                $query .= " ORDER BY id_ordinateur ASC";
                break;
        }

        $stmt = $pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int
     * @return array|null
     */
    public static function selectByID($id){
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM ordinateurproduit WHERE id_ordinateur = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return bool
     */
    public function save(){
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("INSERT INTO ordinateurproduit(nom, prix, description, composants, stock, url_img, disponible) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $this->nom,
            $this->prix,
            $this->description,
            $this->composants,
            $this->stock,
            $this->url_img,
            $this->disponible ?? 'disponible' // Default to available
        ]);
    }
    /**
     * @return bool
     */
    public function update(){
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("UPDATE ordinateurproduit SET nom = ?, prix = ?, description = ?, composants = ?, stock = ?, url_img = ?, disponible = ? WHERE id_ordinateur = ?");
        return $stmt->execute([
            $this->nom,
            $this->prix,
            $this->description,
            $this->composants,
            $this->stock,
            $this->url_img,
            $this->disponible,
            $this->id_ordinateur
        ]);
    }

    /**
     * @return bool
     */
    public function delete()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("DELETE FROM ordinateurproduit WHERE id = ?");
        return $stmt->execute([$this->id]);
    }

    public static function decrementStock(int $id, int $quantity): bool {
        $pdo = Database::getPDO();
        // Prevent negative stock
        $stmt = $pdo->prepare("UPDATE ordinateurproduit SET stock = stock - ? WHERE id_ordinateur = ? AND stock >= ?");
        return $stmt->execute([$quantity, $id, $quantity]);
    }

    public static function updateStock(int $id, int $newStock): bool {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("UPDATE ordinateurproduit SET stock = ? WHERE id_ordinateur = ?");
        return $stmt->execute([$newStock, $id]);
    }

    public static function updateInline(int $id, string $nom, float $prix, int $stock): bool {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("UPDATE ordinateurproduit SET nom = ?, prix = ?, stock = ? WHERE id_ordinateur = ?");
        return $stmt->execute([$nom, $prix, $stock, $id]);
    }
}
