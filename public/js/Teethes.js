    $(function(){
        var start ='';
        var Elemaent = [];
        $('.up,.down').on('click',function(e){
            var Classname = $(this).attr('data-title');
            var ElIndex = $(this).attr('data-index');
            var Inputs = $("#Teethes").val();

            if($(this).hasClass('selectTeeth')) {
                // Remove Tooth from Array
                $(this).removeClass('selectTeeth');
                var result = $("#Teethes").val().split('|');
                var newInput = '';
                var i = 0;
                for( i; i < result.length; i++){
                    if(result[i] != Classname){ newInput += '|'+result[i]; }
                }
                $("#Teethes").val(newInput);



                const index = Elemaent.indexOf(ElIndex);
                if (index > -1) {
                    Elemaent.splice(index, 1);
                }

            }else {
                // Add Tooth To Array
                $(this).addClass('selectTeeth');
                start +=  '|'+Classname;
                $("#Teethes").val(start);
                Elemaent.push(ElIndex);
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
