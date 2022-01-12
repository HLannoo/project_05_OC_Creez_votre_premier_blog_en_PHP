<?php

/**
 * 
 * 
 */
class Articles

{
    private $connect;
    function __construct(PDO $connect)
    {
        $this->connect= $connect;
    }

    function getArticles()
    {
        $reqArticles = $this->connect->query("SELECT a.id, a.slug, u.username ,a.ft_image, a.title, a.created_at, a.chapo, u.ft_image as uim FROM articles a JOIN users u ON (a.user_id=u.id)");
        $resArticles = $reqArticles->fetchall();
        return $resArticles;

    }
    function getArticleById($id)
    {
        $reqArticle = $this->connect->query("SELECT a.id, a.slug, u.username ,a.ft_image, a.title, a.content, a.created_at, a.chapo, u.ft_image as uim, u.role FROM articles a JOIN users u ON (a.user_id=u.id) WHERE a.id=$id") ;
        $resArticle = $reqArticle->fetch();
        return $resArticle;

    }
}