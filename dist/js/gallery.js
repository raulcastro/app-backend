$(document).ready(function(){
	initGalleryScripts();
});

function initGalleryScripts()
{
	$('.update-photo').click(function(){
		var photoId = $(this).attr('photo-id');
		updatePhotoData(photoId);
	});
	
	$('.delete-photo').click(function(){
		var photoId = $(this).attr('photo-id');
		bootbox.confirm("Are you sure you want to delete this photo?", function(result){ 
				if (result)
					deletePhoto(photoId);
			}
		);
	});
}

function updatePhotoData(photoId)
{
	caption 	= $('#pId-'+photoId+'-caption').val();
	
    $.ajax({
        type:   'POST',
        url:    '/ajax/media.php',
        data:{  photoId: photoId,
                caption: caption,
                section: 'update-photo'
             },
        success:
        function(xml)
        {
        		if (0 != xml)
            {
	            	bootbox.alert({
	            	    message: "The info has been succesfully updated! =)",
	            	    size: 'small',
	            	    backdrop: true
	            	});
            }
        }
    });
}

function deletePhoto(photoId)
{
    $.ajax({
        type:   'POST',
        url:    '/ajax/media.php',
        data:{  
        			photoId: photoId,
                section: 'delete-photo'
             },
        success:
        function(xml)
        {
            if ('1' == xml)
            {
            		$('#photo-'+photoId).fadeOut();
            }
        }
    });
}

function getGallery()
{
    $.ajax({
        type:   'POST',
        url:    '/ajax/media.php',
        data:{  
                section: 'get-gallery'
             },
        success:
        function(xml)
        {
            if (0 != xml)
            {
            		$('#gallery-container').html(xml);
            		initGalleryScripts();
            }
        }
    });
}