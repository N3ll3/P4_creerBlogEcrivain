const comments = $(".comment").get();
console.log(comments);

comments.forEach(comment => {
  const getFormComment = $(comment)
    .find("form")
    .get();
  const formComment = getFormComment[0];
  $(formComment).submit(function(e) {
    let idComment = formComment.elements[0].value;
    let spanFlag = $(`#comment${idComment}`);
    e.preventDefault();
    $.ajax({
      url: "index.php",
      type: "GET",
      data: "action=flag&idComment=" + idComment
    });

    if ($(comment).find(".flagged").length) {
      let numberFlag = spanFlag.text();
      let newNumberFlag = parseInt(numberFlag) + 1;
      spanFlag.text(`${newNumberFlag}`);
      console.log("flag is not null");
    } else {
      console.log("flag is null");
      const flaggedComment = document.createElement("p");
      flaggedComment.className = "flagged";
      flaggedComment.textContent = "Ce commentaire a été signalé 1 fois";
      $(formComment).before(flaggedComment);
    }
  });
});
