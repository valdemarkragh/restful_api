<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  include_once '../../config/Database.php';
  include_once '../../models/Project.php';
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();
  // Instantiate blog post object
  $project = new Project($db);
  // Get ID
  $project->id = isset($_GET['id']) ? $_GET['id'] : die();
  // Get post
  $project->read_single();
  // Create array
  $project_arr = array(
    'id' => $project->id,
    'title' => $project->title,
    'body' => $project->body,
    'image' => $project->image
  );
  // Make JSON
  print_r(json_encode($project_arr));