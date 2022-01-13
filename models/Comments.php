<?php

/**
 *
 *
 */
class Comments

{
    private $connect;

    function __construct(PDO $connect)
    {
        $this->connect = $connect;
    }

    function insertComment($pseudo, $title, $content, $idarticle)
    {
        if (empty(trim($content)) || empty(trim($pseudo)))
        {
            return 0;
        }
        else {
            $data = ['pseudo' => $pseudo, 'title' => $title, 'content' => $content, 'id_article' => $idarticle];
            $addComment = $this->connect->prepare("INSERT INTO comments  (pseudo, title, content, created_at, article_id) VALUES (:pseudo, :title, :content, now(), :id_article)");
            $addComment->execute($data);
            return $addComment->rowCount();
        }

    }
    function getAllArticleComments($articleid)
    {
        $reqComments = $this->connect->query("SELECT pseudo,content, created_at, published FROM comments WHERE article_id=$articleid");
        $resComments = $reqComments->fetchall();
        return $resComments;

    }
}
