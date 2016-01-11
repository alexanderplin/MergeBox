       <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center m-t-lg">
                        <h1>
                            Welcome in INSPINIA Static SeedProject
                        </h1>
                        <small>
                            It is an application skeleton for a typical web app. You can use it to quickly bootstrap your webapp projects and dev environment for these projects.
                        </small>
                        <iframe id='my_iframe' style='display:none';></iframe>
                    </div>
                </div>
            </div>
        </div>
            <!-- Mainly scripts -->
            <script src="js/jquery-2.1.1.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
            <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

            <!-- Peity -->
            <script src="js/plugins/peity/jquery.peity.min.js"></script>

            <!-- Custom and plugin javascript -->
            <script src="js/inspinia.js"></script>
            <script src="js/plugins/pace/pace.min.js"></script>
            <script src="js/jquery.fileDownload.js">
            <!-- iCheck -->
            <script src="js/plugins/iCheck/icheck.min.js"></script>

            <!-- Peity -->
            <script src="js/demo/peity-demo.js"></script>

            <script src="js/jquery-ui-1.10.4.min.js"></script>
            
            <script>
                $(document).ready(function(){
                    $(window).on('hashchange', function() {
                        var temp = (window.location.hash).split("#");
                        var accountid = (temp[1].split('&'))[0];
                        var path = (temp[1].split("&"))[1];
                        if(accountid !== '/')
                        {
                            request_files(accountid,path                                                                                                                                                                                                                                                                                , function(result){
                            var data = jQuery.parseJSON(result);
                            if(data['type'] == 'folder')
                            {
                                console.log('lkfjasdf');
                                square_count = 0;
                                $('tbody.draggable.single').empty();
                                $.each(data['content'],function(blank, file){
                                    var file_info = '<tr data-accountid="{{ACCOUNT_ID}}" data-path="{{PATH}}" data-isdir="{{IS_DIR}}"> <td class="no_dl"> <div class="squaredTwo"> <input type="checkbox" value="None" id="squaredOne{{COUNT}}" name="check"/> <label for="squaredOne{{COUNT}}"></label> </div></td><td>{{SERVICE_ID}}</td><td>{{FILE_NAME}}</td><td>{{FILE_KIND}}</td><td>{{FILE_SIZE}}</td><td><a href="#"><i class="fa fa-check text-navy"></i></a></td></tr>';
                                    file_info = file_info.replace('{{ACCOUNT_ID}}', data['service_id']);
                                    file_info = file_info.replace('{{SERVICE_ID}}', data['service_id']);
                                    file_info = file_info.replace('{{PATH}}', file['path']);
                                    file_info = file_info.replace('{{FILE_NAME}}', file['name']);
                                    file_info = file_info.replace('{{FILE_KIND}}', file['kind']);
                                    file_info = file_info.replace('{{IS_DIR}}', is_dir(file['kind']));
                                    file_info = file_info.replace('{{FILE_SIZE}}', file['size']);
                                    file_info = file_info.replace('{{COUNT}}', square_count);
                                    file_info = file_info.replace('{{COUNT}}', square_count);
                                    square_count++;

                                    $('.draggable.single').append(file_info);
                                })
                                bind_click();
                            }
                            })
                        }
                    });  
                }); 
                function download_url(url, callback) {
                    document.getElementById('my_iframe').src = url;
                    callback;
                }
                function request_files(service, directory, callback)
                {
                    $.post("ajax_handler.php", {
                        action: "request_files",
                        files: service,
                        path: directory,
                        dataType: 'json'
                    },callback)
                }
                function reset_gdrive_permissions(service, directory, role, type, value)
                {
                    $.post("ajax_handler.php", {
                        action: "Gdrive_reset_permissions",
                        files: service,
                        path: directory,
                        oldrole:role,
                        oldtype:type,
                        oldvalue:value,
                        dataType: 'json'
                    })
                }
                function bind_click()
                {
                    $('tbody tr td').off('click');
                    $('tbody tr td').not('.no_dl').on('click',function(){
                        if($(this).closest('tr').attr('data-isdir') == 'true')
                        {
                            window.location.hash = $(this).closest('tr').attr('data-accountid') +'&'+ $(this).closest('tr').attr('data-path');
                        }
                        else
                        {
                            var accountid = $(this).closest('tr').attr('data-accountid');
                            request_files($(this).closest('tr').attr('data-accountid'), $(this).closest('tr').attr('data-path'), function(result){
                                var data = jQuery.parseJSON(result);
                                console.log(data);
                                if(data['type'] == 'file'&& data['service']=='1')
                                {
                                    var download = data['link'][0]+'?dl=1';
                                    download_url(download);
                                }
                                else if(data['type'] == 'file'&& data['service']=='3')
                                {
                                    var download = data['link'];
                                    
                                    download_url(download,reset_gdrive_permissions(accountid, data['fileid'], data['reset_permission']['role'], data['reset_permission']['type'], data['reset_permission']['value']));
                                    console.log("work")
                                }
                            });
                        }
                    })
                }
                function is_dir(string)
                {
                    if(string == "application/vnd.google-apps.folder" || string == "folder")
                    {
                        return true
                    }
                    else
                    {
                        return false
                    }
                }
                $(document).ready(function(){
                    var accounts = [];
                    var square_count = 0;
                    var can_togg = true;
                    if(can_togg){
                    $('.toggle a').click(
                        function(){
                            console.log(can_togg);
                            can_togg = false;
                            console.log(can_togg);
                            window.location.hash = '/';
                            $(this).closest('li').toggleClass("active");
                            if($(this).closest('li').hasClass('active'))
                            {
                                var active_accounts = $('.toggle.active');
                                if (active_accounts.length == 2)
                                {
                                    square_count = 0;
                                    $('.row.animated').remove();
                                    console.log("triggered");
                                    var duo_template = '<div class="row animated fadeInRight"> <div class="col-lg-6"> <div class="ibox float-e-margins"> <div class="ibox-title"> <h5>{{1TITLE}} </h5> </div><div class="ibox-content"> <div class="row"> <div class="col-sm-3" style="float: right;"> <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn"> <button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div></div></div><div class="table-responsive droppable"> <table id="service1" data-accountid="{{1ACCOUNT_ID}}" data-service="{{1SERVICE_ID}}" data-curdir="{{1DIRECTORY}}" class="table table-hover"> <thead> <tr> <th></th> <th>Icon </th> <th>Name </th> <th>Kind</th> <th>Size</th> <th>Action</th> </tr></thead> <tbody class="draggable duo"> </tbody> </table> </div></div></div></div><div class="col-lg-6"> <div class="ibox float-e-margins"> <div class="ibox-title"> <h5>{{2TITLE}} </h5> </div><div class="ibox-content"> <div class="row"> <div class="col-sm-3" style="float: right;"> <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn"> <button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div></div></div><div class="table-responsive droppable"> <table id="service2" data-accountid="{{2ACCOUNT_ID}}" data-service="{{2SERVICE_ID}}" data-curdir="{{2DIRECTORY}}" class="table table-hover"> <thead> <tr> <th></th> <th>Icon </th> <th>Name </th> <th>Kind</th> <th>Size</th> <th>Action</th> </tr></thead> <tbody class="draggable duo"> </tbody> </table> </div></div></div></div></div>';
                                    var count = 1;
                                    active_accounts.each(function(){
                                        var replacer_service = '{{'+count+'SERVICE}}';
                                        var replacer_account = '{{'+count+'ACCOUNT_ID}}';
                                        var replacer_serviceid = '{{'+count+'SERVICE_ID}}';
                                        var replacer_directory = '{{'+count+'DIRECTORY}}';
                                        var replacer_title = '{{'+count+'TITLE}}';
                                        count++;
                                        duo_template = duo_template.replace(replacer_title, $(this).closest('ul').attr('id')+": "+$(this).find('a').html());
                                        duo_template = duo_template.replace(replacer_service, $(this).closest('ul').attr('id')+$(this).find('a').attr('data-account'));
                                        duo_template = duo_template.replace(replacer_account, $(this).find('a').attr('data-account'));
                                        duo_template = duo_template.replace(replacer_serviceid, $(this).closest('ul').attr('data-service'));
                                        duo_template = duo_template.replace(replacer_directory, "/");
                                    })
                                 
                                    $('.wrapper.wrapper-content').append(duo_template);
                                    active_accounts.each(function(){
                                        var current_account = $(this);
                                        request_files($(this).find('a').attr('data-account'), "/", function(result){
                                            var files = jQuery.parseJSON(result);
                                            console.log(files);
                                            var eventual_append = "";
                                            $.each(files['content'],function(blank, file){
                                                var file_info = '<tr data-accountid="{{ACCOUNT_ID}}" data-path="{{PATH}}" data-isdir="{{IS_DIR}}"> <td class="no_dl"> <div class="squaredTwo"> <input type="checkbox" value="None" id="squaredOne{{COUNT}}" name="check"/> <label for="squaredOne{{COUNT}}"></label> </div></td><td>{{SERVICE_ID}}</td><td>{{FILE_NAME}}</td><td>{{FILE_KIND}}</td><td>{{FILE_SIZE}}</td><td><a href="#"><i class="fa fa-check text-navy"></i></a></td></tr>';
                                                file_info = file_info.replace('{{ACCOUNT_ID}}', files['service_id']);
                                                file_info = file_info.replace('{{SERVICE_ID}}', files['service_id']);
                                                file_info = file_info.replace('{{PATH}}', file['path']);
                                                file_info = file_info.replace('{{FILE_NAME}}', file['name']);
                                                file_info = file_info.replace('{{FILE_KIND}}', file['kind']);
                                                file_info = file_info.replace('{{IS_DIR}}', is_dir(file['kind']));
                                                file_info = file_info.replace('{{FILE_SIZE}}', file['size']);
                                                file_info = file_info.replace('{{COUNT}}', square_count);
                                                file_info = file_info.replace('{{COUNT}}', square_count);
                                                square_count++;
                                                eventual_append = eventual_append + file_info;
                                            });
                                                var account_id = current_account.find('a').attr('data-account');
                                                $('table[data-accountid="'+account_id+'"]').append(eventual_append);
                                                bind_click();
                                        })
                                        
                                    })
                                }
                                else if($(this).closest('li').hasClass('active') && !(active_accounts.length == 2) && (active_accounts.length == 3 || active_accounts.length == 1))
                                {
                                    square_count = 0;
                                    console.log("this");
                                    
                                    active_accounts.each(function(){
                                        
                                        request_files($(this).find('a').attr('data-account'), "/", function(result){
                                            var files = jQuery.parseJSON(result);
                                            console.log(files);
                                            $.each(files['content'],function(blank, file){
                                                var file_info = '<tr data-accountid="{{ACCOUNT_ID}}" data-path="{{PATH}}" data-isdir="{{IS_DIR}}"> <td class="no_dl"> <div class="squaredTwo"> <input type="checkbox" value="None" id="squaredOne{{COUNT}}" name="check"/> <label for="squaredOne{{COUNT}}"></label> </div></td><td>{{SERVICE_ID}}</td><td>{{FILE_NAME}}</td><td>{{FILE_KIND}}</td><td>{{FILE_SIZE}}</td><td><a href="#"><i class="fa fa-check text-navy"></i></a></td></tr>';
                                                file_info = file_info.replace('{{ACCOUNT_ID}}', files['service_id']);
                                                file_info = file_info.replace('{{SERVICE_ID}}', files['service_id']);
                                                file_info = file_info.replace('{{PATH}}', file['path']);
                                                file_info = file_info.replace('{{FILE_NAME}}', file['name']);
                                                file_info = file_info.replace('{{FILE_KIND}}', file['kind']);
                                                file_info = file_info.replace('{{IS_DIR}}', is_dir(file['kind']));
                                                file_info = file_info.replace('{{FILE_SIZE}}', file['size']);
                                                file_info = file_info.replace('{{COUNT}}', square_count);
                                                file_info = file_info.replace('{{COUNT}}', square_count);
                                                $('.draggable.single').append(file_info);
                                                square_count++;
                                            });
                                        bind_click();
                                        });  
                                    });

                                    $('.row.animated').remove();
                                    var data = $("#dynamic_table_singular").html();
                                    $('.wrapper.wrapper-content').append(data);
                                }
                                //if unselcted (account to not be shown need to remove them from the UI)
                                else if(active_accounts.length == 1)
                                {
                                    square_count = 0;
                                    console.log("one");
                                    $('.row.animated').remove();
                                    var data = $("#dynamic_table_singular").html();
                                    $('.wrapper.wrapper-content').append(data);
                                }
                                else
                                {
                                    console.log("wut");
                                    request_files($(this).attr('data-account'), "/", function(result){
                                            var files = jQuery.parseJSON(result);
                                            console.log(files);
                                            $.each(files['content'],function(blank, file){
                                                var file_info = '<tr data-accountid="{{ACCOUNT_ID}}" data-path="{{PATH}}" data-isdir="{{IS_DIR}}"> <td class="no_dl"> <div class="squaredTwo"> <input type="checkbox" value="None" id="squaredOne{{COUNT}}" name="check"/> <label for="squaredOne{{COUNT}}"></label> </div></td><td>{{SERVICE_ID}}</td><td>{{FILE_NAME}}</td><td>{{FILE_KIND}}</td><td>{{FILE_SIZE}}</td><td><a href="#"><i class="fa fa-check text-navy"></i></a></td></tr>';
                                                file_info = file_info.replace('{{ACCOUNT_ID}}', files['service_id']);
                                                file_info = file_info.replace('{{SERVICE_ID}}', files['service_id']);
                                                file_info = file_info.replace('{{PATH}}', file['path']);
                                                file_info = file_info.replace('{{FILE_NAME}}', file['name']);
                                                file_info = file_info.replace('{{FILE_KIND}}', file['kind']);
                                                file_info = file_info.replace('{{IS_DIR}}', is_dir(file['kind']));
                                                file_info = file_info.replace('{{FILE_SIZE}}', file['size']);
                                                file_info = file_info.replace('{{COUNT}}', square_count);
                                                file_info = file_info.replace('{{COUNT}}', square_count);
                                                $('.draggable').append(file_info);

                                                square_count++;
                                            });
                                            bind_click();
                                        });
                                }
                                rebind();
                            }
                            else
                            {
                                var remove = $(this).attr('data-account');
                                $('tbody tr[data-accountid='+remove+']').remove();
                                var active_accounts = $('.toggle.active');
                                if (active_accounts.length == 2)
                                {
                                    $('tbody').remove();
                                    square_count = 0;
                                    $('.row.animated').remove();
                                    console.log("triggered");
                                    var duo_template = '<div class="row animated fadeInRight"> <div class="col-lg-6"> <div class="ibox float-e-margins"> <div class="ibox-title"> <h5>{{1TITLE}} </h5> </div><div class="ibox-content"> <div class="row"> <div class="col-sm-3" style="float: right;"> <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn"> <button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div></div></div><div class="table-responsive droppable"> <table id="service1" data-accountid="{{1ACCOUNT_ID}}" data-service="{{1SERVICE_ID}}" data-curdir="{{1DIRECTORY}}" class="table table-hover"> <thead> <tr> <th></th> <th>Icon </th> <th>Name </th> <th>Kind</th> <th>Size</th> <th>Action</th> </tr></thead> <tbody class="draggable duo"> </tbody> </table> </div></div></div></div><div class="col-lg-6"> <div class="ibox float-e-margins"> <div class="ibox-title"> <h5>{{2TITLE}} </h5> </div><div class="ibox-content"> <div class="row"> <div class="col-sm-3" style="float: right;"> <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn"> <button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div></div></div><div class="table-responsive droppable"> <table id="service2" data-accountid="{{2ACCOUNT_ID}}" data-service="{{2SERVICE_ID}}" data-curdir="{{2DIRECTORY}}" class="table table-hover"> <thead> <tr> <th></th> <th>Icon </th> <th>Name </th> <th>Kind</th> <th>Size</th> <th>Action</th> </tr></thead> <tbody class="draggable duo"> </tbody> </table> </div></div></div></div></div>';
                                    var count = 1;
                                    active_accounts.each(function(){
                                        var replacer_service = '{{'+count+'SERVICE}}';
                                        var replacer_account = '{{'+count+'ACCOUNT_ID}}';
                                        var replacer_serviceid = '{{'+count+'SERVICE_ID}}';
                                        var replacer_directory = '{{'+count+'DIRECTORY}}';
                                        var replacer_title = '{{'+count+'TITLE}}';
                                        count++;
                                        duo_template = duo_template.replace(replacer_title, $(this).closest('ul').attr('id')+": "+$(this).find('a').html());
                                        duo_template = duo_template.replace(replacer_service, $(this).closest('ul').attr('id')+$(this).find('a').attr('data-account'));
                                        duo_template = duo_template.replace(replacer_account, $(this).find('a').attr('data-account'));
                                        duo_template = duo_template.replace(replacer_serviceid, $(this).closest('ul').attr('data-service'));
                                        duo_template = duo_template.replace(replacer_directory, "/");
                                    })
                                 
                                    $('.wrapper.wrapper-content').append(duo_template);
                                    active_accounts.each(function(){
                                        var current_account = $(this);
                                        request_files($(this).find('a').attr('data-account'), "/", function(result){
                                            var files = jQuery.parseJSON(result);
                                            console.log(files);
                                            var eventual_append = "";
                                            $.each(files['content'],function(blank, file){
                                                var file_info = '<tr data-accountid="{{ACCOUNT_ID}}" data-path="{{PATH}}" data-isdir="{{IS_DIR}}"> <td class="no_dl"> <div class="squaredTwo"> <input type="checkbox" value="None" id="squaredOne{{COUNT}}" name="check"/> <label for="squaredOne{{COUNT}}"></label> </div></td><td>{{SERVICE_ID}}</td><td>{{FILE_NAME}}</td><td>{{FILE_KIND}}</td><td>{{FILE_SIZE}}</td><td><a href="#"><i class="fa fa-check text-navy"></i></a></td></tr>';
                                                file_info = file_info.replace('{{ACCOUNT_ID}}', files['service_id']);
                                                file_info = file_info.replace('{{SERVICE_ID}}', files['service_id']);
                                                file_info = file_info.replace('{{PATH}}', file['path']);
                                                file_info = file_info.replace('{{FILE_NAME}}', file['name']);
                                                file_info = file_info.replace('{{FILE_KIND}}', file['kind']);
                                                file_info = file_info.replace('{{IS_DIR}}', is_dir(file['kind']));
                                                file_info = file_info.replace('{{FILE_SIZE}}', file['size']);
                                                file_info = file_info.replace('{{COUNT}}', square_count);
                                                file_info = file_info.replace('{{COUNT}}', square_count);
                                                square_count++;
                                                eventual_append = eventual_append + file_info;
                                            });
                                                var account_id = current_account.find('a').attr('data-account');
                                                      $('table[data-accountid="'+account_id+'"]').append(eventual_append);
                                                bind_click();
                                        })
                                        
                                    })
                                }
                                else if(active_accounts.length == 1)
                                {
                                    $('tbody').remove();
                                    square_count = 0;
                                    console.log("this");
                                    window.setTimeout(function(){
                                    active_accounts.each(function(){
                                        
                                        request_files($(this).find('a').attr('data-account'), "/", function(result){
                                            var files = jQuery.parseJSON(result);
                                            console.log(files);
                                            $.each(files['content'],function(blank, file){
                                                var file_info = '<tr data-accountid="{{ACCOUNT_ID}}" data-path="{{PATH}}" data-isdir="{{IS_DIR}}"> <td class="no_dl"> <div class="squaredTwo"> <input type="checkbox" value="None" id="squaredOne{{COUNT}}" name="check"/> <label for="squaredOne{{COUNT}}"></label> </div></td><td>{{SERVICE_ID}}</td><td>{{FILE_NAME}}</td><td>{{FILE_KIND}}</td><td>{{FILE_SIZE}}</td><td><a href="#"><i class="fa fa-check text-navy"></i></a></td></tr>';
                                                file_info = file_info.replace('{{ACCOUNT_ID}}', files['service_id']);
                                                file_info = file_info.replace('{{SERVICE_ID}}', files['service_id']);
                                                file_info = file_info.replace('{{PATH}}', file['path']);
                                                file_info = file_info.replace('{{FILE_NAME}}', file['name']);
                                                file_info = file_info.replace('{{FILE_KIND}}', file['kind']);
                                                file_info = file_info.replace('{{IS_DIR}}', is_dir(file['kind']));
                                                file_info = file_info.replace('{{FILE_SIZE}}', file['size']);
                                                file_info = file_info.replace('{{COUNT}}', square_count);
                                                file_info = file_info.replace('{{COUNT}}', square_count);
                                                
                                                $('.draggable.single').append(file_info);
                                                square_count++;
                                            });
                                        bind_click();
                                        });
                                        
                                    });},1000);  
                                    $('.row.animated').remove();
                                    var data = $("#dynamic_table_singular").html();
                                    $('.wrapper.wrapper-content').append(data);
                                }
                                else if(active_accounts.length == 0)
                                {$('.row.animated').remove();}
                            }
                        }
                    )
                    }
                    function rebind(){
                    $('tbody').on('click', 'input', function(){
                            console.log('hi');
                            if($(this).closest('table').attr('id') == 'service1')
                            {
                                $('#service2 input').prop( "checked", false );
                                $('#service2 tbody tr').removeClass('checked');
                            }
                            else{
                                $('#service1 input').prop( "checked", false );
                                $('#service1 tbody tr').removeClass('checked');
                            }
                            $(this).closest('tr').removeAttr( 'style' );
                            $(this).closest('tr').toggleClass('checked');
                            refresh();
                            $(document).ready().keydown(function(e) {
                            if (e.keyCode == 67 && e.ctrlKey) {
                                $('.checked').each(function(){
                                    //toggle copy
                                    $(this).css('border','2px solid #2C8F7B','float','left');
                                })
                            }
                            else if(e.keyCode == 88 && e.ctrlKey){
                                $('.checked').each(function(){
                                    //toggle cut
                                    $(this).css('border','2px dashed #2C8F7B','float','left');
                                })
                        }
                    });
                        }
                    )}
                    /*$("tbody.connectedSortable").sortable({
                        connectWith: ".connectedSortable",
                        items: "> tr:not(.placeholder)",
                        helper: "clone",
                        cursor: "move",
                        zIndex: 99999,
                        receive: function(event, ui) {
                            ui.placeholder.height(ui.item.height());
                            console.log(ui.item.height())
                            console.log(ui.item.attr("data-id"));
                            var addedTo = $(this).closest("table"),
                            removedFrom = $("table").not(addedTo);
                            //alert("The ajax should be called for adding to " + addedTo.attr("id") + " and removing from " + removedFrom.attr("id"));
                        }
                    });*/


                    function transferFile(){
                        consolapp/league.avie.log("folder is empty and apending");
                    }

                    function moveFile(){
                        //moving objects to folders
                        $( "tr[data-isdir=\"1\"]" ).droppable({
                            over: function( event, ui){
                                ui.helper.data('over-folder', false);
                            },
                            out: function(event,ui){
                                ui.helper.data('over-folder', false);
                            },
                            drop: function( event, ui ) {

                                /*
                                var thisPath = $(this).data('path');
                                var thisIsDir = $(this).data('isdir');
                                var thisServiceTableId = $(this).closest('table').attr('id');
                                var thisAccountId = $(this).closest('table').data('accountid');
                                var thisService = $(this).closest('table').data('service');
                                //compensate for draggable and droppable on same box, prevent adding itself
                                if( thisPath !== ui.helper.data('from-path') ){
                                    ui.helper.data('to-tableid', thisServiceTableId);
                                    ui.helper.data('to-service', thisService);
                                    ui.helper.data('to-path', thisPath);
                                    ui.helper.data('to-isdir', thisIsDir);
                                    ui.helper.data('to-accountid', thisAccountId);

                                    ui.helper.data('dropped', true);
                                    var selector = $(ui.helper.data('html-append')).appendTo($(this).parent());
                                    $(selector).removeAttr("style");
                                    $(selector).removeAttr("class");

                                    //move object to the inside of the folder
                                    console.log("Moving: " + ui.helper.data('from-path') + " to " + ui.helper.data('to-path'));

                                }*/
                            }
                        });
                        $( ".droppable" ).droppable({
                            drop: function( event, ui ) {
                                //if the table has no tr enteries
                                //if(!($(this).find('table').find('tbody').find('tr').length)){
                                var thisPath = $(this).find('table').data('curdir');
                                var thisServiceTableId = $(this).find('table').attr('id');
                                var thisAccountId = $(this).find('table').data('accountid');
                                var thisService = $(this).find('table').data('service');

                                if(!(ui.helper.data('over-folder'))){

                                    for (index = 0; index < ui.helper.data('selectedFiles').length; ++index) {
                                        var toSelectedFile = [];
                                        toSelectedFile.push({
                                            'to-tableid': thisServiceTableId,
                                            'to-service': thisService,
                                            'to-accountid': thisAccountId,
                                            'to-path': thisPath
                                        })
                                        ui.helper.data('selectedFiles')[index].push(toSelectedFile[0]);
                                    }
                                    //post request here to upload
                                    ui.helper.data('dropped', true);
                                    /*

                                    //console.log("Moving: " + ui.helper.data('from-path') + " to " + ui.helper.data('to-path'));
                                    */
                                    for (index = 0; index < ui.helper.data('selectedFiles').length; ++index) {
                                        var selector = $(ui.helper.data('selectedFiles')[index][0]['html-append']).appendTo($(this).find("table").find('tbody'));
                                        $(selector).removeAttr("style");
                                        $(selector).removeAttr("class");

                                        var movedFile = ui.helper.data('selectedFiles')[index][0]['from-path'];
                                        var movedTo = ui.helper.data('selectedFiles')[index][1]['to-path'];
                                        console.log('File: '+movedFile+' moved to '+movedTo);
                                    }
                                }

                            }
                        });
                    }

                    function refresh(){
                        $(":ui-draggable").draggable("destroy");
                        var selectedFiles = [];
                        selectedFiles.length = 0;
                        console.log($('tr.checked'));
                        //get all services checked
                        $('tr.checked').each(
                            function(){
                                console.log('please');
                                var filedata = [];
                                filedata.push({
                                    'from-tableid': $(this).closest('table').attr('id'),
                                    'from-service': $(this).closest('table').data('service'),
                                    'from-accountid': $(this).closest('table').data('accountid'),
                                    'from-path': $(this).data('path'),
                                    'from-isdir': $(this).data('isdir'),
                                    'html-append': $(this)[0].outerHTML
                                })
                                selectedFiles.push(filedata);
                            }
                        )
                        console.log(selectedFiles);
                        $( ".draggable tr.checked" ).draggable({
                            helper: "clone",
                            cursor: "move",
                            cursorAt: { left: 5 },
                            revert: "invalid",
                            zIndex: 99999,
                            start: function(event, ui) {
                                //get every single data for class checked!
                                ui.helper.data('dropped', false);
                                ui.helper.data('over-folder', false);
                                ui.helper.data('selectedFiles', selectedFiles);
                                
                                moveFile();
                            },
                            stop: function(event, ui){
                                //console.log('stop: dropped=' + ui.helper.data('dropped'));
                                // Check value of ui.helper.data('dropped') and handle accordingly...
                                if(ui.helper.data('dropped')){
                                    $(".draggable tr.checked").remove();
                                }
                                
                                    //refresh on every file move
                            }
                        });
                    }
                })   
            </script>
            <script id = "dynamic_table_singular">
            <div class="row animated fadeInRight">
            <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Custom responsive table </h5>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-sm-3" style="float: right;">
                                    <div class="input-group"><input type="text" placeholder="Search" class="input-sm form-control"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary"> Go!</button> </span></div>
                                </div>
                            </div>
                            <div class="table-responsive droppable">
                                <table id="service1" data-accountid="7777" data-service="78" data-curdir="/" class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>File </th>
                                        <th>Completed </th>
                                        <th>Task</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="draggable single">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </script>

