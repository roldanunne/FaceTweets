
    <section id="contact">
        <div class="container">

            <div class="panel panel-default">
                <div class="panel-heading"><h4>Profile</h4></div>
                
                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-9 text-left" >
                            <button id="btn-add-profile" class="btn btn-success " style="margin: 10px 0  10px 0;">
                               <i class="glyphicon glyphicon-plus glyphicon-white"></i> Add New Profile
                            </button>
                        </div>
                        <div class="col-sm-3 text-right" >                            
                            <input id="txt-search" type="text" class="form-control" placeholder="Search Here!" type="text" style="margin: 10px 0  10px 0;">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 table-responsive" style="margin-top: 20px">
                            <table id="tbl-profile-list" class="table table-striped">
                                <thead >
                                    <tr class="success">
                                        <th>SN</th>
                                        <th>Title</th>
                                        <th>Thumbnail</th>
                                        <th>Filename</th>
                                        <th>Date Added</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th colspan="6" class="text-center info">Loading available list in the server!</th>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div id="page-selection"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Profile Modals -->
    <div id="view-profile-modal" class="modal fade in" role="dialog" > 
        <div class="modal-dialog modal-lg">
             <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title" id="view-profile-title">New Profile</h3>
                </div>
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="modal-body">                   
                            <img id="view-profile-img" src="/kohana//assets/img/upload/1.png" class="img-responsive img-centered" onError="this.onerror=null;this.src='<?php echo URL::base().'assets/img/no-image.jpg';?>';" >
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!---------------------------------------------
    --- Add New Profile                   ---
    ---------------------------------------------->  
    <div id="add-profile-modal" class="modal fade in" role="dialog" style="margin-top: 100px"> 
        <div class="modal-dialog">
             <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title text-left">New Profile</h3>
                </div>
                <div class="modal-body">
                    <form id="frm-new-profile" class="form-horizontal">
                        <div class="row">
                            <div class="col-sm-4 text-center">
                                <div id="photo-drag-drop" >
                                    <img id="tip-photo" src="<?php echo URL::base(); ?>assets/img/no-image.jpg" class="img-responsive img-rounded img-profile" data-toggle="tooltip" title="Drag your photo here!" >
                                    <div id="photo-previews">
                                        <div id="photo-template">
                                            <img id="img-remove" class="img-responsive img-rounded img-profile" data-toggle="tooltip" title="Click here to remove this photo!" data-dz-thumbnail />
                                            <span id="photo-file" style="display: none;" data-dz-name ></span>
                                        </div>
                                    </div>
                                </div>
                                <button id="btn-browse-photo" class="btn btn-warning btn-xs btn-rounded" >Upload Photo</button>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Title</label>
                                    <div class="col-sm-8">
                                        <input id="add-title" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Filename</label>
                                    <div class="col-sm-8">
                                        <input id="add-filename" class="form-control" type="text" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="btn-submit-add-profile" class="btn btn-success btn-rounded" style="padding: 7px 30px;">Submit</button>
                    <button data-dismiss="modal" class="btn btn-danger btn-rounded" style="padding: 7px 30px;">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <!---------------------------------------------
    --- Edit New Profile                   ---
    ---------------------------------------------->  
    <div id="edit-profile-modal" class="modal fade in" role="dialog" style="margin-top: 100px"> 
        <div class="modal-dialog">
             <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title text-left">Edit Profile</h3>
                </div>
                <div class="modal-body">
                    <form id="frm-edit-profile" class="form-horizontal">
                        <div class="row">
                            <div class="col-sm-4 text-center">
                                <div id="edit-photo-drag-drop" >
                                    <img id="edit-tip-photo" src="<?php echo URL::base(); ?>assets/img/no-image.jpg" class="img-responsive img-rounded img-profile" data-toggle="tooltip" title="Drag your photo here!" >
                                    <div id="edit-photo-previews">
                                        <div id="edit-photo-template">
                                            <img id="edit-img-remove" class="img-responsive img-rounded img-profile" data-toggle="tooltip" title="Click here to remove this photo!" data-dz-thumbnail />
                                            <span id="edit-photo-file" style="display: none;" data-dz-name ></span>
                                        </div>
                                    </div>
                                </div>
                                <button id="edit-btn-browse-photo" class="btn btn-warning btn-xs btn-rounded" >Upload Photo</button>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Title</label>
                                    <div class="col-sm-8">
                                        <input id="edit-title" class="form-control" type="text">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Filename</label>
                                    <div class="col-sm-8">
                                        <input id="edit-filename" class="form-control" type="text" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <input id="edit-id" type="hidden">
                <input id="edit-filename-old" type="hidden">
                <div class="modal-footer">
                    <button id="btn-submit-edit-profile" class="btn btn-success btn-rounded" style="padding: 7px 30px;">Update</button>
                    <button data-dismiss="modal" class="btn btn-danger btn-rounded" style="padding: 7px 30px;">Cancel</button>
                </div>
            </div>
        </div>
    </div>

