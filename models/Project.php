<?php 
  class Project {
    // DB stuff
    private $conn;
    private $table = 'projects';
    // Project Properties
    public $id;
    public $title;
    public $body;
    public $image;
    public $date;
    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }
    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT id, title, body, image
                                FROM ' . $this->table . '
                                ORDER BY
                                  date DESC';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      // Execute query
      $stmt->execute();
      return $stmt;
    }
    // Get Single Post
    public function read_single() {
          // Create query
          $query = 'SELECT id, title, body, image
                                    FROM ' . $this->table . '
                                    WHERE
                                      id = ?
                                    LIMIT 0,1';
          // Prepare statement
          $stmt = $this->conn->prepare($query);
          // Bind ID
          $stmt->bindParam(1, $this->id);
          // Execute query
          $stmt->execute();
          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          // Set properties
          $this->title = $row['title'];
          $this->body = $row['body'];
    }
    // Create Post
    public function create() {
          // Create query
          $query = 'INSERT INTO ' . $this->table . ' SET title = :title, body = :body, image = :image';
          // Prepare statement
          $stmt = $this->conn->prepare($query);
          // Clean data
          $this->title = htmlspecialchars(strip_tags($this->title));
          $this->body = htmlspecialchars(strip_tags($this->body));
          $this->image = $this->image;
          // Bind data
          $stmt->bindParam(':title', $this->title);
          $stmt->bindParam(':body', $this->body);
          $stmt->bindParam(':image', $this->image);
          // Execute query
          if($stmt->execute()) {
            return true;
      }
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);
      return false;
    }
    // Update Post
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET title = :title, body = :body
                                WHERE id = :id';
          // Prepare statement
          $stmt = $this->conn->prepare($query);
          // Clean data
          $this->title = htmlspecialchars(strip_tags($this->title));
          $this->body = htmlspecialchars(strip_tags($this->body));
          $this->id = htmlspecialchars(strip_tags($this->id));
          // Bind data
          $stmt->bindParam(':title', $this->title);
          $stmt->bindParam(':body', $this->body);
          $stmt->bindParam(':id', $this->id);
          // Execute query
          if($stmt->execute()) {
            return true;
          }
          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);
          return false;
    }
    // Delete Post
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
          // Prepare statement
          $stmt = $this->conn->prepare($query);
          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));
          // Bind data
          $stmt->bindParam(':id', $this->id);
          // Execute query
          if($stmt->execute()) {
            return true;
          }
          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);
          return false;
    }
    
  }