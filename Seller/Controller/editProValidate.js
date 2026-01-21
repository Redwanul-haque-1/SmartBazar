document.addEventListener("DOMContentLoaded", ()=>{

  const email = document.getElementById("email");
  const msg   = document.getElementById("emailMsg");
  const form  = document.querySelector("form");

  if (!email || !form) return;

  let emailValid = true;
  let timer = null;

  function validateEmail(value){

    if (!value.includes("@") || !value.includes(".")) {
      msg.innerText = "Invalid email format";
      msg.style.color = "red";
      emailValid = false;
      return;
    }

    fetch("../../Common/checkEmail.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "email=" + encodeURIComponent(value)
    })
    .then(res => res.text())
    .then(text => {
      if (text.includes("exists")) {
        msg.innerText = text;
        msg.style.color = "red";
        emailValid = false;
      } else {
        msg.innerText = "";
        emailValid = true;
      }
    });
  }

  // live validation
  email.addEventListener("input", ()=>{
    clearTimeout(timer);
    timer = setTimeout(()=>{
      validateEmail(email.value.trim());
    }, 300);
  });

  form.addEventListener("submit", (e)=>{
    if (!emailValid) {
      e.preventDefault();
      msg.innerText = "Please fix email before saving";
      msg.style.color = "red";
    }
  });

});
