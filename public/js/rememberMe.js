const connexionInfo = document.getElementById("connexionForm");

const validate = document.getElementById("validate");
validate.addEventListener("click", e => {
  let username = connexionInfo.elements[0].value;
  console.log(username);
  if (connexionInfo.elements[2].checked == true) {
    console.log("remembreMe");
    localStorage.setItem("username", username);
  }
});

if (localStorage.getItem("username") !== "") {
  const username = localStorage.getItem("username");
  connexionInfo.elements[0].value = username;
}
