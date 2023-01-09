<?php session_start(); ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://kit.fontawesome.com/ca92620e44.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
button {
	border-radius: 0;
}
</style>


<?php if (isset($_SESSION['error'])) : ?>
	<div class="text-danger text-left container mt-3 font-weight-bolder">
		<?php echo $_SESSION['error']; ?>
	</div>
<?php endif; ?>


<div class="container mt-5 col-md-6">
	<form method="POST" action="csvuploadproccess.php" enctype="multipart/form-data">
		<div class="text-danger font-weight-bolder">File must be in CSV Format</div>
		<div class="text-danger font-weight-bolder">Only two headers of "Name" and "Mobile"</div>
		<input type="file" accept=".csv" name="csvupload" class="csvupload form-control">
		<hr>
		<button class="btn btn-dark" type="submit">Upload CSV and Filter</button>
	</form>
</div>