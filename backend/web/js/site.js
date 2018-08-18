/*
$('.modal').on('show.bs.modal', function () {
    $('.modal').not($(this)).each(function () {
        alert('a');
        $(this).modal('hide');
    });
});

$('.modal').on('shown.bs.modal', function () {
    $('body').addClass('modal-open'); // this fixes the scrolling issue when modal windows are opened in series
});
*/

$(document).on("show.bs.modal", ".modal", function(e){
    $('.modal').not($(this)).each(function () {
        $(this).modal('hide');
    });
});

$(document).on("shown.bs.modal", ".modal", function(e){
    $('body').addClass('modal-open'); // this fixes the scrolling issue when modal windows are opened in series
});

$(document).on("click", ".modal-md-link", function(e){
	e.preventDefault();

    var loading = 'Loading content...';
	var title = typeof $(this).attr('alt') != 'undefined' ? $(this).attr('alt') : '';

	$("#modal-md-header-title").html("<h4>"+title+"</h4>");
    $("#modal-md-content").html(loading);
    $("#modal-md").modal('show');
    $("#modal-md-content").load($(this).attr('href'));

	return false;
});

// modal-lg - link

$(document).on("click", ".modal-lg-link", function(e){
	e.preventDefault();

	var loading = 'Loading content...';
	var title = typeof $(this).attr('alt') != 'undefined' ? $(this).attr('alt') : '';

	$("#modal-lg-header-title").html("<h4>"+title+"</h4>");
	$("#modal-lg-content").html(loading);
	$("#modal-lg").modal('show');
	$("#modal-lg-content").load($(this).attr('href'));

	return false;
});

// Wizard Tabs 
$('.nav-tabs > li.active').prevAll().addClass('done');

// modal-lg - button

// field protector - start

$(document).ready(function(){

	$('.protected-form').areYouSure(
	  {
	    message: 'It looks like you have been editing something. '
	           + 'If you leave before saving, your changes will be lost.'
	  }
	);

});

// field protector - end

// dropdown menu - start

$(document).on("click", ".dropdown-trigger", function(e){

	var dropdown = $(this).attr('alt');

	$("#"+dropdown).toggleClass('open');

});

// dropdown menu - end

$(document).on('click', function(e){
    if(!$('.dropdown').is(e.target) 
        && $('.dropdown').has(e.target).length === 0 
        && $('.open').has(e.target).length === 0
    ){
        // $('.dropdown').removeClass('open'); // comment this out if auto-close on outside click is desired
    }
});

// croppie - start

function croppieReadFile(input, height, width){

	if(input.files && input.files[0]){
    
        var reader = new FileReader();
        
        reader.onload = function(e){

			$('#croppie_upload_container').croppie({
                            enableExif: true,
                            viewport: {
                                width: width,
                                height: height,
                                type: 'rectangle'
                            },
                            boundary: {
                                width: width+20,
                                height: height+20
                            },
                            showZoomer: true,
                            enableOrientation: true,
                            url: e.target.result
                        }
                    );

        }
        
        reader.readAsDataURL(input.files[0]);

    }
    else {

        swal("Sorry - you're browser doesn't support the FileReader API");

    }
}

function croppiePhase1(){
// phase 1

	$('#croppie_upload_container').croppie('destroy');
	$("#croppie_current_img_container").show();
	$("#croppie_current_img_remove_container").show();
	$("#croppie_upload_container").hide();
	$("#croppie_control_buttons_container").hide();


}

function croppiePhase2(input, height, width){
// phase 2

	$('#croppie_upload_container').croppie('destroy');
	$("#croppie_current_img_container").hide();
	$("#croppie_current_img_remove_container").hide();
	$("#croppie_upload_container").show();
	croppieReadFile(input, height, width);
	$("#croppie_control_buttons_container").show();

}

function userNotificationCount(url) {
    $.ajax({
        type:'GET',
        url:url,
        success:function(data) {
            if(data == 0){
                $("#request_approval_notification_count_val").removeClass("label label-primary");
                $("#request_approval_notification_count_val").text('');
            }else{
                $("#request_approval_notification_count_val").addClass("label label-primary");
                $("#request_approval_notification_count_val").text(data);
            }
        }
    });
}

$(document).on("change", "#croppie_upload_file", function(e){

    var height = $(this).data('height');
    var width = $(this).data('width');

	croppiePhase2(this, height, width);

});

$(document).on("click", "#croppie_upload_file_cancel", function(e){

	$("#croppie_current_img").attr("src", $("#croppie_default_img").attr("value"));
	$("#croppie_upload_file").val("");

	croppiePhase1();

});

function croppieSetResult(result){

	if(result.src){

		$("#croppie_current_img").attr("src", result.src);

	}

}

$(document).on("click", "#croppie_upload_file_set", function(e){

	$('#croppie_upload_container').croppie('result', {
				type: 'canvas',
				size: 'viewport',
				format: 'jpeg'
			}).then(function(resp){
				$('#img_upload_base64').val(resp);
				$("#croppie_current_img").attr("src", resp.src);
				croppieSetResult({
					src: resp
				});
				croppiePhase1();
			});

});

// croppie - end

$('body').on('click', '.disabled', function(e) {
    e.preventDefault();
    return false;
});

// Calendar
$(document).on('submit', '.fullcalendar-roster-form', function(e){
// case: update
	e.preventDefault(); // prevent form default action

    var form = $(this); // save a reference to the form in a variable
    var form_data = form.serialize();

    $.ajax({
        url: form.data('target'),
        data: form_data,
        type: 'POST',
        async: false,
        success: function (json) {


            if(json=='success')
            {
                var view=$('#calendar').fullCalendar('getView');
                var site_id=$('#select_site_id').val();

                $('#calendar').fullCalendar('removeEvents', function (calEvent) {
                    return true;
                });


                jQuery.ajax({
                    url: '/schedule/schedule?start='+view.start.format()+'&end='+view.end.format()+'&site_id='+site_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(events) {
                        $('#calendar').fullCalendar('refresh');
                        $('#calendar').fullCalendar( 'addEventSource', events);
                    }
                });
                $('#modal-md').modal('hide');
            }
        }
    });

    return false;
});

$(document).on('click', '.fullcalendar-delete-button', function(e){
// case: delete
	e.preventDefault(); // prevent button default action

	var event = $(this);

    $.ajax({
        url: event.data('target'),
        type: 'POST',
        async: false,
        success: function (json) {                            
            $('#modal-md').modal('hide');
            $('#calendar').fullCalendar('removeEvents', [event.data('id')]); // remove selected events only based on specified ID
        }
    });

    return false;
});

// Employment Details
$(document).ready(function() {
    $('#color1').colorPicker();
    var valColor = $('#user-color').val();
    $('.colorPicker-picker').css('background', valColor);
    $('.colorPicker-swatch').on('click', function() {
        $('#user-color').val($('#colorPicker_hex-0').val());
    });
});

// Scrolling for Timesheet
$(".table-responsive tbody").on("scroll",function(){
    $(".table-responsive tbody:not(this)").scrollTop($(this).scrollTop());
});
