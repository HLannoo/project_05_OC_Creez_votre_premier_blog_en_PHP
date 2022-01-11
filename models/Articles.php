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
        $reqArticles = $this->connect->query("SELECT a.id, a.slug, u.username ,a.ft_image, a.title, a.content, a.created_at FROM articles a JOIN users u ON (a.user_id=u.id)");
        $resArticles = $reqArticles->fetchall();
        return $resArticles;

    }
}