$mt(document).ready(function() {

//Quick Quote Form
 $mt('.quick-quote').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'fa fa-check-circle-o',
			invalid: 'fafa-exclamation-triangle',
			validating: 'fa fa-spinner'
        },
        
                
        submitHandler: function(validator, form, submitButton) {  
        
        //grab all form data  
   var formData = new FormData($mt(form)[0]);
                   
            $mt.ajax({
                type: "POST",
                url: "/custom_db_processors/custom-functions-vs.php",
                data: formData,
               //data: form.serialize(),               
                async: false,
             cache: false,
             contentType: false,
             processData: false,
                 success: function(data){
			  //if(data.success == 'y') //Get the json respons from the script for success action
                       // {   
                            $mt('.quick-quote').html("<h3>Thank You!</h3><p>A member of our sales team will be in contact with you shortly.</p>");
							$mt("#form-submit").hide();
							
                        //}  
                        //else  
                        //{  
                        //   $mt("#popupDialogError").popup("open");
                        //}  
        },
			error: function (){    
        }  

            });
        },
        fields: {
            // ... Field options ...
             name: {
                message: 'Please enter your name',
                validators: {
                    notEmpty: {
                        message: 'Please enter your name'
                    },
                    //stringLength: {
                     //   min: 6,
                    //    max: 30,
                    //    message: 'The username must be more than 6 and less than 30 characters long'
                   // },
                   // regexp: {
                    //    regexp: /^[a-zA-Z0-9_]+$/,
                    //    message: 'The username can only consist of alphabetical, number and underscore'
                    //}
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email is required and cannot be empty'
                    },
                    emailAddress: {
                        message: 'Please enter a valid email address'
                    }
                }
                
            },  

        }
    });





// Bootstrap3 Link to tab
var hash = document.location.hash;
var prefix = "tab_";
if (hash) {
    $mt('.nav-tabs a[href='+hash.replace(prefix,"")+']').tab('show');
} 

// Change hash for page-reload
$mt('.nav-tabs a').on('shown', function (e) {
    window.location.hash = e.target.hash.replace("#", "#" + prefix);
});// Bootstrap3 Link to tab End


//Nav Image swaps
$mt('a.link-image').hover(
    function() {
        $mt('.imageDisplay').children().remove();
        $mt('<img class="img-responsive lazy" src="https://www.instantawnings.co.uk/media/nav-images/' + $mt(this).attr('data-imgsource') + '.png' + '" alt="" />')
           .appendTo( '.imageDisplay' );
    },
    function() {
        $mt('.imageDisplay').children().remove();
        $mt('<img class="img-responsive lazy" src="https://www.instantawnings.co.uk/media/nav-images/' + $mt(this).attr('data-imgdefault') + '.png' + '" alt="" />').appendTo( '.imageDisplay' );
    }
);            
//Nav Image swaps Ends            
            
            
 }); //End Document Ready

