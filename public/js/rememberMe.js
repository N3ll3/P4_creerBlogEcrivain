const connexionInfo = document.getElementById("connexionForm");

const validate = document.getElementById("validate");
validate.addEventListener("click", e => {
  let username = connexionInfo.elements[0].value;
  if (connexionInfo.elements[2].checked == true) {
    localStorage.setItem("username", username);
  }
});

if (localStorage.getItem("username") !== "") {
  const username = localStorage.getItem("username");
  connexionInfo.elements[0].value = username;
}
