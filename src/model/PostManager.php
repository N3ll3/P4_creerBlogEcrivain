<?php

namespace Model;

use Model\Manager;

class PostManager extends Manager
{
    public function getNbOfAllPosts()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT COUNT(*)
        FROM posts 
        WHERE published = 1 
        ORDER BY id');
        $nbPost = $req->fetch();
        $req->closeCursor();

        return $nbPost[0];
    }

    public function getFivePosts($firstPost, $postPerPage)
    {
        $db = $this->dbConnect();
        $req = $db->query(
            'SELECT id, title, SUBSTRING(content, 1, 2000) AS content_limit, creation_date 
        FROM posts 
        WHERE published = 1 
        ORDER BY creation_date
        LIMIT ' . $firstPost . ',' . $postPerPage . ''
        );
        $datas = $req->fetchAll();
        $req->closeCursor();
        return $datas;
    }


    public function getPost($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content,creation_date 
        FROM posts 
        WHERE id = :post_id');
        $req->execute(['post_id' => $postId]);
        $post = $req->fetch();
        $req->closeCursor();
        return $post;
    }

    public function publishPost($title, $content)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO posts(title, content, creation_date, published) 
        VALUES (:title, :content, NOW(), :published)');
        $newPost = $req->execute(
            [
                'title' => $title,
                'content' => $content,
                'published' => 1
            ]
        );
        $req->closeCursor();
        return $newPost;
    }

    public function modifyPost($title, $content, $idPost)
    {
        $db = $this->dbConnect();
        $updatedPost = $db->prepare('UPDATE posts 
        SET title=:modifiedTitle, content= :modifiedContent, published=1 
        WHERE id=:idPost');
        $modifiedPost = $updatedPost->execute(
            [
                'modifiedTitle' => $title,
                'modifiedContent' => $content,
                'idPost' => $idPost
            ]
        );
        $updatedPost->closeCursor();
        return $modifiedPost;
    }

    public function savePost($title, $content)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO posts(title, content, creation_date, published) 
        VALUES (:title, :content, NOW(), :published)');
        $savePost = $req->execute(['title' => $title, 'content' => $content, 'published' => 0]);
        $req->closeCursor();
        return $savePost;
    }

    public function getChapWIP()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, content,creation_date 
        FROM posts 
        WHERE published = 0');
        $savedPosts = $req->fetchAll();
        $req->closeCursor();
        return $savedPosts;
    }

    public function deletePost($idPost)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM posts 
        WHERE id= :idPost');
        $deletePost = $req->execute(['idPost' => $idPost]);
        $req->closeCursor();
        return $deletePost;
    }
}
