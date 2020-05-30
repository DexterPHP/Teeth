    $(function(){
        var start ='';
        var Elemaent = [];
        var Tooth = [];
        var i = 0;
        $('.up,.down').on('click',function(e){
            var Classname = $(this).attr('data-title');
            var ElIndex = $(this).attr('data-index');
            var Inputs = $("#Teethes").val();

            if($(this).hasClass('selectTeeth')) {
                // Remove Tooth from Array
                $(this).removeClass('selectTeeth');
                const index = Elemaent.indexOf(ElIndex);
                const text = Tooth.indexOf(ElIndex);
                if (index > -1) {
                    Elemaent.splice(index, 1);
                    Tooth.splice(text, 1);
                }
            }else {
                // Add Tooth To Array
                $(this).addClass('selectTeeth');
                Elemaent.push(ElIndex); // Add Tooth Index
                Tooth.push(Classname); // Add Tooth Name
            }
            if(Elemaent.length > 0){
                $("#Teethes").val(Tooth);
            }

        });
        // Open and Close Tooth Diagram
        $('.closeTooth').on('click',function(){$('#teeth').fadeOut(700); });
        $('#Teethes').on('click',function(){$('#teeth').fadeIn(700); });


    });

$(document).on( 'keydown', function ( e ) {
    if (e.keyCode === 27) { // ESC
        $('#teeth').fadeOut(700);
    }
});



