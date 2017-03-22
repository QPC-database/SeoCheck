<?php
	include_once( 'header.php' );
?>
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
				<?php if( $rows = $database->get_field()) { ?>
					<?php foreach( $rows as $row ) { ?>
						<tr <?php echo ($row->gaPreviousState || $row->indexPreviousState) ? "class='bg-danger'" : " " ?>>
							<td><?php echo $row->id; ?></td>
							<td><?php echo $row->title; ?></td>
							<td><a href="<?php echo $row->url; ?>"><?php echo $row->url; ?></a></td>
							<td><?php echo $row->ga_code; ?></td>
							<td><?php echo ( $row->indexNeeded ) ? "Yes" : "No" ?></td>
						</tr>
					<?php } ?>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?php
include_once( 'footer.php' );
