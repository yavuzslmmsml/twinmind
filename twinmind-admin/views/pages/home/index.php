<div id="kt_app_content" class="app-content flex-column-fluid">
    <!--begin::Content container-->
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::FAQ card-->
        <div class="card">
            <?php
            if (isset($_SESSION["user"])) {
                echo $_SESSION["user"]["email"];
            } else {
                echo "kullanıcı giris yapmamıs";
            }
            ?>
        </div>
        <!--end::FAQ card-->
    </div>
    <!--end::Content container-->
</div>