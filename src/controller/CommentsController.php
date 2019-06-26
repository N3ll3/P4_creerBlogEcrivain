<?php
namespace Controller;

use Model\CommentManager;

class CommentsController

{
    public $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('src\view\templates');
        $this->twig = new \Twig\Environment($loader, [
            'debug' => true,
            'cache' => false /*__DIR__.'/view/frontend/tmp'*/
        ]);
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }


    public function addComment($postId, $author, $content)
    {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                $commentManager = new CommentManager();
                $comment = $commentManager->postComment($postId, $author, $content);

                if ($comment === false) {
                    throw new \Exception('Impossible d\'ajouter le commentaire !');
                } else {
                    header('Location: index.php?action=onePost&id=' . $postId);
                }
            } else {
                throw new \Exception('Tous les champs ne sont pas remplis !');
            }
        }
    }

    public function flagComment($idComment)
    {
        if (isset($_GET['idComment']) && $_GET['idComment'] > 0) {
            $commentManager = new CommentManager();
            $comment = $commentManager->getComment($idComment);
            $commentManager->isFlagged($idComment);
        } else {
            throw new \Exception('Aucun identifiant de billet envoyé');
        }
    }

    public function listFlaggedComments()
    {
        $commentManager = new CommentManager();
        $flaggedComments = $commentManager->getCommentsFlagged();
        if (isset($flaggedComments)) {
            echo  $this->twig->render("moderateComment.twig", [
                'comments' => $flaggedComments,
            ]);
        } else {
            throw new \Exception('Il n\'y a aucun commentaire à modérer');
        }
    }

    public function deleteComment($idComment)
    {
        if (isset($_GET['idComment']) && $_GET['idComment'] > 0) {
            $commentManager = new CommentManager();
            $commentManager->deleteComment($idComment);
            \header('Location:index.php?action=moderateComment');
        } else {
            throw new \Exception('Aucun commentaire à supprimer');
        }
    }

    public function approveComment($idComment)
    {
        if (isset($_GET['idComment']) && $_GET['idComment'] > 0) {
            $commentManager = new CommentManager();
            $commentManager->unflagComment($idComment);
            \header('Location:index.php?action=moderateComment');
        } else {
            throw new \Exception('Aucun commentaire à conserver');
        }
    }
}
