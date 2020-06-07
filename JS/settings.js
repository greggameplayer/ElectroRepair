
let qrcodediv = document.getElementById("qrcodediv");

$("document").ready(function(){
   $("#qrcodebutton").on('click', qrcode);
});



function qrcode(){
    console.log($("#qrcodediv").css('display'));
    if($("#qrcodediv").css('display') == 'none'){
        $("#qrcodediv").css('display','block');
    } else {
        $("#qrcodediv").css('display','none');
    }
}

function readUrl(input) {

    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = (e) => {
            let imgData = e.target.result;
            let imgName = input.files[0].name;
            input.setAttribute("data-title", imgName);
            console.log(e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }

}

$( function() {
    $( ".slider-range" ).each(function() {
        let actualAmount = ($(this)[0]).parentNode.children[0];
        $(this).slider({
            range: true,
            min: 0,
            max: 1410,
            step: 30,
            values: [600, 720],
            slide: function (event, ui) {
                var hours1 = Math.floor(ui.values[0] / 60);
                var minutes1 = ui.values[0] - (hours1 * 60);

                if (hours1.length == 1) hours1 = '0' + hours1;
                if (minutes1.length == 1) minutes1 = '0' + minutes1;
                if (minutes1 == 0) minutes1 = '00';

                if (hours1 == 0) {
                    hours1 = 0;
                }

                var hours2 = Math.floor(ui.values[1] / 60);
                var minutes2 = ui.values[1] - (hours2 * 60);

                if (hours2.length == 1) hours2 = '0' + hours2;
                if (minutes2.length == 1) minutes2 = '0' + minutes2;
                if (minutes2 == 0) minutes2 = '00';


                $(actualAmount).val(hours1 + ":" + minutes1 + " - " + hours2 + ":" + minutes2);
            }
        });
    });
    $( ".amounts" ).each(function(){
        let actualAmount = ($(this)[0]).parentNode.children[0];
        let actualSlider = ($(this)[0]).parentNode.children[1];
        $(actualAmount).val("10:00 - 12:00");
    });
} );

