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
        $reqArticles = $this->connect->query("SELECT a.id, a.slug, u.username ,a.ft_image,a.content, a.title, a.created_at, a.chapo, u.ft_image as uim FROM articles a JOIN users u ON (a.user_id=u.id)");
        $resArticles = $reqArticles->fetchall();
        return $resArticles;

    }
    function getArticleById($id)
    {
        $reqArticle = $this->connect->query("SELECT a.id, a.slug, u.username ,a.ft_image, a.title, a.content, a.created_at, a.chapo, u.ft_image as uim, u.role FROM articles a JOIN users u ON (a.user_id=u.id) WHERE a.id=$id") ;
        $resArticle = $reqArticle->fetch();
        return $resArticle;

    }
    function insertArticle($title,$chapo,$content,$img, $slug,$userid,$id)
        {
            $data = ['title' => $title, 'chapo' => $chapo, 'content' => $content, 'ft_img' => $img, 'slug'=>$slug, 'user_id'=>$userid,'id'=>$id];
            $insArticle = $this->connect->prepare("INSERT INTO articles (title, chapo, content, ft_image, slug, created_at, user_id, id) VALUES (:title, :chapo, :content, :ft_img, :slug, now(), :user_id, :id)");
            $insArticle->execute($data);
            return $insArticle->rowCount();
        }
    function replaceArticle($title,$chapo,$content,$img, $slug,$userid, $id)
    {
        $insArticle = $this->connect->query("UPDATE articles SET title='$title', chapo='$chapo', content='$content', ft_image='$img', slug='$slug', created_at=now(), user_id='$userid' WHERE id='$id' ");
        return $insArticle->rowCount();
    }

    function checkArticle($title,$slug)
    {
        $checkArticle = $this->connect->query("SELECT id FROM articles WHERE title='$title' AND slug='$slug'");
        return $checkArticle->rowCount();
    }


    function checkId($id)
    {
        $checkId = $this->connect->query("SELECT id FROM articles WHERE id='$id'");
        return $checkId->rowCount();
    }

    function suppArticle($id)
    {
        $suppArticle = $this->connect->query("DELETE FROM articles WHERE id='$id'");
        $resultArticle = $suppArticle->fetch();
        return $resultArticle;
    }
    function modArticle($id)
    {
        $modArticle = $this->connect->query("SELECT * FROM articles WHERE id='$id'");
        $resultArticle = $modArticle->fetch();
        return $resultArticle;
    }

    }
