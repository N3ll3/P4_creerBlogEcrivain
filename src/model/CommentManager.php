<?php
namespace Model;

use Model\Manager;

class CommentManager extends Manager
{
    public function getComments($postId)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('SELECT id, author, comment, flagged, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE post_id = :post_id ORDER BY comment_date DESC');
        $comments->execute(array('post_id' => $postId));
        $commentsData = $comments->fetchAll();

        $comments->closeCursor();
        return $commentsData;
    }

    public function postComment($postId, $author, $content)
    {
        $db = $this->dbConnect();
        $commentsData = $db->prepare('INSERT INTO comments(post_id, author, comment, comment_date, flagged) VALUES(:post_id, :author, :comment,NOW(), :flagged)');
        $comment = $commentsData->execute(array('post_id' => $postId, 'author' => $author, 'comment' => $content, 'flagged' => 0));

        return $comment;
    }

    public function getComment($idComment)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE id=?');
        $req->execute(array($idComment));
        $comment = $req->fetch();

        return $comment;
    }

    public function isFlagged($idComment)
    {
        $db = $this->dbConnect();

        $commentFlagged = $db->prepare('UPDATE comments SET flagged = flagged + 1 WHERE id =:idComment');
        $isFlagged = $commentFlagged->execute(array(
            'idComment' => $idComment
        ));
        return $isFlagged;
    }

    public function getCommentsFlagged()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT * FROM comments WHERE flagged > 2 ORDER BY flagged');
        $commentsFlagged = $req->fetchAll();
        return $commentsFlagged;
    }

    public function getNumberOfCommentsFlagged()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT COUNT(*) as nbFlagged FROM comments WHERE flagged>3');
        $nbCommentToModerate = $req->fetch();
        return $nbCommentToModerate[0];
    }

    public function deleteComment($idComment)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM comments WHERE id =:idComment');
        $commentDeleted = $req->execute(array('idComment' => $idComment));
        return $commentDeleted;
    }

    public function unflagComment($idComment)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE comments SET flagged = 0 WHERE id=:idComment');
        $commentUnflagged = $req->execute(array('idComment' => $idComment));
        return $commentUnflagged;
    }
}
