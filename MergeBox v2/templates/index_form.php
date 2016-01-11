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
                    </div>
                </div>
            </div>
        </div>
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
                            <div class="table-responsive">
                                <table class="table table-hover">
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
                                    <tbody class="connectedSortable">
                                    <tr>
                                        <td><input type="checkbox"  checked class="i-checks" name="input[]"></td>
                                        <td><span class="pie">0.52/1.561</span></td>
                                        <td>Project<small>This is example of project</small></td>
                                        <td>20%</td>
                                        <td>Jul 14, 2013</td>
                                        <td><a href="#"><i class="fa fa-check text-navy"></i></a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

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

            <!-- iCheck -->
            <script src="js/plugins/iCheck/icheck.min.js"></script>

            <!-- Peity -->
            <script src="js/demo/peity-demo.js"></script>

            <script src="js/jquery-ui-1.10.4.min.js"></script>
            <script>
                $(document).ready(function(){
                    $('.i-checks').iCheck({
                        checkboxClass: 'icheckbox_square-green',
                        radioClass: 'iradio_square-green',
                    });
                
                $(document).ready(function() {
                    $("tbody.connectedSortable").sortable({
                        connectWith: ".connectedSortable",
                        helper: "clone",
                        cursor: "move",
                        zIndex: 99999,
                        receive: function(event, ui) {
                          /* here you can access the dragged row via ui.item
                             ui.item has been removed from the other table, and added to "this" table
                          */
                            var addedTo = $(this).closest("table.mytable"),
                            removedFrom = $("table.mytable").not(addedTo);
                          alert("The ajax should be called for adding to " + addedTo.attr("id") + " and removing from " + removedFrom.attr("id"));
                        }
                      });
                    });
                });
                
            </script>

