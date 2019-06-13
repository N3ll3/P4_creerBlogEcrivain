<?php
namespace Controller;

use Model\CommentManager;

class ModerateCommentController
{
    public $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('src\view\backend\templates');
        $this->twig = new \Twig\Environment($loader, [
            'debug' => true,
            'cache' => false /*__DIR__.'/view/frontend/tmp'*/
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
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
            echo 'Il n\'y a aucun commentaire à modérer';
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
