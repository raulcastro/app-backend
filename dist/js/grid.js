$(document).ready(function()
{
	var categoryId 	= $('#categoryId').val();
	var category 	= $('#category').val();
	
	$(".banner-uploader").uploadFile({
		url:"/ajax/categories-media.php?option=1",
		fileName:	"myfile",
		multiple: 	false,
		doneStr:		"Logo añadido correctamente",
		formData: {
			"categoryId":	categoryId,
			"categoryName": category
			},
		onSuccess:function(files, data, xhr)
		{
			obj 		= JSON.parse(data);
			widthLogo 	= obj.wp;
			heightLogo 	= obj.hp;
			imageLogo 	= obj.fileName;
			lastIdLogo 	= obj.lastId;
			
			var source = '/media/categories/banners-md/'+obj.fileName;
			$('#categoryBanner').attr('src', source);
		}
	});
	
	$('#updateCategory').click(function(){
		updateCategory();
		return false;
	});
	
	function updateCategory()
	{
		var cDescription	= $('#cDescription').val();
		var cUrl 			= $('#cUrl').val();
		var cPhoneOne 		= $('#cPhoneOne').val();
		var cPhoneTwo 		= $('#cPhoneTwo').val();
		var cEmail 			= $('#cEmail').val();
		var cAddress 		= $('#cAddress').val();
		var cCoord 			= $('#cCoord').val();
		var cFacebook 		= $('#cFacebook').val();
		var cTwitter 		= $('#cTwitter').val();
		var cInstagram 		= $('#cInstagram').val();
		
		categoryLocation 		= $('#cCoord').val();
		locationArray 			= categoryLocation.split(",");
		companyLatitude 		= locationArray[0];
		companyLongitude		= locationArray[1];
		
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/categories.php',
	        data:{  categoryId: 	categoryId,
	        	cDescription: 		cDescription,
	        	cUrl: 				cUrl,
	        	cPhoneOne: 			cPhoneOne,
	        	cPhoneTwo: 			cPhoneTwo,
	        	cEmail: 			cEmail,
	        	cAddress: 			cAddress,
	        	cFacebook: 			cFacebook,
	        	cTwitter: 			cTwitter,
	        	cInstagram: 		cInstagram,
	        	companyLatitude: 	companyLatitude,
	        	companyLongitude: 	companyLongitude,
	            option: 			6
	             },
	        success:
	        function(xml)
	        {
	            if (0 != xml)
	            {
	            	bootbox.alert({
	            	    message: "La información se ha actualizado correctamente",
	            	    size: 'small',
	            	    backdrop: true
	            	});
	            }
	        }
	    });
	}
});