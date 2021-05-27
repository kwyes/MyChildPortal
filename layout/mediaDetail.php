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
                        <h4 class="card-title"><i class="material-icons-outlined card-icon">camera_alt</i>Photo & Video
                            Gallery
                        </h4>
                        <div class="card-category">
                            <p><span class="gradebook-classinfo"></span></p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row text-center text-lg-left gallery-container">
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
    <?php include_once('layout/mediaModal.html'); ?>
    <?php include_once('layout/spinner.html'); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            toggleSpinner();
            var folderId = '<?=$_POST['folder']?>'
            getVideoPhotoGallery(folderId);
            $(".media_modal").click(function (event) {
                var target = $(event.delegateTarget);
                var dataid = target.attr("data-id");
                var media_modal = [];
                var item_tag = "";
                var html = "";
                var id;
                for (let i = 0; i < mediaGallery.length; i++) {
                    if (i == dataid) {
                        item_tag = '<div class="carousel-item active">';
                    } else {
                        item_tag = '<div class="carousel-item">'
                    }

                    if (mediaGallery[i].scheme == 'image') {
                        id = 'https://bodwell.canto.com/preview/image/' + mediaGallery[i].id + '/800';
                        html = item_tag + '<img src="' + id +
                            '" class="d-block" alt="..."></div>'
                    } else {
                        id = 'https://bodwell.canto.com/download/video/' + mediaGallery[i].id +
                            '/original';
                        html = item_tag +
                            '<video class="video-fluid embed-responsive-item" controls width="100%">' +
                            '<source src="' + id + '" type="video/mp4"></source>' +
                            '</video>' +
                            '</div>'
                    }
                    media_modal.push(html)
                }
                $('.carousel-inner').html(media_modal);
            });
        })

        $(window).on('load', function () {
            toggleSpinner();
        })
    </script>