//var speech = JSON.parse(speech_str);
var count = speech_str.length;
for(var i=0;i<count;i++){
  var picto = $("<div></div>");
  $(picto).addClass("pictogram");
  $(picto).attr('data-pic-id',speech_str[i]['id']);
  $(picto).attr('data-nl-NL',speech_str[i]['nl-NL']);
  $(picto).attr('data-en-GB',speech_str[i]['en-GB']);
  $(picto).attr('data-audible-nl-NL',speech_str[i]['audible-nl-NL']);
  $(picto).attr('data-audible-en-GB',speech_str[i]['audible-en-GB']);
  $(picto).attr('data-audible',speech_str[i]['audible-en-GB']);
  
  $(picto).append("<img src=\"" + speech_str[i]['img'] + '" alt="' + speech_str[i]['en-GB'] + '">');
  $(picto).append("<p>"+speech_str[i]['en-GB']+"</p>");
  
  $("#input-field").append(picto);
};


