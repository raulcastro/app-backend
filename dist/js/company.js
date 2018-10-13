$(document).ready(function()
{
	$('.save-company-info').click(function(){
		saveInfo();
	});
	
	$('.save-company-seo').click(function(){
		saveSeo();
		return false;
	});
	
	$('.save-company-social').click(function(){
		saveSocial();
		return false;
	});

	$('.delete-activity').click(function(){
		deleteActivity();
		return false;
	});
	
	$('.save-company-contact').click(function(){
		saveEmails();
		savePhones();
		updateCompany();
		return false;
	});
	
	$('#addVideo').click(function(){
		addVideo();
		return false;
	});
	
	$('#mainPromoteCompany').click(function(){
		mainPromoteCompany();
	});
	
	$('#promoteCompany').click(function(){
		promoteCompany();
	});
	
	$('#publish-company').click(function(){
		publishCompany();
	});
	
	$('#asociateEvent').click(function(){
		associateEvent();
		return false;
	});
	
	$('#close-company').click(function(){
		closeCompany();
	});
	
	$('#create-company').click(function(){
		createCompany();
		return false;
	});
	
	$('#addEvent').click(function(){
		addEvent();
		return false;
	});
	
	$('.deleteEvent').click(function(){
		deleteEvent(this);
		return false;
	});
	
	
	$('#addEmailField').click(function(){
		emailField = '<div class="form-group"><label class="col-sm-1 control-label">Email</label>'
			+'<div class="col-sm-11"><input type="text" value="" class="companyEmail form-control" eid="0" /></div>'
			+'</div>';
		$('#companyEmails').append(emailField);
	});
	
	$('#addPhoneField').click(function(){
		phoneField = '<div class="form-group"><label class="col-sm-1 control-label">Phone</label>'
			+'<div class="col-sm-11"><input type="text" value="" class="companyPhone form-control" pid="0" /></div>'
			+'</div>';
		$('#companyPhones').append(phoneField);
	});
	
//	Logo uploader
	companyId 	= $('#companyId').val();
	companyName = $('#companyNameClean').val();
	widthLogo 	= 0;
	heightLogo 	= 0;
	imageLogo	= "";
	xLogo		= 0;
	yLogo		= 0;
	lastIdLogo 	= 0;
	
	var 			dncLogo;
	
	if ($('#logoId').val() > 0)
		lastIdLogo = $('#logoId').val();
	
	$(".logo-uploader").uploadFile({
		url:"/ajax/company-media-logo.php?option=1",
		fileName:	"myfile",
		multiple: 	false,
		doneStr:	"logo uploaded!",
		formData: {
			"lastIdLogo":	lastIdLogo, 
			"companyId":	companyId, 
			"companyName": 	companyName
			},
		onSuccess:function(files, data, xhr)
		{
			obj 		= JSON.parse(data);
			widthLogo 	= obj.wp;
			heightLogo 	= obj.hp;
			imageLogo 	= obj.fileName;
			lastIdLogo 	= obj.lastId;
			if (dncLogo){dncLogo.dragncrop('destroy');}
			
			createDncLogo(obj.fileName);
			
			$('.logo-box').show();
			$('#save-crop-logo').show();
		}
	});
	
	function createDncLogo(image)
	{
		source = '/media/companies/medium/'+image;
		$('#cropLogo').attr('src', source);
		dncLogo = $('#cropLogo').dragncrop({
			instruction: 	false,
			centered: 		false,
			stop: function(event, position){
			   	dimensions 	= String(position.dimension);
			   	res 		= dimensions.split(",");
			   	xLogo 		= res[0];
			   	yLogo 		= res[1];
			  }
        });
	}
	
	$('#save-crop-logo').click(function(){
		saveLogoCrop(xLogo, yLogo, imageLogo);
		return false;
	});
	
//	Slider uploader
	widthSlider 	= 0;
	heighSlider 	= 0;
	imageSlider		= "";
	xSlider			= 0;
	ySlider			= 0;
	lastIdSlider 	= 0;
	var dncSlider;
	
	$(".company-slider-uploader").uploadFile({
		url:			"/ajax/company-media-sliders.php?option=1",
		fileName:	"myfile",
		multiple: 	false,
		doneStr:		"uploaded!",
		formData: 
			{
				"companyId":companyId, 
				"companyName": companyName
			},
		onSuccess:function(files, data, xhr)
		{
			obj 				= JSON.parse(data);
			widthSlider 		= obj.wp;
			heighSlider 		= obj.hp;
			imageSlider 		= obj.fileName;
			lastIdSlider 	= obj.lastId;
			
			if (dncSlider){dncSlider.dragncrop('destroy');}
			
			createDncSlider(obj.fileName);
			$('.company-slider-upload').show();
			$('#save-crop-company-slider').show();
		}
	});
	
	function createDncSlider(image)
	{
		source = '/media/companies/medium-sliders/'+image;
		$('#crop-company-slider').attr('src', source);
		dncSlider = $('#crop-company-slider').dragncrop({
			instruction: false,
			centered: false,
			stop: function(event, position){
			   	dimensions 	= String(position.dimension);
			   	res 		= dimensions.split(",");
			   	xSlider 	= res[0];
			   	ySlider 	= res[1];
			  }
        });
	}
	
	$('#save-crop-company-slider').click(function(){
		saveSliderCrop(xSlider, ySlider, imageSlider, lastIdSlider);
//		dncLogo.dragncrop('destroy');	
		return false;
	});
	
	$('.delete-slider').click(function(){
    	deleteCompanySlider($(this).attr('sid'));
		return false;
    });
	
	$('.deleteGallery').click(function(){
    	deleteCompanyGallery($(this).attr('cgid'));
		return false;
    });
	
	
//	Slider uploader
	imageGallery	= "";
	lastIdGallery 	= 0;
	
	$(".company-gallery-uploader").uploadFile({
		url:"/ajax/company-media-gallery.php?option=1",
		fileName:	"myfile",
		multiple: 	true,
		doneStr:	"uploaded!",
		formData: {
			"companyId":	companyId, 
			"companyName": 	companyName},
		onSuccess:function(files, data, xhr)
		{
			obj 			= JSON.parse(data);
			imageGallery 	= obj.fileName;
			lastIdGallery 	= obj.lastId;
			
			itemGallery = '<div class="image-box" id="cgid-'+lastIdGallery+'">'
			+'<div class="image">'
			+'<img src="/media/companies/gallery/'+imageGallery+'" />' 
			+'</div>'
			+'<a href="javascript:void(0);" cgid="'+lastIdGallery+'" class="deleteGallery" >delete</a>'
			+'</div>';
			
			$('.company-gallery-grid').prepend(itemGallery);
			
			$('.deleteGallery').click(function(){
		    	deleteCompanyGallery($(this).attr('cgid'));
				return false;
		    });
		}
	});
	
	
if ( $('#addDocument').length ) {
		$("#addDocument").uploadFile({
			url:		"/ajax/company-media-gallery.php",
			fileName:	"myfile",
			multiple: 	true,
			doneStr:	"uploaded!",
			formData: {
					option: 3 
				},
			onSuccess:function(files, data, xhr)
			{
				obj					= JSON.parse(data);
				documentUploaded	= obj.fileName;
				var documentNode = '<tr><td><a href="/media/documents/'+documentUploaded+'" target="_blank">'+documentUploaded+'</a></td></tr>';
				
				$('#paymentDocuments').append(documentNode);
				
				addDocument(companyId, documentUploaded);
			}
		});
	}
	
});//Document ready ends here!

function addDocument(companyId, documentUploaded)
{
	$.ajax({
	    type: "POST",
	    url: "/ajax/company.php",
	    data: {
	    	companyId:			companyId,
	    	documentUploaded:	documentUploaded,
	    	section:				'add-document'
	    },
	    success:
        function(info)
        {
        }
	});
	
	documentNotification(paymentId);
}

function getDocuments(paymentId)
{
	$.ajax({
	    type: "POST",
	    url: "/ajax/payments.php",
	    data: {
	    	paymentId: 			paymentId,
	    	opt:				8
	    },
	    success:
        function(info)
        {
	    	$('#paymentDocuments').html("");
	    	$('#paymentDocuments').html(info);
        }
	});
}

function addVideo()
{
	companyId	= $('#companyId').val();
	newVideo		= $('#newVideo').val(); 
	
	if (newVideo)
	{
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/company.php',
	        data:{  companyId: 	companyId,
	        	newVideo: newVideo,
	            section: 		'add-video'
	             },
	        success:
	        function(xml)
	        {
	            if (0 != xml)
	            {
	            	bootbox.alert({
	            	    message: "El video se ha añadido correctamente!",
	            	    size: 'small',
	            	    backdrop: true
	            	});
	            	$('#newVideo').val(""); 
	            	var documentNode = '<tr><td><a href="'+newVideo+'" target="_blank">'+newVideo+'</a></td></tr>'; // |<a href="/controllers/multimedia-controller.php?v=' + data.video_id + ' ?>&c=' + data.company_id + '" class="text-red">Eliminar</a>
					
					$('#videos').append(documentNode);
	            }
	        }
	    });
	}
	
}

function deleteCompanyGallery(pictureId)
{
    $.ajax({
        type:   'POST',
        url:    '/ajax/company-media-gallery.php?option=2',
        data:{  
        	pictureId: pictureId
             },
        success:
        function(xml)
        {
            if ('1' == xml)
            {
            	$('#cgid-'+pictureId).fadeOut();
            }
        }
    });
}

function saveSliderCrop(xSlider, ySlider, imgId, lastIdSlider)
{
    $.ajax({
        type:   'POST',
        url:    '/ajax/company-media-sliders.php?option=2',
        data:{  x: xSlider,
                y: ySlider,
            imgId: imgId
             },
        success:
        function(xml)
        {
            if (0 != xml)
            {
            	sliderItem = '<div class="slider-item col-md-4" id="sid-'+lastIdSlider+'">'
								+ '<header>'
								+ '<a href="#" class="button red delete-slider" sid="'+lastIdSlider+'">delete</a>'
								+ '</header>'
								+ '<section>'
								+ '	<div class="img-container">'
								+ '		<img src="/media/companies/sliders/'+imgId+'" class="img-responsive" />'
								+ '	</div>'
								+ '</section>'
								+ '<div class="clr"></div>'
								+ '</div>';
            	
            	$('#slider-items').prepend(sliderItem);
            	$('#save-crop-company-slider').hide();
            	$('.company-slider-upload').fadeOut();
            	
            	$('.delete-slider').click(function(){
                	deleteCompanySlider($(this).attr('sid'));
					return false;
                });
            }
        }
    });
}

function deleteCompanySlider(sliderId)
{
    $.ajax({
        type:   'POST',
        url:    '/ajax/company-media-sliders.php?option=3',
        data:{  
                sliderId: sliderId
             },
        success:
        function(xml)
        {
            if ('1' == xml)
            {
            	$('#sid-'+sliderId).fadeOut();
            }
        }
    });
}

function saveLogoCrop(xLogo, yLogo, imgId)
{
	companyId 	= $('#companyId').val();
    $.ajax({
        type:   'POST',
        url:    '/ajax/company-media-logo.php?option=2',
        data:{  x: xLogo,
                y: yLogo,
            imgId: imgId,
            companyId:companyId
            
             },
        success:
        function(xml)
        {
            if (0 != xml)
            {
            	$('#companyLogo').attr('src','/media/companies/logo/'+imgId);
//            	$('.main-slider-upload').fadeOut();
            	
            }
        }
    });
}

function saveEmails()
{
	emailId 	= 0;
	emailVal 	= '';
	companyId 	= $('#companyId').val();
	
	$('.companyEmail').each(function(){
		emailId 	= 0;
		if ($(this).attr('eid'))
		{
			emailId		= $(this).attr('eid');
			emailVal	= $(this).val();
			
			$.ajax({
		        type:   'POST',
		        url:    '/ajax/company.php',
		        data:{  companyId: 	companyId,
		        	emailId: 		emailId,
		        	emailVal: 		emailVal,
		            section: 		'email'
		             },
		        success:
		        function(xml)
		        {
		            if (0 != xml)
		            {
		            	
		            }
		        }
		    });
		}
	});
}

function savePhones()
{
	phoneVal 	= '';
	companyId 	= $('#companyId').val();
	
	$('.companyPhone').each(function(){
		phoneId		= $(this).attr('pid');
		phoneVal	= $(this).val();
		
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/company.php',
	        data:{  companyId: 	companyId,
	        	phoneId: 		phoneId,
	        	phoneVal: 		phoneVal,
	            section: 		'phone'
	             },
	        success:
	        function(xml)
	        {
	            if (0 != xml)
	            {
	            	
	            }
	        }
	    });
	});
}

function saveInfo()
{
	companyId			= $('#companyId').val();
	companyDescription 	= $('#company-description').val();
	companyName 			= $('#companyName').val();
	companyLocation 		= $('#companyLocation').val();
	locationArray 		= companyLocation.split(",");
	companyLatitude 		= locationArray[0];
	companyLongitude		= locationArray[1];
	
	$.ajax({
        type:   'POST',
        url:    '/ajax/company.php',
        data:{  companyId: 		companyId,
        	companyName: 		companyName,
        	companyDescription: companyDescription,
        	companyLatitude: 	companyLatitude,
        	companyLongitude: 	companyLongitude,
            section: 			'info'
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

function updateCompany()
{
	companyId		= $('#companyId').val();
	companyWebsite	= $('#companyWebsite').val(); 
	
	$.ajax({
        type:   'POST',
        url:    '/ajax/company.php',
        data:{  companyId: 	companyId,
        	companyWebsite: companyWebsite,
            section: 		'website'
             },
        success:
        function(xml)
        {
            if (0 != xml)
            {
            	bootbox.alert({
            	    message: "La información de contacto se ha actualizado correctamente",
            	    size: 'small',
            	    backdrop: true
            	});
            }
        }
    });
}

function saveSeo()
{
	companyId				= $('#companyId').val();
	companySeoTitle 			= $('#companySeoTitle').val();
	companySeoKeywords 		= $('#companySeoKeywords').val();
	companySeoDescription	= $('#companySeoDescription').val();
	
	$.ajax({
        type:   'POST',
        url:    '/ajax/company.php',
        data:{  companyId: 			companyId,
        	companySeoDescription: 	companySeoDescription,
        	companySeoTitle: 		companySeoTitle,
        	companySeoKeywords: 	companySeoKeywords,
            section: 				'seo'
             },
        success:
        function(xml)
        {
            if (0 != xml)
            {
            	bootbox.alert({
            	    message: "La información del SEO se ha actualizado correctamente",
            	    size: 'small',
            	    backdrop: true
            	});
            }
        }
    });
}

function saveSocial()
{
	companyId			= $('#companyId').val();
	companyTwitter 		= $('#companyTwitter').val();
	companyFacebook		= $('#companyFacebook').val();
	companyTripadvisor	= $('#companyTripadvisor').val();
	companyYoutube		= $('#companyYoutube').val();
	companyPinterest		= $('#companyPinterest').val();
	companyInstagram		= $('#companyInstagram').val();
	
	$.ajax({
        type:   'POST',
        url:    '/ajax/company.php',
        data:{  companyId: 		companyId,
        	companyTwitter: 	companyTwitter,
        	companyFacebook: 	companyFacebook,
        	companyTripadvisor: companyTripadvisor,
        	companyYoutube: 	companyYoutube,
        	companyPinterest: 	companyPinterest,
        	companyInstagram: 	companyInstagram,
            section: 			'social'
             },
        success:
        function(xml)
        {
            if (0 != xml)
            {
            	bootbox.alert({
            	    message: "La información de Social se ha actualizado correctamente",
            	    size: 'small',
            	    backdrop: true
            	});
            }
        }
    });
}

function deleteActivity() {
	var companyId = $("#companyId").val();

    swal({
      title: "Advertencia!",
      text: "Estas apunto de aliminar una actividad, ¿Deseas continuar con esta acción?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#AEDEF4",
      confirmButtonText: "Si, Eliminar!",
      cancelButtonText: "No eliminar!",
      closeOnConfirm: false,
      closeOnCancel: false,
      showLoaderOnConfirm: true
    },
    function(isConfirm){
      if (isConfirm) {
        setTimeout(function(){
        	$.ajax({
		        type:   'POST',
		        url:    '/ajax/company.php',
		        data:{  companyId: 	companyId,
		            section: 		'deleteActivity'
		             },
		        success:
		        function(xml)
		        {
		        	window.location.href = "/";
		        }
		    });
            
        }, 2000);
      } else {
            swal("Cancelado", "Has cancelado la eliminación de la actividad.", "error");
      }
    });
}


function checkSubategories(subcategories)
{
	for (i = 0; i < subcategories.length; i++)
	{
		$('#subcategories').find('a').each(function(){
			id = $(this).attr('id');
			if ('sub_'+subcategories[i] == id)
			{
				$(this).addClass('active');
			}
		});	
	}
}

function checkLocations(locations)
{
	for (i = 0; i < locations.length; i++)
	{
		$('#locations').find('a').each(function(){
			id = $(this).attr('id');
			if ('lo_'+locations[i] == id)
			{
				$(this).addClass('active');
			}
		});	
	}
}

function changeCategory(node)
{
	category 	= $(node).attr('category_id');
	companyId 	= $('#companyId').val();

	$('#categories a').removeClass('active');
	$(node).addClass('active');

	getSubcategoriesByCategory(category);
	changeCategoryOfCompany(companyId, category);
}

function getSubcategoriesByCategory(category)
{
	
	$.ajax({
    type: "POST",
    url: "/ajax/company-category-selection.php?option=1",
    data: {
    	category: category
    },
    success:
        function(xml)
        {
        	if (xml != '0')
        	{
	        	$('#subcategories').html(xml);
	        	$('#subcategories a').click(function(){
			    	updateSubcategoriesByCompany(this);
			    });
        	}
        	else
        	{
        		$('#subcategories').html('');
        	}
        }
    }); 	
}

function changeCategoryOfCompany(companyId, category)
{	
	$.ajax({
    type: "POST",
    url: "/ajax/company-category-selection.php?option=2",
    data: {
    	category: category,
    	companyId: companyId
    },
    success:
        function(xml)
        {
        }
    }); 	
}

function updateSubcategoriesByCompany(node)
{
	companyId 	= $('#companyId').val();
	sub_id		= $(node).attr('subcategory');

	if ($(node).attr('class') == 'active')
	{
		$(node).removeClass('active');
	}
	else
	{
		$(node).addClass('active');
	}

	$.ajax({
    type: "POST",
    url: "/ajax/company-category-selection.php?option=3",
    data: {
    	subcategory: sub_id,
    	companyId: companyId
    },
    success:
        function(xml)
        {
        	if (xml != '0')
        	{
        	}
        }
    });

	return false;
}

function updateCompanyLocation(node)
{
	companyId 	= $('#companyId').val();
	location_id	= $(node).attr('location');

	if ($(node).attr('class') == 'active')
	{
		$(node).removeClass('active');
	}
	else
	{
		$(node).addClass('active');
	}

	$.ajax({
    type: "POST",
    url: "/ajax/company-category-selection.php?option=4",
    data: {
    	location_id: location_id,
    	companyId: companyId
    },
    success:
        function(xml)
        {
        	if (xml != '0')
        	{
        	}
        }
    });

	return false;	
}


function publishCompany(pictureId)
{
	companyId 	= $('#companyId').val();
	todo 		= 0;
	
	aMessage = '';
	
	if ($('#publish-company').hasClass('bg-green')) // It is published
	{
		$('#publish-company').removeClass('bg-green');
		aMessage = "OK, you just unpublished this company! <br> (¬､¬)";
	}
	else
	{
		$('#publish-company').addClass('bg-green');
		todo = 1;
		aMessage = "This company it's published now! <br> ｡^‿^｡";
	}
	
    $.ajax({
        type:   'POST',
        url:    '/ajax/company.php',
        data:{  
        	companyId: companyId,
        	todo: 	todo,
        	section: 'publish'
             },
        success:
        function(xml)
        {
            if ('1' == xml)
            {
//            	$('#cgid-'+pictureId).fadeOut();
            	bootbox.alert({
            	    message: aMessage,
            	    size: 'small',
            	    backdrop: true
            	});
            }
        }
    });
}

function closeCompany(pictureId)
{
	companyId 	= $('#companyId').val();
	todo 		= 1;
	aMessage 	= '';
	
	
	if ($('#close-company').hasClass('bg-red')) // it is closed
	{
		$('#close-company').removeClass('bg-red');
		todo = 0;
		aMessage = "This company it's un-archived now! <br> ｡^‿^｡";
	}
	else
	{
		$('#close-company').addClass('bg-red');
		aMessage = "OK, you just archived this company! <br> (¬､¬)";
	}
	
    $.ajax({
        type:   'POST',
        url:    '/ajax/company.php',
        data:{  
        	companyId: companyId,
        	todo: todo,
        	section: 'close'
             },
        success:
        function(xml)
        {
            if ('1' == xml)
            {
//            	$('#cgid-'+pictureId).fadeOut();
            	bootbox.alert({
            	    message: aMessage,
            	    size: 'small',
            	    backdrop: true
            	});
            }
        }
    });
}

function createCompany()
{
	companyName = $('#new-company-name').val();
	$('#create-company').hide();
	
	if (companyName)
	{
		$('#add-company-loader').show();
		$.ajax({
	        type:   'POST',
	        url:    '/ajax/company.php',
	        data:{  
	        	companyName: companyName,
	        	section: 'create'
	             },
	        success:
	        function(xml)
	        {
	            if ('0' != xml)
	            {
	            	setTimeout(func, 3000);
	            	function func() {
	            		$('#add-company-loader').hide();
	            		
	            		var editCompany = '/admin/edit-company/main/'+xml+'/new-company/';
		            	
		            	pathArray 		= $(location).attr('href').split( '/' );
		        		newURL 			= pathArray[0]+'//'+pathArray[2]+editCompany;
		            	window.location = newURL;
	            	}
	            	
	            }
	        }
	    });
	}
	
}




































