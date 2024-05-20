<?php
class article
{
    public $id;
    public $title;
    public $subtitle;
    public $article;
    public $category;
    public $author;
    public $image;
    public $date;
    public $conn;

    public function __construct($id, $conn)
    {
        $sql = "SELECT * FROM article WHERE id ='{$id}'";

        $row = mysqli_fetch_array(mysqli_query($conn, $sql));
        $this->id = $id;
        $this->conn = $conn;
        $this->title = $row['title'];
        $this->subtitle = $row['subtitle'];
        $this->article = $row['article'];
        $this->category = $row['category'];
        $this->author = $row['author'];
        $this->image = $row['image'];
        $this->date = $row['date'];
    }
    public static function writeFile($data, $id){
        $myfile = fopen("./assets/articles/".$id.".txt", "w");
        fwrite($myfile, $data);
        fclose($myfile);
        return "./assets/articles/".$id.".txt";
    }
    static function readFile($dataId){
        $myfile = fopen("./assets/articles/".$dataId.".txt", "r");
        return fread($myfile, filesize("./assets/articles/".$dataId.".txt"));
    }

    static function idRepeat($dataId, $conn){
        $sql = "SELECT * FROM article WHERE id='{$dataId}' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        return isset($row);
    }
    static function generateId($conn){
        $id = rand(10000, 99999);
        while (self::idRepeat($id, $conn)){
            $id = rand(10000, 99999);
        }
        return $id;
    }

    static function upload($title, $subtitle, $article, $category, $image, $author, $conn)
    {
        $id = article::generateId($conn);
        $date = date("Y-m-d");
        $articlePath = article::writeFile($article, $id);
        $sql = "INSERT INTO `article` (id, title, subtitle, article, category, image, author, date) VALUES ('{$id}', '{$title}', '{$subtitle}', '{$articlePath}', '{$category}', '{$image}', '{$author}', '{$date}')";
        mysqli_query($conn, $sql);
        return $id;
    }
    static function exists($conn, $id){
        $sql = "SELECT * FROM article WHERE id='{$id}' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        return isset($row);
    }
    function delete()
    {
        $sql = "DELETE FROM article WHERE id='{$this->id}'";
        mysqli_query($this->conn, $sql);
    }
}