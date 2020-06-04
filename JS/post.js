$(".custom-select").on("change", menu);

function menu()
{
    switch (this.value) {
        case '1':
            $("#afficheur1").html('<div class="form-check">\
            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">\
            <label class="form-check-label" for="defaultCheck1">\
              Default checkbox\
            </label>\
          </div>');
            break;
    }
}

function effacertout()
{
    $("#afficheur1, #afficheur2, #afficheur3").html("");
}