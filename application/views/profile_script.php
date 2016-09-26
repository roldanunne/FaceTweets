

    <script>
    
        $(document).ready(function(){
		
  
			///////////////////////////////////////////////////////////////////////
            // Add Profile Photo 
            ///////////////////////////////////////////////////////////////////////

            $('#btn-add-profile').click(function(){
                $("#add-profile-modal").find("input").val('');
                $('#add-profile-modal').modal('show');  
            });


			$(document).on('click', '.show-profile-modal', function() {
		        $tr = $(this).closest('tr');
		        var title	=  $tr.find('.prof-title').text();   
		        var file 	=  $tr.find('.prof-filename').text();
		        var img_url =  $(this).closest('tr').find('img').attr('src');

            	$("#view-profile-title").text(title);
            	$('#view-profile-img').attr('src',img_url);

                $('#view-profile-modal').modal('show'); 
		    });

            
            // Get the template HTML and remove it from the doument
            var addNode       	= document.querySelector("#photo-template");
                addNode.id    	= "";
            var addTemplate 	= addNode.parentNode.innerHTML;
                addNode.parentNode.removeChild(addNode);
            
			var add_dropzone	= new Dropzone("#photo-drag-drop", { 
                url             : "<?=URL::base()?>home/upload_photo",   
                paramName       : "photo",
                autoQueue       : false, 
                clickable       : "#btn-browse-photo",
                acceptedFiles   : "image/*",
                previewTemplate : addTemplate,
                previewsContainer : "#photo-previews",
                queuecomplete   : function(progress) {
                                    this.removeAllFiles(true);
                    				$('#tip-photo').show();
                                },
                error           : function(progress) {
									$.growl.error({ title: "Error!", message: "The image you are trying to upload have an error!" });
                                    this.removeAllFiles(true);
                    				$('#tip-photo').show();
                                }
                });
            
            add_dropzone.on("addedfile", function(file) {
                if (this.files[1]!=null){
                    this.removeFile(this.files[0]);
                }
                // Listen to the click event
                $('#img-remove').click(function(){
                    add_dropzone.removeFile(file);
                    $('#tip-photo').show();
                    return false;
                });
                $('#tip-photo').hide();                
                $('#add-filename').val($('#photo-file').text());
            }); 



		    $('#btn-submit-add-profile').click(function() {
    			$(this).prop("disabled",true);

                var title   	= $("#add-title").val();
		        var photo_file  = $("#photo-file").text();
                if (title!=="" && photo_file!=="") {
                	var ctr = 0;
                    add_dropzone.enqueueFiles(add_dropzone.getFilesWithStatus(Dropzone.ADDED));
                    add_dropzone.on("success", function(files, response) {
                    	if (ctr==0){
                        submit_new_profile(title,$.trim(response));
                        	ctr++;
                        }
                    });
                } else {
					$.growl.error({ title: "Error!", message: "Please check all required details." });
    				$(this).prop("disabled",false);
                }

		    });


            //Save the New Profile
            function submit_new_profile(title,filename){
                $.post("<?=URL::base()?>home/add_profile",
                {
                    title 		: title,
                    filename 	: filename
      			}, function(data){
    				$('#btn-submit-add-profile').prop("disabled",false);
      				if (data!=='Error!'){ 
      					var json_data = $.parseJSON(data);  
		                reload_profile_list(json_data.list); 
            			load_profile_list(json_data.pages);
	      				$.growl.notice({ title: "Success!", message: "New profile has been added." });
                		$('#add-profile-modal').modal('hide');  
      				} else {
	      				$.growl.error({ title: "Error!", message: "Cannot add this new profile." });
      				}
      			});
            }

            function reload_profile_list(data){
                var html_list = "";
                var i=1;
                if (data.length>0) {
	                $.each(data, function(index, item){
	                    html_list +='<tr>'+ 
	                				'	<td id="'+item.id+'" class="vert-align prof-id">'+(i++)+'</td>'+ 
	                				'	<td class="vert-align prof-title">'+item.title+'</td>'+ 
	                				'	<td class="vert-align prof-img_url">'+ 
	                				'		<a class="show-profile-modal" href="#" title="Click here!">'+ 
	                				'			<img src="<?php echo URL::base();?>'+item.img_url+'" class="img-rounded thumbnail" onError="this.onerror=null;this.src=\'<?php echo URL::base();?>assets/img/no-image.jpg\'" >'+ 
	                				'		</a>'+ 
	                				'	<td class="vert-align prof-filename">'+item.filename+'</td>'+ 
	                				'	<td class="vert-align prof-dt_added">'+item.dt_added+'</td>'+ 
	                				'	<td class="vert-align">'+ 	                    				
	                                '		<div class="btn-group">'+
	                                '    		<button type="button" class="btn btn-xs btn-info dropdown-toggle" data-toggle="dropdown" >'+
	                                '       	 	<span class="glyphicon glyphicon-cog"></span> &nbsp; <span class="caret"></span>'+
	                                '    		</button>'+
	                                '    		<ul class="dropdown-menu pull-right">'+
	                                '       	 	<li><a href="#" class="btn-edit-profile btn-xs"><span class="glyphicon glyphicon glyphicon-pencil"></span> Edit</a></li>'+
	                                '       	 	<li class="divider"></li>'+
	                                '       		<li><a href="#" class="btn-delete-profile btn-xs"><span class="glyphicon glyphicon glyphicon-remove-sign"></span> Delete</a></li>'+
	                                '    		</ul>'+
	                                '		</div>'+
	                				'	</td>'+ 
	                				'</tr>';
	                });
				} else {
					html_list = '<tr><th colspan="6" class="text-center danger">No Available List!</th></tr>';
				}
                $('#tbl-profile-list tbody').html(html_list);
            }


			///////////////////////////////////////////////////////////////////////
            // Edit Profile Photo 
            ///////////////////////////////////////////////////////////////////////
			$(document).on('click', '.btn-edit-profile', function() {
		        $tr = $(this).closest('tr');
		        var id		=  $tr.find('.prof-id').attr('id'); 
		        var title	=  $tr.find('.prof-title').text();   
		        var file 	=  $tr.find('.prof-filename').text();
		        var img_url =  $(this).closest('tr').find('img').attr('src');

            	$("#edit-id").val(id);
            	$("#edit-title").val(title);
            	$("#edit-filename").val(file);
            	$("#edit-filename-old").val(file);
            	$('#edit-tip-photo').attr('src',img_url);

                $('#edit-profile-modal').modal('show');                 
		    });


            // Get the template HTML and remove it from the doument
            var editNode       = document.querySelector("#edit-photo-template");
                editNode.id    = "";
            var editTemplate   = editNode.parentNode.innerHTML;
                editNode.parentNode.removeChild(editNode);
            
            var edit_dropzone	= new Dropzone("#edit-photo-drag-drop", { 
                url             : "<?=URL::base()?>home/upload_photo",  
                paramName       : "photo",
                autoQueue       : false, 
                clickable       : "#edit-btn-browse-photo",
                acceptedFiles   : "image/*",
                previewTemplate : editTemplate,
                previewsContainer : "#edit-photo-previews",
                queuecomplete   : function(progress) {
                                    this.removeAllFiles(true);
                    				$('#edit-tip-photo').show();
                                },
                error           : function(progress) {
									$.growl.error({ title: "Error!", message: "The image you are trying to upload have an error!" });
                                    this.removeAllFiles(true);
                    				$('#edit-tip-photo').show();
                                }
                });
            
            edit_dropzone.on("addedfile", function(file) {
                if (this.files[1]!=null){
                    this.removeFile(this.files[0]);
                }
                // Listen to the click event
                $('#edit-img-remove').click(function(){
                    edit_dropzone.removeFile(file);
                    $('#edit-tip-photo').show();
                    return false;
                });
                $('#edit-tip-photo').hide();                
                $('#edit-filename').val($('#edit-photo-file').text());
            }); 



		    $('#btn-submit-edit-profile').click(function() {
    			$(this).prop("disabled",true);

                var id   		= $("#edit-id").val();
                var title   	= $("#edit-title").val();
                var photo_old   = $("#edit-filename-old").val();
		        var photo_file  = $("#edit-photo-file").text();

                if (title!=="" && photo_file!=="") {
                	var ctr=0;
                    edit_dropzone.enqueueFiles(edit_dropzone.getFilesWithStatus(Dropzone.ADDED));
                    edit_dropzone.on("success", function(files, response) {
                    	if (ctr==0){
                        	submit_edit_profile(id,title,$.trim(response),photo_old);
                        	ctr++;
                        }
                    });
                } else if (title!=="") {
                    submit_edit_profile(id,title,'','');
          		} else {
					$.growl.error({ title: "Error!", message: "Please check all required details." });
    				$(this).prop("disabled",false);
                }

		    });


            //Update the Profile
            function submit_edit_profile(id,title,filename,photo_old){
                $.post("<?=URL::base()?>home/update_profile",
                {
                    id 			: id,
                    title 		: title,
                    filename 	: filename,
                    photo_old 	: photo_old
      			}, function(data){
    				$('#btn-submit-edit-profile').prop("disabled",false);
      				if (data!=='Error!'){
      					var json_data = $.parseJSON(data);  
		                reload_profile_list(json_data.list); 
            			load_profile_list(json_data.pages);
	      				$.growl.notice({ title: "Success!", message: "Profile has been updated." });
                		$('#edit-profile-modal').modal('hide');  
      				} else {
	      				$.growl.error({ title: "Error!", message: "Cannot edit this profile." });
      				}
      			});
            }


			///////////////////////////////////////////////////////////////////////
            // Delete Profile Photo 
            ///////////////////////////////////////////////////////////////////////

			$(document).on('click', '.btn-delete-profile', function() {
		        $tr = $(this).closest('tr');
		        var id		=  $tr.find('.prof-id').attr('id');
		        var file 	=  $tr.find('.prof-filename').text();
		        var title	=  $tr.find('.prof-title').text(); 

		        var msg = 'You are going to delete '+title+'. Are you sure?';
	            if(confirm(msg)){
	                $.post("<?=URL::base()?>home/delete_profile",
	                {
	                    id 		: id,
	                    file 	: file
	      			}, function(data){
	      				if (data!=='Error!'){
	      					var json_data = $.parseJSON(data);  
			                reload_profile_list(json_data.list); 
                			load_profile_list(json_data.pages);
		      				$.growl.notice({ title: "Success!", message: "Profile has been deleted." });
	      				} else {
		      				$.growl.error({ title: "Error!", message: "Cannot edit this profile." });
	      				}
	      			});
	            }
		    });


			///////////////////////////////////////////////////////////////////////
            // Search in Profile list
            ///////////////////////////////////////////////////////////////////////

			$(document).on('change keyup paste mouseup', '#txt-search', function() {
		        var search	=  $(this).val();
                $.post("<?=URL::base()?>home/search_profile",
                {
                	offset 	: 1,
                    search 	: search
      			}, function(data){
	                var json_data = $.parseJSON(data);  
	                reload_profile_list(json_data.list); 
	  			    $('#page-selection').bootpag({
					   total		: json_data.pages,
					   maxVisible	: 10
			        }).on("page", function(event, num){                
			        	$.post("<?=URL::base()?>home/search_profile",
		                {
			                offset 	: num,
                    		search 	: search
		      			}, function(res){
		      				if (res!=='Error!'){
		                		var json_res = $.parseJSON(res);  
		      					reload_profile_list(json_res.list);
		      				} else {
			      				$.growl.error({ title: "Error!", message: "Cannot find this in profile." });
		      				}
		      			});
			        });
      			});
		    });


			///////////////////////////////////////////////////////////////////////
            // Load Default in Profile list with Pagination
            ///////////////////////////////////////////////////////////////////////

        	$.post("<?=URL::base()?>home/get_profile_all",
            {
                offset 	: 1
  			}, function(data){
                var json_data = $.parseJSON(data);  
                reload_profile_list(json_data.list); 
                load_profile_list(json_data.pages);
  			});


            function load_profile_list(pages){
  			    $('#page-selection').bootpag({
				   total		: pages,
				   maxVisible	: 10
		        }).on("page", function(event, num){                
		        	$.post("<?=URL::base()?>home/get_profile_all",
	                {
		                offset 	: num
	      			}, function(res){
                		var json_res = $.parseJSON(res);  
      					reload_profile_list(json_res.list);
	      			});
		        });
            }

        });
    </script>
    