<?php
namespace Model;

// require_once("model/Manager.php");
use Model\Manager;

class CommentManager extends Manager
{
    public function getComments($postId)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('SELECT id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE post_id = :post_id ORDER BY comment_date DESC');
        $comments->execute(array('post_id' => $postId));

        return $comments;
    }

    public function postComment($postId, $author, $comment)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('INSERT INTO comments(post_id, author, comment, comment_date) VALUES(:post_id, :author, :comment, NOW())');
        $affectedLines = $comments->execute(array('post_id' => $postId, 'author' => $author, 'comment' => $comment));

        return $affectedLines;
    }

    public function getComment($idComment)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, post_id, author, comment, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments WHERE id=?');
        $req->execute(array($idComment));
        $comment = $req->fetch();

        return $comment;
    }

    public function updateComment($modifiedComment, $idComment)
    {
        $db = $this->dbConnect();
        $newComment = $db->prepare('UPDATE comments SET comment=:modifiedComment, comment_date = NOW() WHERE id=:idComment');
        $updatedComment = $newComment->execute(array(
            'modifiedComment' => $modifiedComment,
            'idComment' => $idComment,
        ));

        return $updatedComment;
    }
}
