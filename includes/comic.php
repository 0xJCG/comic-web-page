				<img src="images/comics/<?php print $comic_path; ?>" alt="<?php print $comic_title; ?>" />
				<p class="datos"><?php print $comic_date; ?> | <a href="/comic/index.php?comic=<?php print $comic_id; ?>">Permalink</a> |
<?php
	/* We have to check if we are showing the first comic, the last or the only one. */
	if ($prev == NULL AND $next != NULL)
		print "\t\t\t\t" . '<a href="index.php?comic=' . $next . '">Next &gt;</a> | <a href="index.php?new">Newest &gt;&gt;</a></p>' . "\n"; // If we are showing the first comic, we only have to show the next and the newest links.
	elseif ($next == NULL AND $prev != NULL)
		print "\t\t\t\t" . '<a href="index.php?first">&lt;&lt; First</a> | <a href="index.php?comic=' .  $prev . '">&lt; Previous</a></p>'. "\n"; // If we are showing the last comic, we only have to show the previoua and the oldest links.
	elseif ($next == NULL AND $prev == NULL)
		print "\t\t\t\t" . '</p>' . "\n"; // If we are showing the only comic, we don't show any links.
	else
		print "\t\t\t\t" . '<a href="index.php?first">&lt;&lt; First</a> | <a href="index.php?comic=' . $prev . '">&lt; Previous</a> | <a href="index.php?comic=' .  $next . '">Next &gt;</a> | <a href="index.php?new">Newest &gt;&gt;</a></p>' . "\n";
?>