let actionFlag = "flag";
let idComment = $("#idCommentHidden").val();

$("#flag").submit(function(e) {
  e.preventDefault();
  console.log();
  $.ajax({
    url: "index.php",
    type: "GET",
    data: "action=" + actionFlag + "&idComment=" + idComment
  });
});
