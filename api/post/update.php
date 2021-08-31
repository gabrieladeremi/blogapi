<?php

    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: 
            Access-Control-Allow-Headers,
            Content-Type,
            Access-Control-Allow_Methods,
            Authorization,
            X-Requested-With'
    );

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // instantiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // instantiate blog post object
    $post = new Post($db);

    // retrieve user inputs
    $data = json_decode(file_get_contents("php://input"));

    // update post
    try {
        if ($post->update($data)) {
            echo json_encode([
                'message' => 'Post Updated'
            ]);
        } else {
            echo json_encode([
                'message' => 'Post Not Updated'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'message' => $e
        ]);
    }