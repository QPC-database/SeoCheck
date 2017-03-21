<?php
require_once('init.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>SEO Check</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
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
			        <a class="nav-link active" href="/">Home</a>
			      </li>
						<li class="nav-item">
			        <a class="nav-link" href="/">Settings</a>
			      </li>
			    </ul>
			  </div>
			</nav>
		</header>
		<div class="container">
			<div class="row">
				<table class="table mt-4">
					<thead>
						<tr>
							<th>ID</th>
							<th>Site Name</th>
							<th>URL</th>
							<th>GA Code</th>
							<th>Indexable</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach( $database->get_field() as $row ) { ?>
							<tr>
								<td><?php echo $row->id; ?></td>
								<td><?php echo $row->title; ?></td>
								<td><a href="<?php echo $row->url; ?>"><?php echo $row->url; ?></a></td>
								<td><?php echo $row->ga_code; ?></td>
								<td><?php echo $row->indexNeeded; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>
