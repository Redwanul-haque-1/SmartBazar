

document.addEventListener("DOMContentLoaded", ()=>{

  const pass = document.getElementById("password");
  const msg  = document.getElementById("passMsg");
  const form = document.querySelector("form");

  if(!pass || !form) return;

  pass.addEventListener("input",()=>{
    if(pass.value.length < 8){
      msg.innerText = "Password must be at least 8 characters";
      msg.style.color = "red";
    } else {
      msg.innerText = "";
    }
  });

  // submit if password < 8
  form.addEventListener("submit", (e)=>{
    if(pass.value.length < 8){
      msg.innerText = "Password must be at least 8 characters";
      msg.style.color = "red";
      e.preventDefault();  
    }
  });
});
