 $('.dropify').dropify({
	messages: {
		'default': 'Upload image',
		'replace': 'Upload image',
		'remove': 'Remove',
		'error': 'Ooops, something wrong appended.'
	},
	error: {
		'fileSize': 'The file size is too big (2M max).'
	}
});
 $('.dropify1').dropify({
	messages: {
		'default': '<i class="fa fa-upload"></i> Upload Resume',
		'replace': '<i class="fa fa-upload"></i> Upload Resume'
	}
});

 var customDropify = $('.custom-dropify').dropify({
     messages: {
         'default': 'Upload image',
         'replace': 'Upload image',
         'remove': 'Remove',
         'error': 'Ooops, something wrong appended.'
     },
     error: {
         'fileSize': 'The file size is too big (2M max).'
     }
 });

 customDropify.on('dropify.beforeClear', function(event, element){

     var url = $(this).data('delete-url');

     const formData = {
         company_id: $(this).data('company-id'),
         name:  $(this).attr('name')
     };

     if (confirm("Do you really want to delete this image ?") === true){
         $.ajax({
             url: url,
             type: 'post',
             data: formData,
             success: function(response) {
                 if (response.error === false) {
                     toastr.success(response.message);
                 } else {
                     toastr.error(response.message);
                 }
                 window.location.reload();
             },
             error: function (response) {
                 toastr.error('Error while removing this file.');
                 window.location.reload();
             }
         });
     }
     return false;

 });

 $(".clear-image").on('click', function (e) {
     alert()
 })
