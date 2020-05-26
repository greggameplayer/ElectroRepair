
$("document").ready(function(){
    $("#commenttextarea").on("input", onChangeTextArea);
    $("#commentform").on("submit", onSubmitCommentForm);
    $(".etoile").on("click", onClickEtoile);
    applyDateDiff();
});

function onChangeTextArea(_event){
    $("#characterlength").html($("#commenttextarea").val().length + "/250");
    if($("#commenttextarea").val().length > 240){
        $("#characterlength").css("color", "red");
    }else{
        $("#characterlength").css("color", "black");
    }
}

let clickedEtoile = false;
let notation = 0; 
function onClickEtoile(event){
        let etoileId = parseInt((event.currentTarget.children[0].id).substring((event.currentTarget.children[0].id).length -1, (event.currentTarget.children[0].id).length));
        $(".etoile").each(function(index){
            $("#" + this.children[0].id).remove();
            if(index <= etoileId){
                $("#" + this.id).append('<i id="etoile' + index + '" class="fas fa-star"></i>');
                notation = etoileId + 1;
            }
            else{
                $("#" + this.id).append('<i id="etoile' + index + '" class="far fa-star"></i>');
                notation = etoileId + 1;
            }
        });
        if (etoileId == 0 && clickedEtoile == true){
            $("#divEtoile0").html("");
            $("#divEtoile0").append('<i id="etoile0" class="far fa-star"></i>');
            notation = 0;
            clickedEtoile = false;
        }
        else if (etoileId == 0 && clickedEtoile == false){
            $("#divEtoile0").html("");
            $("#divEtoile0").append('<i id="etoile0" class="fas fa-star"></i>');
            notation = 1;
            clickedEtoile = true;
        }
        console.log(notation);
}

function onSubmitCommentForm(event){
    event.preventDefault();
    $.post("./index.php", {page: "AddComment", IDannonce: $("#inputannonceid").val(), Content: $("#commenttextarea").val(),Notation: notation}, function(results){
        $("body").html(results);
        reloadCalendar();
        applyDateDiff();
    });
}

function applyDateDiff(){
    $(".media-body small").each(function(){
        let actualDate = new Date();
        let postDate = new Date(this.innerText);
        if (dateDiffInDays(postDate, actualDate) == 0){
            if (dateDiffInHours(postDate, actualDate) == 0){
                this.innerText = "Il y a " + dateDiffInMinutes(postDate, actualDate) + " minute(s)";
            }else {
                this.innerText = "Il y a " + dateDiffInHours(postDate, actualDate) + " heure(s)";
            }
        }else {
            this.innerText = "Il y a " + dateDiffInDays(postDate, actualDate) + " jour(s)";
        }
    });
}

const _MS_PER_DAY = 1000 * 60 * 60 * 24;
const _MS_PER_HOURS = 1000 * 60 * 60;
const _MS_PER_MINUTES = 1000 * 60;

// a and b are javascript Date objects
function dateDiffInDays(a, b) {
    // Discard the time and time-zone information.
    const utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate(), a.getHours(), a.getMinutes(), a.getSeconds());
    const utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate(), b.getHours(), b.getMinutes(), b.getSeconds());

    return Math.floor((utc2 - utc1) / _MS_PER_DAY);
}

function dateDiffInHours(a, b) {
    // Discard the time and time-zone information.
    const utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate(), a.getHours(), a.getMinutes(), a.getSeconds());
    const utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate(), b.getHours(), b.getMinutes(), b.getSeconds());

    return Math.floor((utc2 - utc1) / _MS_PER_HOURS);
}

function dateDiffInMinutes(a, b) {
    // Discard the time and time-zone information.
    const utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate(), a.getHours(), a.getMinutes(), a.getSeconds());
    const utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate(), b.getHours(), b.getMinutes(), b.getSeconds());

    return Math.floor((utc2 - utc1) / _MS_PER_MINUTES);
}