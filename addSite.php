<?php
include_once( 'header.php' );
?>
<div class="container">
	<div class="row">
		<div class="offset-2 col-md-8">
			<div class="alert-response alert alert-info mt-4 mb-4" role="alert">
			  <strong>Add a profile:</strong> insert new entries to the site list here
			</div>
			<form method="post" action="tasks.php" id="add-site-form">
				<input type="hidden" name="cron" value="addSite">
				<div class="row">
					<div class="col-lg-6 col-xs-12">
						<label for="siteName">Your site name</label>
						<div class="input-group">
							<input type="text" class="form-control" name="siteName" id="siteName" required />
						</div>
					</div>
					<div class="col-lg-6 col-xs-12">
						<label for="siteUrl">Your site url</label>
						<div class="input-group">
							<input type="url" class="form-control" name="siteUrl" id="siteUrl" required />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-xs-12">
						<label for="gaCode">Google Analytics Code</label>
						<div class="input-group">
								<input type="text" class="form-control" name="siteGa" id="gaCode" required />
						</div>
					</div>
					<div class="col-lg-6 col-xs-12">
						<label for="siteIndexable">Should this site be crawled by search engines?</label>
						<div class="input-group">
							<input type="checkbox" class="form-control" name="siteIndexable" id="siteIndexable" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-xs-12 mt-2">
						<button id="addSite" type="submit" class="btn btn-primary">Add site</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
include_once( 'footer.php' );
?>
