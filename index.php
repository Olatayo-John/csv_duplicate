<?php
session_start();

include "connection.php";

?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://kit.fontawesome.com/ca92620e44.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
button.btn {
    border-radius: 0;
}
</style>

<?php if (isset($_SESSION['error'])) : ?>
    <?php if (time() < $_SESSION['time'] + 10) : ?>
        <div class="text-danger text-left container mt-3 font-weight-bolder">
            <?php echo $_SESSION['error']; ?>
        </div>
    <?php else : ?>
        <?php session_unset(); ?>
    <?php endif; ?>
<?php endif; ?>
<?php if (isset($_SESSION['succ'])) : ?>
    <?php if (time() < $_SESSION['time'] + 10) : ?>
        <div class="text-success text-left container mt-3 font-weight-bolder">
            <?php echo $_SESSION['succ']; ?>
        </div>
    <?php else : ?>
        <?php session_unset(); ?>
    <?php endif; ?>
<?php endif; ?>

<div class="col-md-6 container d-flex mt-5">
    <button type="button" class=" btn btn-success up_db_csv_btn">Database</button>
    <div class="col"></div>
    <button type="button" class=" btn btn-dark up_fil_csv_btn">Filter</button>
</div>

<div class="container col-md-6 pr-3 pl-3">

    <div class="up_db_csv_div">
        <div class="text-dark text-center font-weight-bolder mb-3 mt-3">Upload data to Database for comparison</div>
        <form method="POST" action="csvuploaddb.php" enctype="multipart/form-data">
            <div class="text-danger font-weight-bolder">File must be in CSV Format</div>
            <div class="text-danger font-weight-bolder">Only two headers of "Name" and "Mobile"</div>
            <input type="file" accept=".csv" name="csvuploaddb" class="csvuploaddb form-control" required>
            <hr>
            <div class="text-right">
                <button class="btn btn-outline-dark db_upload_btn" type="submit">Upload to DB</button>
            </div>
        </form>
    </div>

    <div class="up_fil_csv_div" style="display:none">
        <div class="text-dark text-center font-weight-bolder mb-3 mt-3">Upload data to remove any duplicate present in CSV File and Database</div>
        <form method="POST" action="csvuploadfilter.php" enctype="multipart/form-data">
            <div class="text-danger font-weight-bolder">File must be in CSV Format</div>
            <div class="text-danger font-weight-bolder">Only two headers of "Name" and "Mobile"</div>
            <input type="file" accept=".csv" name="csvupload" class="csvupload form-control" required>
            <hr>
            <div class="text-right">
                <button class="btn btn-outline-dark filter_up_btn" type="submit" title="Your file will be downloaded upon finish!">Upload and Filter</button>
            </div>
        </form>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();

        $(document).on("click", ".up_fil_csv_btn", function() {
            $(this).removeClass("btn-dark").addClass("btn-success");
            $(".up_fil_csv_div").show();
            $(".up_db_csv_div").hide();
            $(".up_db_csv_btn").removeClass("btn-success").addClass("btn-dark");
        });

        $(document).on("click", ".filter_up_btn", function() {
            var csv_data = $(".csvupload").val();
            if (csv_data == null || csv_data == "") {
                $(".csvupload").css('border', "1px solid red");
                return false;
            } else {
                $(".csvupload").css('border', "1px solid green");
                // window.location = this.href;
                return true;
                $(".filter_up_btn").removeClass("btn-dark").addClass("btn-danger");
                $(".filter_up_btn").html("Uploading..");
                $(".filter_up_btn").css("disabled", "disabled");
            }
        });

        $(document).on("click", ".up_db_csv_btn", function() {
            $(this).removeClass("btn-dark").addClass("btn-success");
            $(".up_fil_csv_div").hide();
            $(".up_fil_csv_btn").removeClass("btn-success").addClass("btn-dark");
            $(".up_db_csv_div").show();
        });

        $(document).on("click", ".db_upload_btn", function() {
            var csv_data = $(".csvuploaddb").val();
            if (csv_data == null || csv_data == "") {
                $(".csvuploaddb").css('border', "1px solid red");
                return false;
            } else {
                $(".csvuploaddb").css('border', "1px solid green");
                // window.location = this.href;
                return true;
                $(".db_upload_btn").removeClass("btn-dark").addClass("btn-danger");
                $(".db_upload_btn").html("Uploading..");
                $(".db_upload_btn").css("disabled", "disabled");
            }
        });
    });
</script>