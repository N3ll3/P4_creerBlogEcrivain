$("#delete").on("click", e => {
  let response = confirm(
    "Vous allez supprimer définitivement ce chapitre, êtes-vous certain de votre choix?"
  );

  if (response == true) {
    const idpost = $("#idPost").val();
    e.preventDefault();
    $.ajax({
      url: "index.php",
      type: "GET",
      data: "action=deletePost&idPost=" + idpost
    });
    window.location.href = "index.php";
  } else {
    return false;
  }
});
