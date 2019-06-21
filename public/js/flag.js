let flagCommentsColl = document.getElementsByClassName("flagComment");
let flagComments = [].slice.call(flagCommentsColl);

flagComments.forEach(form => {
  $(form).submit(function(e) {
    let idComment = form.elements[0].value;
    let spanFlag = $(`#comment${idComment}`);
    e.preventDefault();
    $.ajax({
      url: "index.php",
      type: "GET",
      data: "action=flag&idComment=" + idComment
    });
    let numberFlag = spanFlag.text();
    let newNumberFlag = parseInt(numberFlag) + 1;
    spanFlag.text(`${newNumberFlag}`);
  });
});
