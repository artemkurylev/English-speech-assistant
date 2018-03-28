//���������� ����� ����������
/*var pictogram = $('<div class="pictogram" en-GB="hello" nl-NL="hallo" audible="hello"> <img src="img/picto/hello.png" alt="hello"> <p>hello</p> </div>');
 var category = $('<div class="pictogram category" en-GB="food" nl-NL="eten"> <img src="img/picto/food.png" alt="food"> <p>food</p> </div>');
 for (var i=0; i<5; i++){
 $("#picto-grid").append($(category).clone());
 }
 for (var i=0; i<10; i++){
 $("#picto-grid").append($(pictogram).clone());
 }*/
var current_language = "en-GB";
//$("#picto-grid").load("php/getcategories.php");

//������� ����������
var synth = window.speechSynthesis;
var utter = new SpeechSynthesisUtterance();
utter.lang = 'en-GB';
utter.text = 'hello';
var changeeOrder = false;

//���������� �� ����������
$("#picto-grid").click(function (event) {
    var cell = $(event.target).parents(".pictogram");
	var catId = 0;
    if ($(cell).hasClass("category")) {
        catId = $(cell).attr("data-category");

        $("#picto-grid").load("php/getpictograms.php", "category=" + $(cell).attr("data-category"), function () {
            $("#picto-grid .pictogram").each(function () {
                var txt = $(this).attr('data-' + current_language);
				
                $(this).children("p").text(txt);
                $(this).attr("data-audible", $(this).attr("data-audible-" + current_language));
				
            });
        });
    } else {
        var a = {};
        var txt = $(cell).attr('data-' + current_language);
        var changed_txt={};
        if(current_language == "en-GB"){
            changed_txt = prompt('Enter new text',txt);
            a['lang']="en-GB";
        }
        else {
            changed_txt = prompt('Voer nieuwe tekst in', txt);
            a['lang'] = "nl-NL";
        }
        if(changed_txt != null){
            a['text'] = changed_txt;
            a['id'] = cell[0].dataset.picId;
            $.post("php/savenewtext.php",a);
            location.reload();
            $("#picto-grid").load("php/getpictograms.php", "category=" + catId, function () {
                $("#picto-grid .pictogram").each(function () {
                    var txt = $(this).attr('data-' + current_language);
                    $(this).children("p").text(txt);
                    $(this).attr("data-audible", $(this).attr("data-audible-" + current_language));

                });
            });
        }



        //$("#input-field").append(cell.clone());
    }
});

//�������� ���������� �������
$("#delete").click(function () {
    $("#input-field").children().last().remove();
});

//������� ������
$("#newline").click(function () {
    $("#input-field").append($("<br/>"));
});

//������ "�����"
$("#home").click(function () {
    $("#picto-grid").load("php/getcategories.php", "", function () {
        $("#picto-grid .pictogram").each(function () {
            var txt = $(this).attr('data-' + current_language);
            $(this).children("p").text(txt);
			
        });
    });
});

//����� �����
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

//������� ����������
$("#input-field").click(function (event) {
        var picto = $(event.target).parents(".pictogram");
        if (picto.hasClass("pictogram")) {
            var rate = utter.rate;
            var newrate = 0;
            newrate = prompt("Enter new rate",rate);
            utter.rate = newrate;
        }
});


//���������� ����
$("#save").click(function () {
    //serialize speech
    var speech = {};
    if (speech_id >= 0) {
        speech['speech_id'] = speech_id;
    }
    var speech_text = [];
    $("#input-field .pictogram").each(function () {
        var pictogram = $(this);
        var picto_object = {};
        picto_object['id'] = pictogram.attr('data-pic-id');
        picto_object['nl-NL'] = pictogram.attr('data-nl-NL');
        picto_object['en-GB'] = pictogram.attr('data-en-GB');
        picto_object['audible-nl-NL'] = pictogram.attr('data-audible-nl-NL');
        picto_object['audible-en-GB'] = pictogram.attr('data-audible-en-GB');
        picto_object['img'] = pictogram.children("img").first().attr('src');
        speech_text.push(picto_object);
    });
    var name = [];
    for (var i = 0; i < Math.min(6, speech_text.length); i++) {
        name.push(speech_text[i]['id']);
    }
    
    speech['name'] = JSON.stringify(name).slice(1,-1);
    speech['speech_text'] = JSON.stringify(speech_text);

    //save speech
    $.post("php/savespeech.php", speech, function(result){
        speech_id = result.slice(result.indexOf('>>>')+3);
    });
});