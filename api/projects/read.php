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
  // Blog post query
  $result = $project->read();
  // Get row count
  $num = $result->rowCount();
  // Check if any posts
  if($num > 0) {
    // Post array
    $project_arr = array();
    // $posts_arr['data'] = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);
      $project_item = array(
        'id' => $id,
        'title' => $title,
        'body' => html_entity_decode($body),
        'image' => $image
      );
      // Push to "data"
      array_push($project_arr, $project_item);
      // array_push($posts_arr['data'], $post_item);
    }
    // Turn to JSON & output
    echo json_encode($project_arr);
  } else {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }