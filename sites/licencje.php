<div class="mdl-grid" style="max-width:1000px;">

	<div class="mdl-card mdl-shadow--6dp mdl-cell mdl-cell--12-col card">

        <div class="mdl-card__title card-tittle" style="background-color: #607d8b;">
            <h2 class="mdl-card__title-text rnt-card-title-text">Licencje</h2>
        </div>

        <div class="mdl-card__supporting-text" style="overflow: auto;">


        <?php

            $files = glob("licenses/*.txt");
						$list = "<ul'>";
						$lic = "";


            foreach($files as $file) {

                $handle = fopen($file, "r");
                $contents = fread($handle, filesize($file));
                fclose($handle);

                $file = basename($file, ".txt");


								$list .= "<li><a href='#" . str_replace(' ', '', $file) . "'>";
								$list .= ucwords($file);
								$list .= "</a></li>";

								$lic .= "<pre style='font-weight: bold; font-size: 12px;' id='" . str_replace(' ', '', $file) . "'><h4>" . ucwords($file) . "</h4>" . $contents . "</pre><br>";


            }

						$list .= "</ul>";

						echo $list;
						echo $lic;

        ?>

        </div>

    </div>


</div>
