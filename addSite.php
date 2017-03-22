<?php
include_once( 'header.php' );
?>
<div class="container">
	<div class="row">
		<div class="offset-2 col-md-8">
			<form method="post" action="tasks.php">
				<input type="hidden" name="cron" value="addSite">
				<div class="row">
					<div class="col-lg-6 col-xs-12">
						<label for="siteName">Your site name</label>
						<div class="input-group">
							<input type="text" class="form-control" name="siteName" />
						</div>
					</div>
					<div class="col-lg-6 col-xs-12">
						<label for="siteUrl">Your site url</label>
						<div class="input-group">
							<input type="text" class="form-control" name="siteUrl" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-xs-12">
						<label for="gaCode">Google Analytics Code</label>
						<div class="input-group">
								<input type="text" class="form-control" name="siteGa" />
						</div>
					</div>
					<div class="col-lg-6 col-xs-12">
						<label for="gaCode">Should this site be indexable? <br />( Searchable by google etc.. )</label>
						<div class="input-group">
							<input type="checkbox" class="form-control" name="siteIndexable" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="offset-6 col-lg-6 col-xs-12">
						<br />
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
