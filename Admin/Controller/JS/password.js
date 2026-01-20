document.addEventListener("DOMContentLoaded", ()=>{
  const pass=document.getElementById("password");
  const msg=document.getElementById("passMsg");
  if(!pass) return;
  pass.addEventListener("input",()=>{
    if(pass.value.length<8){msg.innerText="Password must be at least 8 characters";}
    else{msg.innerText="";}
  });
});
