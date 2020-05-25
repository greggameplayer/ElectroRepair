$("document").ready(function(){
    $("#inscriptionform").on("submit", onSubmitInscriptionForm);
    $("#inscriptionbutton").on("click", onClickInscriptionButton);
    $("#dropdownformheader").on("submit", onSubmitConnexion);
    $("#deconnexionbt").on("click", onClickDeconnexion);
    $(".state").on("change", afficher);
    $("#myaccountbt").on("click", onClickMyAccount);
    $("#discussbt").on("click", onClickDiscussBt);
    $("#accordiondiscussion .card .card-header .mb-0 button").on("click", onClickDiscussAccordion);
});

function onSubmitInscriptionForm(event){
    event.preventDefault();
    $.post("./index.php", {page: "inscription.model", Email: $("#usernameinscription").val(), Password: $("#passwordinscription").val(),
    Prenom: $("#prenominscription").val(), Nom: $("#nominscription").val(), Adresse: $("#adresseinscription").val(),
    CodePostal: $("#cpinscription").val(), Ville: $("#villeinscription").val(), Codecat: $("input[name=type]:checked").val()}, function(results){
        $("#alert").html(results);
        $("#alert").css("display", "block");
        refreshDropdown();
        $("#submitinscription").prop("disabled", true);
    });
}

function onClickDiscussAccordion(event){
    $.post("./index.php", {page: "chatroom", id: event.currentTarget.parentNode.children[0].value}, function (results){
        $("body").html(results);
        document.title = "Inscription / ElectroRepair";
        refreshDropdown();
    });
}

function onClickInscriptionButton(_event){
    $.post("./index.php", {page: "inscription"}, function (results){
        $("body").html(results);
        document.title = "Inscription / ElectroRepair";
        refreshDropdown();
    });
}

function refreshDropdown(){
    $("#dropdownheader").removeClass("active");
    $("#dropdownprofile").removeClass("active");
    $("#dropdownheader").off("click");
    $("#dropdownprofile").off("click");
    $("#navbarTogglerbt").off("click");
    $("#dropdownheader").on("click", function(){
       $("#DropdownMenu").toggle();
       $("#dropdownheader").toggleClass("active");
    });
    $("#dropdownprofile").on("click", function(){
       $("#dropdownprofilemenu").toggle();
       $("#dropdownheader").toggleClass("active");
    });
    $("body").off("click");
    $("body").on("click",
        function (e) {
                if (!(e.target.className.includes("dditems")) && $("#DropdownMenu").css("display") != "none") {
                    $("#DropdownMenu").toggle();
                    $("#dropdownheader").toggleClass("active");
                }
                if(!(e.target.className.includes("dditemsprofile")) && $("#dropdownprofilemenu").css("display") != "none"){
                    $("#dropdownprofilemenu").toggle();
                    $("#dropdownprofile").toggleClass("active");
                }
        }
    );
    $("#navbarTogglerbt").on("click", function(){
        $("#navbarTogglerDemo01").slideToggle(1000);
        $("#navbarTogglerbt").toggleClass("active");
    });
}

function onSubmitConnexion(event){
    event.preventDefault();
    // needs for recaptacha ready
    $.post("./index.php", {page: "captcha"}, function (resultsCaptcha)
    {
        if (resultsCaptcha.includes("Warning") || resultsCaptcha.includes("Error")) {
            window.alert("le fichier de configuration reCaptcha n'est pas présent !");
            return;
        }
        let captcha = JSON.parse(resultsCaptcha);
        grecaptcha.ready(function () {
            // do request for recaptcha token
            // response is promise with passed token
            grecaptcha.execute(captcha.site_key, {action: 'connect'}).then(function (token) {
                // add token to form
                $('#dropdownformheader').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
                $.post("./index.php", {
                    page: "connexion",
                    Email: $("#emaillogin").val(),
                    Password: $("#passwordlogin").val(),
                    token: token,
                    privateKey: captcha.private_key
                }, function (results) {
                    $("body").html(results);
                    refreshDropdown();
                    $("#deconnexionbt").on("click", onClickDeconnexion);
                    $("#myaccountbt").on("click", onClickMyAccount);
                    $("#DropdownMenu").toggle();
                    $("#dropdownheader").toggleClass("active");
                    document.title = "Accueil / ElectroRepair";
                });
            });
        });
    });
}

function onClickDeconnexion(_event){
    $.post("./index.php", {page: "deconnexion"}, function (results){
        $("body").html(results);
        refreshDropdown();
        window.location.reload();
    });
}

function onClickDiscussBt(_event){
    $.post("./index.php", {page: "discuss"}, function (results){
       $("body").html(results);
       refreshDropdown();
       document.title = "Mes discussions / ElectroRepair";
    });
}

function onClickMyAccount(_event){
    $.post("./index.php", {page: "myaccount"}, function (results){
        $("body").html(results);
        refreshDropdown();
        document.title = "Mon compte / ElectroRepair";
    });
}



function afficher()
{
    switch (this.id) {
        case 'telephone':
            effacertout();
            $("#afficheur1").html('\
                <div class="radiogroup">\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="telephoneNeDemarrePas" value="telephoneNeDemarrePas">\
                        <label class="label" for="telephoneNeDemarrePas">\
                        <div class="indicator"></div>\
                        <span class="text">Ne démarre pas</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="telephoneAVuSesPerformancesDiminuer">\
                        <label class="label" for="telephoneAVuSesPerformancesDiminuer">\
                        <div class="indicator"></div>\
                        <span class="text">A vu ses preformances diminuer</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="telephoneNAfficheRien">\
                        <label class="label" for="telephoneNAfficheRien">\
                        <div class="indicator"></div>\
                        <span class="text">N\'affiche rien</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="telephoneNeChargePas" value="telephoneNeChargePas">\
                        <label class="label" for="telephoneNeChargePas">\
                        <div class="indicator"></div>\
                        <span class="text">Ne charge pas (Testé avec un autre chargeur)</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="telephoneNemetPlusDeSons" value="telephoneNemetPlusDeSons">\
                        <label class="label" for="telephoneNemetPlusDeSons">\
                        <div class="indicator"></div>\
                        <span class="text">N\'émet plus de sons</span>\
                        </label>\
                    </div>\
                </div>');
            break;
        case 'ordinateurFixe':
            effacertout();
            $("#afficheur1").html('\
                <div class="radiogroup">\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="ordinateurFixeNeDemarrePas" value="ordinateurFixeNeDemarrePas">\
                        <label class="label" for="ordinateurFixeNeDemarrePas">\
                        <div class="indicator"></div>\
                        <span class="text">Ne démarre pas\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="ordinateurFixeNAfficheRien" value="ordinateurFixeNAfficheRien">\
                        <label class="label" for="ordinateurFixeNAfficheRien">\
                        <div class="indicator"></div>\
                        <span class="text">N\'affiche rien(Testé sur un autre écran)\
                        </label>\
                    </div>\
                </div>');
            break;
        case 'tablette':
            effacertout();
            $("#afficheur1").html('\
            <div class="radiogroup">\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="tabletteNeDemarrePas" value="tabletteNeDemarre">\
                        <label class="label" for="tabletteNeDemarrePas">\
                        <div class="indicator"></div>\
                        <span class="text">Ne démarre pas</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="tabletteAVuSesPerformancesDiminuer">\
                        <label class="label" for="tabletteAVuSesPerformancesDiminuer">\
                        <div class="indicator"></div>\
                        <span class="text">A vu ses preformances diminuer</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="tabletteNAfficheRien" value="tabletteNAfficheRien">\
                        <label class="label" for="tabletteNAfficheRien">\
                        <div class="indicator"></div>\
                        <span class="text">N\'affiche rien</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="tabletteNeChargePas" value="tabletteNeChargePas">\
                        <label class="label" for="tabletteNeChargePas">\
                        <div class="indicator"></div>\
                        <span class="text">Ne charge pas (Testé avec un autre chargeur)</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="tabletteNemetPlusDeSons" value="tabletteNemetPlusDeSons">\
                        <label class="label" for="tabletteNemetPlusDeSons">\
                        <div class="indicator"></div>\
                        <span class="text">N\'émet plus de sons</span>\
                        </label>\
                    </div>\
                </div>');
            break;
        case 'ordinateurPortable':
            effacertout();
            $("#afficheur1").html('\
                <div class="radiogroup">\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="ordinateurPortableNeDemarrePas" value="ordinateurPortableNeDemarrePas">\
                        <label class="label" for="ordinateurPortableNeDemarrePas">\
                        <div class="indicator"></div>\
                        <span class="text">Ne démarre pas</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="ordinateurPortableAVuSesPerformancesDiminuer">\
                        <label class="label" for="ordinateurPortableAVuSesPerformancesDiminuer">\
                        <div class="indicator"></div>\
                        <span class="text">A vu ses preformances diminuer</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="ordinateurPortableNAfficheRien" value="ordinateurPortableNafficheRien">\
                        <label class="label" for="ordinateurPortableNAfficheRien">\
                        <div class="indicator"></div>\
                        <span class="text">N\'affiche rien</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="ordinateurPortableNeChargePas" value="ordinateurPortableNeChargePas">\
                        <label class="label" for="ordinateurPortableNeChargePas">\
                        <div class="indicator"></div>\
                        <span class="text">Ne charge pas (Testé avec un autre chargeur)</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="ordinateurPortableNemetPlusDeSons" value="ordinateurPortableNemetPlusDeSons">\
                        <label class="label" for="ordinateurPortableNemetPlusDeSons">\
                        <div class="indicator"></div>\
                        <span class="text">N\'émet plus de sons</span>\
                        </label>\
                    </div>\
                </div>');
            break;
        case 'imprimante':
            effacertout();
            $("#afficheur1").html('\
                <div class="radiogroup">\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="imprimanteMauvaisesCouleurs" value="imprimanteMauvaisesCouleurs">\
                        <label class="label" for="imprimanteMauvaisesCouleurs">\
                        <div class="indicator"></div>\
                        <span class="text">Mauvaise couleurs</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="imprimanteNAcceptePlusLesCartouchesDEncre" value="imprimanteNAcceptePlusLesCartouchesDEncre">\
                        <label class="label" for="imprimanteNAcceptePlusLesCartouchesDEncre">\
                        <div class="indicator"></div>\
                        <span class="text">N\'accepte plus les cartouches d\'encre</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="imprimanteEstBourre" value="imprimanteEstBourre">\
                        <label class="label" for="imprimanteEstBourre">\
                        <div class="indicator"></div>\
                        <span class="text">Est bourré</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre2" id="imprimanteNeFonctionnePLus" value="imprimanteNeFonctionnePLus">\
                        <label class="label" for="imprimanteNeFonctionnePLus">\
                        <div class="indicator"></div>\
                        <span class="text">Ne fonctionne plus</span>\
                        </label>\
                    </div>\
                </div>');
            break;
        case 'telephoneAVuSesPerformancesDiminuer':
            effacer();
            $("#afficheur2").html('\
                <div class="radiogroup">\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre3" id="telephoneAVuSesPerformancesDiminuerEstInfecte" value="telephoneAVuSesPerformancesDiminuerEstInfecte">\
                        <label class="label" for="telephoneAVuSesPerformancesDiminuerEstInfecte">\
                        <div class="indicator"></div>\
                        <span class="text">Est infecté</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre3" id="telephoneAVuSesPerformancesDiminuerAutre" value="telephoneAVuSesPerformancesDiminuerAutre">\
                        <label class="label" for="telephoneAVuSesPerformancesDiminuerAutre">\
                        <div class="indicator"></div>\
                        <span class="text">Autre</span>\
                        </label>\
                    </div>\
                </div>');
            break;
        case 'telephoneNAfficheRien':
            effacer();
            $("#afficheur2").html('\
                <div class="radiogroup">\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre3" id="telephoneNAfficheRienLEcranEstCasse" value="telephoneNAfficheRienLEcranEstCasse">\
                        <label class="label" for="telephoneNAfficheRienLEcranEstCasse">\
                        <div class="indicator"></div>\
                        <span class="text">L\'écran est cassé</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre3" id="telephoneNAfficheRienAutre" value="telephoneNAfficheRienAutre">\
                        <label class="label" for="telephoneNAfficheRienAutre">\
                        <div class="indicator"></div>\
                        <span class="text">Autre</span>\
                        </label>\
                    </div>\
                </div>');
          break;
        case 'ordinateurFixeAVuSesPerformancesDiminuer':
            effacer();
            $("#afficheur2").html('\
                <div class="radiogroup">\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre3" id="ordinateurFixeAVuSesPerformancesDiminuerEstInfecte" value="ordinateurFixeAVuSesPerformancesDiminuerEstInfecte">\
                        <label class="label" for="ordinateurFixeAVuSesPerformancesDiminuerEstInfecte">\
                        <div class="indicator"></div>\
                        <span class="text">Est infecté</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre3" id="ordinateurFixeAVuSesPerformancesDiminuerAutre" value="ordinateurFixeAVuSesPerformancesDiminuerAutre">\
                        <label class="label" for="ordinateurFixeAVuSesPerformancesDiminuerAutre">\
                        <div class="indicator"></div>\
                        <span class="text">Autre</span>\
                        </label>\
                    </div>\
                </div>');
            break;
        case 'tabletteAVuSesPerformancesDiminuer':
            effacer();
            $("#afficheur2").html('\
                <div class="radiogroup">\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre3" id="tabletteAVuSesPerformancesDiminuerEstInfecte" value="tabletteAVuSesPerformancesDiminuerEstInfecte">\
                        <label class="label" for="tabletteAVuSesPerformancesDiminuerEstInfecte">\
                        <div class="indicator"></div>\
                        <span class="text">Est infecté</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre3" id="tabletteAVuSesPerformancesDiminuerAutre" value="tabletteAVuSesPerformancesDiminuerAutre">\
                        <label class="label" for="tabletteAVuSesPerformancesDiminuerAutre">\
                        <div class="indicator"></div>\
                        <span class="text">Autre</span>\
                        </label>\
                    </div>\
                </div>');
            break;
        case 'tabletteNAfficheRien':
            effacer();
            $("#afficheur2").html('\
                <div class="radiogroup">\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre3" id="tabletteNAfficheRienLEcranEstCasse" value="tabletteNAfficheRienLEcranEstCasse">\
                        <label class="label" for="tabletteNAfficheRienLEcranEstCasse">\
                        <div class="indicator"></div>\
                        <span class="text">L\'écran est cassé</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre3" id="tabletteNAfficheRienAutre" value="tabletteNAfficheRienAutre">\
                        <label class="label" for="tabletteNAfficheRienAutre">\
                        <div class="indicator"></div>\
                        <span class="text">Autre</span>\
                        </label>\
                    </div>\
                </div>');
            break;
        case 'ordinateurPortableAVuSesPerformancesDiminuer':
            effacer();
            $("#afficheur2").html('\
                <div class="radiogroup">\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre3" id="ordinateurPortableAVuSesPerformancesDiminuerEstInfecte" value="ordinateurPortableAVuSesPerformancesDiminuerEstInfecte">\
                        <label class="label" for="ordinateurPortableAVuSesPerformancesDiminuerEstInfecte">\
                        <div class="indicator"></div>\
                        <span class="text">Est infecté</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre3" id="ordinateurPortableAVuSesPerformancesDiminuerAutre" value="ordinateurPortableAVuSesPerformancesDiminuerAutre">\
                        <label class="label" for="ordinateurPortableAVuSesPerformancesDiminuerAutre">\
                        <div class="indicator"></div>\
                        <span class="text">Autre</span>\
                        </label>\
                    </div>\
                </div>');
            break;
        case 'ordinateurPortableNAfficheRien':
            effacer();
            $("#afficheur2").html('\
                <div class="radiogroup">\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre3" id="ordinateurPortableNAfficheRienLEcranEstCasse" value="ordinateurPortableNAfficheRienLEcranEstCasse">\
                        <label class="label" for="ordinateurPortableNAfficheRienLEcranEstCasse">\
                        <div class="indicator"></div>\
                        <span class="text">L\'écran est cassé</span>\
                        </label>\
                    </div>\
                    <div class="wrapper">\
                        <input class="state" type="radio" name="gendre3" id="ordinateurPortableNAfficheRienAutre" value="ordinateurPortableNAfficheRienAutre">\
                        <label class="label" for="ordinateurPortableNAfficheRienAutre">\
                        <div class="indicator"></div>\
                        <span class="text">Autre</span>\
                        </label>\
                    </div>\
                </div>');
            break;
        case 'telephoneNeDemarrePas':
        case 'telephoneNeChargePas':
        case 'telephoneNemetPlusDeSons':
        case 'ordinateurFixeNeDemarrePas':
        case 'ordinateurFixeNAfficheRien':
        case 'tabletteNeDemarrePas':
        case 'tabletteNemetPlusDeSons':
        case 'tabletteNeChargePas':
        case 'ordinateurPortableNeDemarrePas':
        case 'ordinateurPortableNeChargePas':
        case 'ordinateurPortableNemetPlusDeSons':
        case 'imprimanteMauvaiseCouleurs':
        case 'imprimanteNAcceptePlusLesCartouchesDEncre':
        case 'imprimanteEstBourre':
        case 'imprimanteNeFonctionnePLus':
            effacer();
        default:
            $("#afficheur3").html('\
            <br>\
            <input type="submit" class="btn btn-primary btn-lg btn-block" value="Valider">');
            break;
    }
    $(".state").off("change");
    $(".state").on("change", afficher);
}
function effacertout()
{
    $("#afficheur1, #afficheur2, #afficheur3").html("");
}

function effacer()
{
    $("#afficheur2, #afficheur3").html("");
}
