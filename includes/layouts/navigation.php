<ul class="subjects">
				<?php
					while ($subject = mysqli_fetch_assoc($subject_set)) {
				?>
					<?php 
						echo "<li";
						if($subject["id"] == $current_subject){
							echo " class=\"selected\"";
						}
						echo">";
					?>
						<a href="manage_content.php?subject=<?php echo urlencode($subject["id"]); ?>"><?php echo  $subject["menu_name"]; ?></a>
						<?php
								$page_set=find_pages_for_subjects($subject["id"]);
							?>
						<ul class="pages">
							<?php
								while ($pages = mysqli_fetch_assoc($page_set)) {
							?>
								<?php 
									echo "<li";
									if($pages["id"] == $current_page){
									    echo " class=\"selected\"";
									}
									echo">";
					?>
									<a href="manage_content.php?page=<?php echo urlencode($pages["id"]); ?>"><?php echo  $pages["menu_name"];?></a>
								</li>
							<?php
								}
								mysqli_free_result($page_set);
							?>

						</ul><!-- end of pages ul -->
					</li>
					<?php
					}
						mysqli_free_result($subject_set);
					?>
			</ul><!-- End of subject ul -->
			

			