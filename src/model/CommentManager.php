<?php

namespace Model;

use Model\Manager;

class CommentManager extends Manager
{
    protected $db;

    public function  __construct()
    {
        $this->db = $this->dbConnect();
    }

    
    public function getComments($postId)
    {
        $comments = $this->db->prepare(
            'SELECT id, author, comment, flagged, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr 
            FROM comments 
            WHERE post_id = :post_id 
            ORDER BY comment_date DESC'
        );
        $comments->execute(['post_id' => $postId]);
        $commentsData = $comments->fetchAll();
        $comments->closeCursor();
        return $commentsData;
    }

    public function postComment($postId, $author, $content)
    {
        $commentsData = $this->db->prepare(
            'INSERT INTO comments(post_id, author, comment, comment_date, flagged) 
            VALUES(:post_id, :author, :comment,NOW(), :flagged)'
        );
        $comment = $commentsData->execute(
            [
                'post_id' => $postId,
                'author' => $author,
                'comment' => $content,
                'flagged' => 0
            ]
        );

        return $comment;
    }

    public function isFlagged($idComment)
    {
        $commentFlagged = $this->db->prepare(
            'UPDATE comments 
            SET flagged = flagged + 1
            WHERE id =:idComment'
        );
        $isFlagged = $commentFlagged->execute(['idComment' => $idComment]);
        return $isFlagged;
    }

    public function getComment($idComment)
    {
        $req = $this->db->prepare(
            'SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr 
            FROM comments 
            WHERE id=:idComment'
        );
        $req->execute(['idcomment' => $idComment]);
        $comment = $req->fetch();
        return $comment;
    }

    public function getCommentsFlagged()
    {
        $req = $this->db->query(
            'SELECT id, post_id, author, comment, comment_date, flagged
         FROM comments 
         WHERE flagged > 2 
         ORDER BY flagged'
        );
        $commentsFlagged = $req->fetchAll();
        return $commentsFlagged;
    }

    public function getNumberOfCommentsFlagged()
    {
        $req = $this->db->query(
            'SELECT COUNT(*) as nbFlagged 
        FROM comments 
        WHERE flagged>2'
        );
        $nbCommentToModerate = $req->fetch();
        return $nbCommentToModerate[0];
    }

    public function deleteComments($idPost)
    {
        $req = $this->db->prepare(
            'DELETE FROM comments
        WHERE post_id=:idPost'
        );
        $commentsDeleted = $req->execute(['idPost' => $idPost]);
        return $commentsDeleted;
    }

    public function deleteComment($idComment)
    {
        $req = $this->db->prepare(
            'DELETE FROM comments 
            WHERE id =:idComment'
        );
        $commentDeleted = $req->execute(['idComment' => $idComment]);
        return $commentDeleted;
    }

    public function unflagComment($idComment)
    {
        $req = $this->db->prepare(
            'UPDATE comments 
            SET flagged = 0 
            WHERE id=:idComment'
        );
        $commentUnflagged = $req->execute(['idComment' => $idComment]);
        return $commentUnflagged;
    }
}
