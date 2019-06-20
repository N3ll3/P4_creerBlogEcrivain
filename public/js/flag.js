$("#flag").click(function() {
  $.ajax({
    url:
      "index.php?action=flag&amp;idComment={{comment.id}}&amp;postId={{post.id}}",
    type: "POST"
  });
});
