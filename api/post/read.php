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

    // blog post query
    $result = $post->read();
    $numCount = $result->rowCount();

    if($numCount > 0) {
        $posts_arr = [];
        $posts_arr['data'] = $posts_arr;

        while ($row = $result->fetch(PDO::FETCH_ASSOC))
        {
            $post_item = [
                'id' => $row['id'],
                'title' => $row['title'],
                'body' => html_entity_decode($row['body']),
                'author' => $row['author'],
                'category_id' => $row['category_id'],
                'category_name' => $row['category_name']
            ];

            //push items into data
            array_push($posts_arr['data'], $post_item);
        }

        // convert results to JSON
        echo json_encode($posts_arr);

    }
    else
    {
        echo json_encode([
            'message' => 'No Posts Found'
        ]);
    }


