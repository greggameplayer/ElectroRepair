
let qrcodediv = document.getElementById("qrcodediv");

$("document").ready(function(){
   $("#qrcodebutton").on('click', qrcode);
});




function qrcode(){
    if(qrcodediv.style.display != "none"){
        qrcodediv.style.display = "none";
      } else {
        qrcodediv.style.display = "block";
      }
}

