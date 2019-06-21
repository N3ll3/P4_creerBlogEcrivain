<?php
namespace Controller;

use Model\PostManager;
use Model\CommentManager;

require_once('vendor/autoload.php');

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

    public function onePost()
    {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $postManager = new PostManager();
            $commentManager = new CommentManager();
            $post = $postManager->getPost($_GET['id']);
            $commentsData = $commentManager->getComments($_GET['id']);

            $comments = $commentsData->fetchAll();

            echo  $this->twig->render("OnePostView.twig", [
                'post' => $post,
                'comments' => $comments,

            ]);
            $commentsData->closeCursor();
        } else {
            throw new \Exception('Aucun identifiant de billet envoyé');
        }
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
}
