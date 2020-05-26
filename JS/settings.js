
let qrcodediv = document.getElementById("qrcodediv");


  

function qrcode(){
    if(getComputedStyle(qrcodediv).display != "none"){
        qrcodediv.style.display = "none";
      } else {
        qrcodediv.style.display = "block";
      }
}

