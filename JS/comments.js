
$("document").ready(function(){
    $("#commenttextarea").on("input", onChangeTextArea);
    $("#commentform").on("submit", onSubmitCommentForm);
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

function onSubmitCommentForm(event){
    event.preventDefault();
    $.post("./index.php", {page: "AddComment", IDannonce: $("#inputannonceid").val(), Content: $("#commenttextarea").val()}, function(results){
        $("body").html(results);
        reloadCalendar();
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