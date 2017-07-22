
$(".delete").click(function(){
        var speech_row = $(this).parent(".speech-row");
        var speech = $(this).prev(".speech");
        var id = $(speech).attr('data-speech');
        
        $.get('php/deletespeech.php','id='+id,function(){
            $(speech_row).remove();
        });
});


