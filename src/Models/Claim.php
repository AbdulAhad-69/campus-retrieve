<?php
// src/Models/Claim.php

class Claim
{
    private $conn;
    private $table = 'claims';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Check if user already claimed this item
    public function alreadyClaimed($item_id, $user_id)
    {
        $query = "SELECT id FROM " . $this->table . " WHERE item_id = :item_id AND claimer_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':item_id', $item_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Submit a new claim
    public function create($item_id, $user_id, $message)
    {
        $query = "INSERT INTO " . $this->table . " (item_id, claimer_id, message) VALUES (:item_id, :user_id, :message)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':item_id', $item_id);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':message', $message);
        return $stmt->execute();
    }

    // Get claims for a specific item (For the Item Owner to see)
    public function getClaimsByItem($item_id)
    {
        $query = "SELECT c.*, u.full_name, u.phone, u.email 
                  FROM " . $this->table . " c
                  JOIN users u ON c.claimer_id = u.id
                  WHERE c.item_id = :item_id
                  ORDER BY c.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':item_id', $item_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
