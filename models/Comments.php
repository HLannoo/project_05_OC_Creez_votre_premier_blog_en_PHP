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

    function insertComment($pseudo, $title, $content, $idArticle)
    {
        if (empty(trim($content)) || empty(trim($pseudo))) {
            return 0;
        } else {
            $data = ['pseudo' => $pseudo, 'title' => $title, 'content' => $content, 'id_article' => $idArticle];
            $addComment = $this->connect->prepare("INSERT INTO comments  (pseudo, title, content, created_at, article_id) VALUES (:pseudo, :title, :content, now(), :id_article)");
            $addComment->execute($data);
            return $addComment->rowCount();
        }

    }

    function getAllArticleComments($articleid)
    {
        $stmt = $this->connect->prepare("SELECT pseudo,title, content, created_at, published FROM comments WHERE article_id= :article_id");
        $stmt->execute(array(":article_id"=>$articleid));
        $getArticleComments=$stmt->fetchall();
        return $getArticleComments;

    }

    function getComments()
    {
        $stmt = $this->connect->prepare("SELECT u.title as uim, a.title, a.id,a.pseudo, a.content ,a.created_at,a.published FROM comments a JOIN articles u ON (a.article_id=u.id)");
        $stmt->execute();
        $getComment=$stmt->fetchall();
        return $getComment;
    }

    function checkStatus($id)
    {
        $stmt = $this->connect->prepare("SELECT published FROM comments WHERE id=:id");
        $stmt->execute(array(":id"=>$id));
        $stmt->fetch();
        return $stmt;
    }

    function valComment($id)
    {
        $stmt = $this->connect->prepare("UPDATE comments SET published = 1 WHERE id=:id");
        $stmt->execute(array(":id"=>$id));
    }

    function denComment($id)
    {
        $stmt = $this->connect->prepare("UPDATE comments SET published = 2 WHERE id=:id");
        $stmt->execute(array(":id"=>$id));
    }

    function suprComment($id)
    {
        $stmt = $this->connect->prepare("DELETE FROM comments WHERE id=:id");
        $stmt->execute(array(":id"=>$id));
        $stmt->fetch();
        return $stmt;
    }
}
