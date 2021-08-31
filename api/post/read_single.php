<?php

    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // instantiate DB and connect
    $database = new Database();
    $db = $database->connect();

    // instantiate blog post object
    $post = new Post($db);

    // to retrieve id from the url
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    $post->read_single($post->id);

    $post_arr = [
        'id' => $post->id,
        'title' => $post->title,
        'body' => $post->body,
        'author' => $post->author,
        'category_id' => $post->category_id,
        'category_name' => $post->category_name
    ];

    // return json encoded value
    print_r(json_encode($post_arr));

