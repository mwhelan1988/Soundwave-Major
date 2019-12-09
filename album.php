<?php include("includes/includedFiles.php"); 

if(isset($_GET['id'])) {
	$albumId = $_GET['id'];
}
else {
	header("Location: index.php");
}

$album = new Album($conn, $albumId);

$artist = $album->getArtist();

?>

<div class="entity-info">
	<div class="left-section">
		<img src="<?php echo $album->getArtworkPath(); ?>" alt="">
	</div>

	<div class="right-section">
		<h2><?php echo $album->getTitle(); ?></h2>
		<p>By <?php echo $artist ->getName();?></p>
		<p> <?php echo $album ->getNumberOfSongs();?> Songs</p>
	</div>
</div>

<div class="track-list-container">
	<ul class="track-list">
		<?php
		 //gets list of song ids for album
		$songIdArray = $album->getSongIds();

		$i=1;
		foreach($songIdArray as $songId){
			$albumSong = new Song($conn, $songId);
			$albumArtist = $albumSong->getArtist();
			echo "<li class='track-list-row'>

				<div class='container'>
					<div class='row'>

						<div class='track-count'>
								<i class='fas fa-play' onclick='setTrack(\"". $albumSong->getId() ."\", tempPlaylist, true)'></i>
								<span class='track-number'>$i</span>
						</div>

						<div class='track-info'>
							<span class='track-name'>" . $albumSong->getTitle() . " </span>
							<span class='artist-name'>" . $albumArtist->getName() . "</span>
						</div>

						<div class=''track-options> <i class='fas fa-ellipsis-h fa-lg dot-icon'></i></div>
		
						<div class='track-duration'>
							<span class='duration'>" . $albumSong->getDuration() . "</span>
						</div>

					</div>
				</div>
			</li>
			";
			$i = $i+1;
		}
		?>

		<script>
			var tempSongIds = '<?php echo json_encode($songIdArray);?>';
			tempPlaylist = JSON.parse(tempSongIds);
		</script>

	</ul>
</div>



