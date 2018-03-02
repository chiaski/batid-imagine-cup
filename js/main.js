


// this is a mess. //





// PURE AESTHETIC //


        $(".header-icon").click(function(){
            if( $(".batid-dropdown").css('bottom') == "0px") {
                $(".batid-dropdown").css("bottom", "-1000px");
            } else{
                $(".batid-dropdown").css("bottom", "00px");
            }
        });  
        

// FAKE INTRO SCENE
        
        $(this).on('keypress', function(event) {
            if (event.keyCode == 13) {
                $(".intro-one").fadeIn('fast').delay(5000).fadeOut('slow');
                $(".intro-two").hide().delay(5300).fadeIn('slow');
            }
        });



// FUNCTIONALITIES //

// form validation

function validate() {
    if($('#title').val() == "") {
        alert("What happened? Make it short and concise.");
        return false;
    }
                
    if($('#report-desc').val().length < 10) {
        alert("Please describe the incident more.");
        return false;
    }

    if($('input[type=radio][name=severity]:checked').val() == undefined) {
        alert("Please select a severity.\nYou may refer to the severity ranking chart.");
        return false;
    }
                
    if($('#name').val() == "") {
        alert("What is your name?");
    }

    return true;
                
}


// view feed

function viewFeed(){
    if( $(".batid-feed").css('left') == "0px") {
        $(".batid-feed").css("left", "-600px");
    } else{
        $(".batid-feed").css("left", "00px");
    }
}
        

function showSeverity(severity){
    $(".batid-severity-show").text(severity);
}
                                
function showVal(newVal){
    $(".batid-radius-show").text(newVal);
}

// fades


var report_popup = $('#report-form');
                    
$("#report-form-close").click(function() {
    $(".batid-report").fadeOut("fast");
    $("#report").fadeOut("fast");
});
                
                    
$(".batid-report-behind").click(function() {
    $(".batid-report").fadeOut("slow");
    $(".batid-report-behind").fadeOut("slow");
});

