//заполнение сетки пиктограмм
/*var pictogram = $('<div class="pictogram" en-GB="hello" nl-NL="hallo" audible="hello"> <img src="img/picto/hello.png" alt="hello"> <p>hello</p> </div>');
 var category = $('<div class="pictogram category" en-GB="food" nl-NL="eten"> <img src="img/picto/food.png" alt="food"> <p>food</p> </div>');
 for (var i=0; i<5; i++){
 $("#picto-grid").append($(category).clone());
 }
 for (var i=0; i<10; i++){
 $("#picto-grid").append($(pictogram).clone());
 }*/
var current_language = "en-GB";
$("#picto-grid").load("php/getcategories.php");

//озвучка пиктограмм
var synth = window.speechSynthesis;
var utter = new SpeechSynthesisUtterance();
utter.lang = 'en-GB';
utter.text = 'hello';

//обработчик на клавиатуре
$("#picto-grid").click(function (event) {
    var cell = $(event.target).parents(".pictogram");
    if ($(cell).hasClass("category")) {
        $("#picto-grid").load("php/getpictograms.php", "category=" + $(cell).attr("data-category"), function () {
            $("#picto-grid .pictogram").each(function () {
                var txt = $(this).attr('data-' + current_language);
                $(this).children("p").text(txt);
                $(this).attr("data-audible", $(this).attr("data-audible-" + current_language));
            });
        });
    } else {
        $("#input-field").append(cell.clone());
    }
});

//удаление последнего символа
$("#delete").click(function () {
    $("#input-field").children().last().remove();
});

//перевод строки
$("#newline").click(function () {
    $("#input-field").append($("<br/>"));
});

//кнопка "домой"
$("#home").click(function () {
    $("#picto-grid").load("php/getcategories.php", "", function () {
        $("#picto-grid .pictogram").each(function () {
            var txt = $(this).attr('data-' + current_language);
            $(this).children("p").text(txt);
        });
    });
});

//смена языка
$("#language-panel").click(function (event) {
    if ($(event.target).hasClass("language")) {
        $(".language").each(function () {
            if (this === event.target) {
                $(this).addClass("active-language");
                current_language = $(this).attr("alt");
                $(".pictogram").each(function () {
                    //var txt = $(this).attr(current_language);
                    $(this).children("p").text($(this).attr('data-' + current_language));
                    if (!$(this).hasClass("category")) {
                        $(this).attr("data-audible", $(this).attr("data-audible-" + current_language));
                    }
                });
                utter.lang = current_language;
            } else {
                $(this).removeClass("active-language");
            }
        });
    }
});

//озвучка пиктограмм
$("#input-field").click(function (event) {
    var picto = $(event.target).parents(".pictogram");
    if (picto.hasClass("pictogram")) {
        utter.text = picto.attr("data-audible");
        synth.speak(utter);
    }
});

function serializeSpeech(speech) {
    return "";
}

//сохранение речи
$("#save").click(function () {
    //serialize speech
    var speech = {};
    if (speech_id >= 0) {
        speech['speech_id'] = speech_id;
    }
    var speech = [];
    $("#input-field .pictogram").each(function () {
        var pictogram = $(this);
        var picto_object = {};
        picto_object['id'] = pictogram.attr('data-pic-id');
        picto_object['nl-NL'] = pictogram.attr('data-nl-NL');
        picto_object['en-GB'] = pictogram.attr('data-en-GB');
        picto_object['audible-nl-NL'] = pictogram.attr('data-audible-nl-NL');
        picto_object['audible-en-GB'] = pictogram.attr('data-audible-en-GB');
        speech.push(picto_object);
    });
    var name = [];
    for (var i = 0; i < Math.min(6, speech.length); i++) {
        name.puch(speech[i]['id']);
    }
    speech_string = serializeSpeech();

    //save speech
    $.post("php/savespeech.php", speech);
});

