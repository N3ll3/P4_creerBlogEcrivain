<?php

namespace Model;

use Model\Manager;

class PostManager extends Manager
{
    public function getPosts()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, content, creation_date FROM posts WHERE published = 1 ORDER BY id LIMIT 0, 5');

        return $req;
    }

    public function getPost($postId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content,creation_date FROM posts WHERE id = :post_id');
        $req->execute(array('post_id' => $postId));
        $post = $req->fetch();

        return $post;
    }

    public function insertPost($title, $content)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO posts(title, content, creation_date, published) VALUES (:title, :content, NOW(), published = 1)');
        $newPost = $req->execute(array('title' => $title, 'content' => $content));

        return $newPost;
    }

    public function modifyPost($title, $content, $idPost)
    {
        $db = $this->dbConnect();
        $updatedPost = $db->prepare('UPDATE posts SET title=:modifiedTitle, content= :modifiedContent WHERE id=:idPost');
        $modifiedPost = $updatedPost->execute(array(
            'modifiedTitle' => $title,
            'modifiedContent' => $content,
            'idPost' => $idPost
        ));

        return $modifiedPost;
    }

    public function savePost($title, $content)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO posts(title, content, creation_date, published) VALUES (:title, :content, NOW(), :published)');
        $savePost = $req->execute(array('title' => $title, 'content' => $content, 'published' => 0));
        return $savePost;
    }

    public function getChapWIP()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, content,creation_date FROM posts WHERE published = 0');
        $savedPost = $req->fetch();

        return $savedPost;
    }

    public function deletePost($idPost)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM posts WHERE id= :idPost');
        $deletePost = $req->execute(array('idPost' => $idPost));
        return $deletePost;
    }
}
