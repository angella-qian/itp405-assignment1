<?php
	
	$pdo = new PDO('sqlite:chinook.db');
	$sql = "SELECT genres.Name AS Genre
			FROM genres
			WHERE 1=1;";

	if (isset($_GET['search']) && !empty($_GET['search'])) {
		$sql = str_replace(';', '', $sql);
		$sql = $sql . " AND genres.Name = ?";
	}

	$statement = $pdo->prepare($sql);

	if (isset($_GET['search']) && !empty($_GET['search'])) {
		$statement->bindParam(1, $_GET['search']);
	}

	$statement->execute();
	$genres = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Assignment 1 | Genres Table</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <style>
  	body {
  		margin: 50px;
  	}
</style>
</head>
<body>
	<h1>Genres</h1>
	<form action="index.php" method="GET">
		<input type="text"
			   name="search"
			   value="<?php echo isset($_GET['search']) ? $_GET['search'] : ' ' ?>">
		<button class="btn btn-primary" type="submit">Search</button>
		<a href="/" class="btn btn-light">Clear</a>
	</form><br/>
	<table class="table">
		<tr>
			<th>Genre</th>
			<th>Associated Tracks</a>
		</tr>

		<?php foreach($genres as $genre) : ?>
			<tr>
				<td>
					<?php echo $genre->Genre; ?>
				</td>
				<td>
					<a href="tracks.php?genre=<?php echo urlencode($genre->Genre); ?>">View Tracks</a>
				</td>
			</tr>
		<?php endforeach; ?>
		<?php if (count($genres) === 0) : ?>
			<tr>
				<td colspan="2">No genres were found.</td>
			</tr>
		<?php endif; ?>
	</table>

</body>
</html>