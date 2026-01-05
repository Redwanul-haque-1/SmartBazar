// document.addEventListener("DOMContentLoaded", ()=>{
//   const pass=document.getElementById("password");
//   const msg=document.getElementById("passMsg");
//   if(!pass) return;
//   pass.addEventListener("input",()=>{
//     if(pass.value.length<8){msg.innerText="Password must be at least u characters";}
//     else{msg.innerText="";}
//   });
// });



// <script>
// document.addEventListener("DOMContentLoaded", ()=>{

//   const pass = document.getElementById("password");
//   const msg = document.getElementById("passMsg");
//   const form = document.querySelector("form");

//   form.addEventListener("submit", function(e){
//       if(pass.value.length < 8){
//           msg.innerText = "Password must be at least 8 characters";
//           msg.style.color = "red";
//           e.preventDefault();   // 🚫 stop submitting
//       }
//   });

//   pass.addEventListener("input", ()=>{
//       if(pass.value.length < 8){
//           msg.innerText = "Password must be at least 8 characters";
//           msg.style.color = "red";
//       } else {
//           msg.innerText = "";
//       }
//   });

// });
// </script>


document.addEventListener("DOMContentLoaded", ()=>{

  const pass = document.getElementById("password");
  const msg  = document.getElementById("passMsg");
  const form = document.querySelector("form");

  if(!pass || !form) return;

  // Show live message
  pass.addEventListener("input",()=>{
    if(pass.value.length < 8){
      msg.innerText = "Password must be at least 8 characters";
      msg.style.color = "red";
    } else {
      msg.innerText = "";
    }
  });

  // BLOCK submit if password < 8
  form.addEventListener("submit", (e)=>{
    if(pass.value.length < 8){
      msg.innerText = "Password must be at least 8 characters";
      msg.style.color = "red";
      e.preventDefault();   // 🚫 STOP submit
    }
  });
});
