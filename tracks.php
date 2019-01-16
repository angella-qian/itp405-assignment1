<?php
	
	$pdo = new PDO('sqlite:chinook.db');
	$sql = "SELECT tracks.Name as trackName,
				   albums.Title as albumTitle,
				   artists.Name as artistName,
				   tracks.UnitPrice as price,
				   genres.Name as genre
				   FROM tracks
				   INNER JOIN genres
				   ON tracks.GenreId = genres.GenreId
				   INNER JOIN albums
				   on tracks.AlbumId = albums.AlbumId
				   INNER JOIN artists
				   on artists.ArtistId = albums.ArtistId
				   WHERE 1=1;";

	if (isset($_GET['genre']) && !empty($_GET['genre'])) {
		$sql = str_replace(';', '', $sql);
		$sql = $sql . " AND genres.Name = ?";
	}

	$statement = $pdo->prepare($sql);

	if (isset($_GET['genre']) && !empty($_GET['genre'])) {
		$statement->bindParam(1, $_GET['genre']);
	}

	$statement->execute();
	$tracks = $statement->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Assignment 1 | Tracks Table</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <style>
  	body {
  		margin: 50px;
  	}
</style>
</head>
<body>
	<h1>Associated Tracks</h1><br/>
	<table class="table">
		<tr>
			<th>Track Name</th>
			<th>Album Title</th>
			<th>Artist Name</th>
			<th>Price</th>
			<th>Genre</th>
		</tr>
		<?php foreach($tracks as $track) : ?>
			<tr>
				<td>
					<?php echo $track->trackName; ?>
				</td>
				<td>
					<?php echo $track->albumTitle; ?>
				</td>
				<td>
					<?php echo $track->artistName; ?>
				</td>
				<td>
					<?php echo $track->price; ?>
				</td>
				<td>
					<?php echo $track->genre; ?>
				</td>

			</tr>
		<?php endforeach; ?>
		<?php if (count($tracks) === 0) : ?>
			<tr>
				<td colspan="4">No tracks were found.</td>
			</tr>
		<?php endif; ?>
	</table>

</body>
</html>