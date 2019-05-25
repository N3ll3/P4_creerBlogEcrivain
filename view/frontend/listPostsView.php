<?php

while ($data = $posts->fetch()) {

    echo  $twig->render("listPostView.twig", [
        'data' => $data
    ]);
}

$posts->closeCursor();
