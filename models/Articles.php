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
        $stmt=$this->connect->prepare ("SELECT a.id, a.slug, u.username ,a.ft_image,a.content, a.title, a.created_at, a.chapo, u.ft_image as uim FROM articles a JOIN users u ON (a.user_id=u.id)");
        $stmt->execute();
        $resArticles = $stmt->fetchall();
        return $resArticles;

    }
    function getArticleById($id)
    {
        $stmt = $this->connect->prepare("SELECT a.id, a.slug, u.username ,a.ft_image, a.title, a.content, a.created_at, a.chapo, u.ft_image as uim, u.role FROM articles a JOIN users u ON (a.user_id=u.id) WHERE a.id=$id") ;
        $stmt->execute();
        $resArticle = $stmt->fetch();
        return $resArticle;

    }
    function insertArticle($title,$chapo,$content, $slug,$userid, $imgpath='')
        {
            $data = ['title' => $title, 'chapo' => $chapo, 'content' => $content, 'slug'=>$slug, 'user_id'=>$userid,'ft_img' => $imgpath];
            $insArticle = $this->connect->prepare("INSERT INTO articles (title, chapo, content, slug, created_at, user_id, ft_image) VALUES (:title, :chapo, :content, :slug, now(), :user_id,:ft_img)");
            $insArticle->execute($data);
            return $insArticle->rowCount();
        }
    function replaceArticle($title,$chapo,$content, $slug, $userid, $id, $imgpath='')
    {
        $stmt = $this->connect->prepare("UPDATE articles SET title='$title', chapo='$chapo', content='$content', slug='$slug', created_at=now(), user_id='$userid', ft_image='$imgpath' WHERE id='$id' ");
        $stmt->execute();
        return $stmt->rowCount();
    }

    function checkArticle($title,$slug)
    {
        $stmt = $this->connect->prepare("SELECT id FROM articles WHERE title='$title' AND slug='$slug'");
        $stmt->execute();
        return $stmt->rowCount();
    }


    function checkId($verifiedId)
    {
        $stmt = $this->connect->prepare("SELECT id FROM articles WHERE id='$verifiedId'");
        $stmt->execute();
        return $stmt->rowCount();
    }

    function suppArticle($id)
    {
        $stmt = $this->connect->prepare("DELETE FROM articles WHERE id='$id'");
        $stmt->execute();
        $stmt->fetch();
        return $stmt;
    }
    function modArticle($id)
    {
        $stmt = $this->connect->prepare("SELECT * FROM articles WHERE id='$id'");
        $stmt->execute();
        $modArticle=$stmt->fetch();
        return $modArticle;
    }
    }
