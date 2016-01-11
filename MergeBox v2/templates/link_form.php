<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <form action="link_accounts.php" method="POST">
                <input type="hidden" name="service" value="GDrive" /> 
                <div class="col-xs-6 col-sm-3" onClick="javascript:this.parentNode.submit();">
                    <div class="contact-box">
                        <div class="col-sm-12">
                            <img style=" max-width:100%;max-height:100%;" src="http://cdn.makeuseof.com/wp-content/uploads/2013/04/google_drive_transparent_300.png?84ec63">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </form>
            <form action="link_accounts.php" method="POST">
                <input type="hidden" name="service" value="Dropbox" />
                <div class="col-xs-6 col-sm-3" onClick="javascript:this.parentNode.submit();">
                    <div class="contact-box">
                        <div class="col-sm-12">
                            <img style=" max-width:100%;max-height:100%;" src="https://cf.dropboxstatic.com/static/images/brand/glyph@2x-vflJ1vxbq.png">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </form action="link_accounts.php" method="POST">
                <input type="hidden" name="service" value="Box" />
                <div class="col-xs-6 col-sm-3">
                    <div class="contact-box">
                        <a href="profile.html">
                        <div class="col-sm-12">
                            <img style=" max-width:100%;max-height:100%;" src="https://www.splunk.com/content/dam/splunk2/images/logos/customers/box-logo-transparent.png">
                        </div>
                        <div class="clearfix"></div>
                            </a>
                    </div>
                </div>
            </div>
        </div>
        
         <!-- Mainly scripts -->
        <script src="js/jquery-2.1.1.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="js/inspinia.js"></script>
        <script src="js/plugins/pace/pace.min.js"></script>

        <!-- Toastr script -->
        <script src="js/plugins/toastr/toastr.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.contact-box').each(function() {
                    animationHover(this, 'pulse');
                });
            });
        </script>
        <?php if (isset($link) && $link == "success") { ?>
            <script>history.replaceState('', "Link Accounts", "link.php");</script>
            <script>
                toastr.options = {
                  "closeButton": true,
                  "debug": false,
                  "progressBar": true,
                  "positionClass": "toast-top-right",
                  "onclick": null,
                  "showDuration": "400",
                  "hideDuration": "1000",
                  "timeOut": "7000",
                  "extendedTimeOut": "1000",
                  "showEasing": "swing",
                  "hideEasing": "linear",
                  "showMethod": "fadeIn",
                  "hideMethod": "fadeOut"
                }
                toastr["success"]("Your "+ "<?php echo $service ?>" +" account was added")
            </script>
        <?php } else if (isset($link) && $link == "failure"){?>
            <script>
                toastr["error"]("Hi, welcome to Inspinia. This is example of Toastr notification box.")
            </script>
        <?php } ?>