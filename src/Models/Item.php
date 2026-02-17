<?php
// src/Models/Item.php

class Item
{
    private $conn;
    private $table = 'items';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get all categories for the dropdown
    public function getCategories()
    {
        $query = "SELECT * FROM categories ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get Single Item by ID
    public function getById($id)
    {
        $query = "SELECT i.*, c.name as category_name, u.full_name, u.email, u.phone 
                  FROM " . $this->table . " i
                  JOIN categories c ON i.category_id = c.id
                  JOIN users u ON i.user_id = u.id
                  WHERE i.id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create a new item
    public function create($data)
    {
        $query = "INSERT INTO " . $this->table . " 
                  (user_id, category_id, type, title, description, location, image_path, status) 
                  VALUES (:user_id, :category_id, :type, :title, :description, :location, :image_path, 'Active')";

        $stmt = $this->conn->prepare($query);

        // Sanitize and Bind
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':type', $data['type']);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':location', $data['location']);
        $stmt->bindParam(':image_path', $data['image_path']);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Get Counts for Dashboard
    public function getStats()
    {
        $query = "SELECT 
                    SUM(CASE WHEN type = 'Lost' THEN 1 ELSE 0 END) as lost_count,
                    SUM(CASE WHEN type = 'Found' THEN 1 ELSE 0 END) as found_count,
                    SUM(CASE WHEN status = 'Resolved' THEN 1 ELSE 0 END) as resolved_count
                  FROM " . $this->table;

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get Latest Items
    public function getRecent()
    {
        $query = "SELECT i.*, c.name as category_name, u.full_name 
                  FROM " . $this->table . " i
                  JOIN categories c ON i.category_id = c.id
                  JOIN users u ON i.user_id = u.id
                  ORDER BY i.created_at DESC 
                  LIMIT 6";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
