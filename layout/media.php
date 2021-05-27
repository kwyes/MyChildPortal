<div class="main-panel">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
            <div class="navbar-wrapper">
                <div class="navbar-minimize">
                    <button id="minimizeSidebar" class="btn btn-icon btn-round">
                        <i class="nc-icon nc-minimal-right text-center visible-on-sidebar-mini"></i>
                        <i class="nc-icon nc-minimal-left text-center visible-on-sidebar-regular"></i>
                    </button>
                </div>
                <div class="navbar-toggle">
                    <button type="button" class="navbar-toggler">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </button>
                </div>
                <div class="page-title">Media</div>
            </div>
        </div>
    </nav>
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><i class="material-icons-outlined card-icon">photo_library</i>Photo &
                            Video
                            Gallery
                        </h4>
                        <div class="card-category">
                            <p><span class="gradebook-classinfo"></span></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row text-center text-lg-left gallery-folder-container">
                        </div>
                    </div>
                    <!-- end content-->
                </div>
                <!--  end card  -->
            </div>
            <!-- end col-md-12 -->
        </div>
        <!-- end row -->
    </div>
    <?php include_once('layout/spinner.html'); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            var galleryFolderId = "";
            toggleSpinner();
            getGalleryFolder('V3356');
            $('.gallery-folder').click(function (event) {
                var target = $(event.target).closest('a');
                galleryFolderId = target.attr('data-id');
                post_to_url("?page=mediadetail", {
                    "folder": galleryFolderId
                });
            })
        })

        $(window).on('load', function () {
            toggleSpinner();
        })
    </script>
