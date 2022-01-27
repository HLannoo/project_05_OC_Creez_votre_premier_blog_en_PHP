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
        if (empty(trim($content)) || empty(trim($pseudo))) {
            return 0;
        } else {
            $data = ['pseudo' => $pseudo, 'title' => $title, 'content' => $content, 'id_article' => $idarticle];
            $addComment = $this->connect->prepare("INSERT INTO comments  (pseudo, title, content, created_at, article_id) VALUES (:pseudo, :title, :content, now(), :id_article)");
            $addComment->execute($data);
            return $addComment->rowCount();
        }

    }

    function getAllArticleComments($articleid)
    {
        $reqComments = $this->connect->query("SELECT pseudo,title, content, created_at, published FROM comments WHERE article_id=$articleid");
        $resComments = $reqComments->fetchall();
        return $resComments;

    }

    function getComments()
    {
        $reqComments = $this->connect->query("SELECT u.title as uim, a.title, a.id,a.pseudo, a.content ,a.created_at,a.published FROM comments a JOIN articles u ON (a.article_id=u.id)");
        $resComments = $reqComments->fetchall();
        return $resComments;
    }

    function checkStatus($id)
    {
        $reqComments = $this->connect->query("SELECT published FROM comments WHERE id='$id'");
        $resComments = $reqComments->fetch();
        return $resComments;
    }

    function valComment($id)
    {
        $reqComments = $this->connect->query("UPDATE comments SET published = 1 WHERE id='$id'");
    }

    function denComment($id)
    {
        $reqComments = $this->connect->query("UPDATE comments SET published = 2 WHERE id='$id'");
    }

    function suprComment($id)
    {
        $suppComment = $this->connect->query("DELETE FROM comments WHERE id='$id'");
        $resultComment = $suppComment->fetch();
        return $resultComment;
    }
}
