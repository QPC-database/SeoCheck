<?php
	require 'init.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>SEO Check</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<header>
			<nav class="navbar navbar-toggleable-md navbar-light bg-faded">
				<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
				</button>
				<a class="navbar-brand" href="#">SeoCheck</a>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link" href="/">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link active" href="/settings.php">Settings</a>
						</li>
					</ul>
				</div>
			</nav>
		</header>
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
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
