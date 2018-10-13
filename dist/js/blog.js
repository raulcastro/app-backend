$(document).ready(function()
{
	$('.update-entry').click(function(){
		updateEntry();
	});
	
	$('.delete-post').click(function(){
		var postId = $(this).attr('post-id');
		bootbox.confirm("Are you sure you want to delete this photo?", function(result){ 
				if (result)
					deletePost(postId);
			}
		);
	});
	
	$('.delete-photo').click(function(){
		var photoId = $(this).attr('photo-id');
		bootbox.confirm("Are you sure you want to delete this photo?", function(result){ 
				if (result)
					deletePhoto(photoId);
			}
		);
	});
});

function updateEntry()
{
	entryId             = $('#entryId').val();
	entryTitle          = $('#entryTitle').val();
	entryPreview        = $('#entryPreview').val();
	entryDescription    = $('#entryDescription').val();
	category            = $('#category').val();
        featured            = $('#featuredSelect').val();
	postDate            = $('#postDate').val();
	
	$.ajax({
        type:   'POST',
        url:    '/ajax/blog.php',
        data:{  
                entryId:            entryId,
                entryTitle:         entryTitle,
                entryPreview:       entryPreview,
                entryDescription:   entryDescription,
                category:           category,
                featured:           featured,
                postDate:           postDate,
                section:            'update'
             },
        success:
        function(xml)
        {
            if (0 != xml)
            {
            	bootbox.alert({
            	    message: "The entry info has been updated successfully",
            	    size: 'small',
            	    backdrop: true
            	});
            }
        }
    });
}

function getPhotoEntry()
{
	entryId			= $('#entryId').val();
	
    $.ajax({
        type:   'POST',
        url:    '/ajax/media.php',
        data:{ 
        			entryId: entryId,
                section: 'get-photo-entry'
             },
        success:
        function(xml)
        {
            if (0 != xml)
            {
            		$('#photoContainer').html(xml);
            }
        }
    });
}

function deletePost(postId)
{
    $.ajax({
        type:   'POST',
        url:    '/ajax/blog.php',
        data:{  
        			postId: postId,
                section: 'delete-post'
             },
        success:
        function(xml)
        {
            if ('1' == xml)
            {
            		$('#post-'+postId).fadeOut();
            }
        }
    });
}

function getGallery()
{
	postId = $('#entryId').val();
    $.ajax({
        type:   'POST',
        url:    '/ajax/media.php',
        data:{  
                section: 'get-gallery',
                postId: postId
             },
        success:
        function(xml)
        {
            if (0 != xml)
            {
            		$('#gallery-container').html(xml);
            		$('.delete-photo').click(function(){
            			var photoId = $(this).attr('photo-id');
            			bootbox.confirm("Are you sure you want to delete this photo?", function(result){ 
            					if (result)
            						deletePhoto(photoId);
            				}
            			);
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