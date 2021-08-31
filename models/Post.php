<?php

class Post
{
    // variables related to database
    private $conn;
    private $table = 'posts';

    // Post Properties
    public  $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Posts
    public function read()
    {
        // create query
        $query = 'SELECT
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
             FROM
                ' . $this->table . ' p
            LEFT JOIN 
                categories c ON p.category_id = c.id
            ORDER BY
                p.created_at DESC     
        ';

        // create prepared statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // get single post
    public function read_single($id)
    {
        // create query
        $query = 'SELECT
                    c.name as Category_name,
                    p.id,
                    p.category_id,
                    p.title,
                    p.body,
                    p.author,
                    p.created_at
                FROM 
                    ' . $this->table . ' p
                LEFT JOIN 
                    categories c ON p.category_id = c.id
                WHERE
                    p.id = ?
                LIMIT 0, 1        
        ';

        // prepared statement
        $stmt = $this->conn->prepare($query);

        //bind ID
        // we can have positional bind parameter or named parameter in PDO
        $stmt->bindParam(1, $id);

        //execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set properties
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
        $this->created_at = $row['created_at'];

    }

    // create a post

    /**
     * @throws Exception
     */
    public function create($data)
    {
        // query to create post
        $query = 'INSERT INTO ' . $this->table .
            ' SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id
            ';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //  clean data sent
        $this->title = htmlspecialchars(strip_tags($data->title));
        $this->body = htmlspecialchars(strip_tags($data->body));
        $this->author = htmlspecialchars(strip_tags($data->author));
        $this->category_id = htmlspecialchars(strip_tags($data->category_id));

        //bind data to table
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);

        if($stmt->execute()){
            return true;
        }

        // Print error if something goes wrong
        printf("Error:  %s.\n", $stmt->error);

        return false;
    }

    public function update($data)
    {
        // query to create post
        $query = 'UPDATE ' . $this->table .
            ' SET
                title = :title,
                body = :body,
                author = :author,
                category_id = :category_id
             WHERE
                id = :id
            ';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //  clean data sent
        $this->title = htmlspecialchars(strip_tags($data->title));
        $this->body = htmlspecialchars(strip_tags($data->body));
        $this->author = htmlspecialchars(strip_tags($data->author));
        $this->category_id = htmlspecialchars(strip_tags($data->category_id));
        $this->id = htmlspecialchars(strip_tags($data->id));

        //bind data to table
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            return true;
        }

        // Print error if something goes wrong
        printf("Error:  %s.\n", $stmt->error);

        return false;
    }

    public function delete($data)
    {
        // query to create post
        $query = 'DELETE FROM ' . $this->table .
            ' WHERE
                id = :id
            ';

        //prepare statement
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($data->id));

        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            return true;
        }

        // Print error if something goes wrong
        printf("Error:  %s.\n", $stmt->error);

        return false;
    }
}