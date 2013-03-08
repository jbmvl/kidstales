<?php
	if(!$ajaxRequest) require "partials/header.php"
?>

 		<div id="main">
			<section id="explanations">
				<div>
					<h1>Nouveau groupe</h1>

					<div class="center">
						<button>Importer un groupe existant</button><br />
						<small>Vous pourrez modifier le groupe par la suite</small>
					</div>

					<form id="dynamicAdd" class="inline" method="post">
						<div>
							<p class="kid_line">
								<input type="text" name="kids_surname[]" placeholder="Prénom" method='POST' />
								<select name="kids_sex[]" method='POST'>
									<option value="null" label="sexe..." selected disabled />
									<option value="1" label="garçon" />
									<option value="0" label="fille" />
								</select> 
								<input type="text" name="kids_parents_mail[]" placeholder="Mail de ses parents" method='POST' />
								<input type="button" class="delete_line" value="Supprimer" />
							</p>

						</div>

						<p>
							<input type="button" class="add_line" value="Ajouter une line" />
						</p>
						<p>
							<input type="submit" value="Inscrire ce groupe" />
						</p>
					</form>
				<div>
			</section>
		</div>

		<?php require "partials/sidebar.php"; ?>

<?php
	if(!$ajaxRequest) require "partials/footer.php"
?>
