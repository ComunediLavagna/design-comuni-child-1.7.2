<?php
global $obj;
$obj = get_queried_object();

#print_r($obj); die();

if ($obj->taxonomy == "categorie_servizio")
	get_template_part("archive-servizio");
	
else if($obj->taxonomy == "argomenti")
	get_template_part("archive-argomento");
	
else if ($obj->taxonomy == "tipi_luogo")
	get_template_part("template-parts/luogo/tipo-luogo");
	
else if ($obj->taxonomy == "tipi_evento")
	get_template_part("template-parts/evento/tipo-evento");
	
else if ($obj->taxonomy == "tipi_documento")
	get_template_part("template-parts/documento/tipo-documento");
	
else if ($obj->taxonomy == "tipi_unita_organizzativa")
	get_template_part("template-parts/unita-organizzativa/tipo-unita-organizzativa");
	
else if ($obj->taxonomy == "tipi_notizia")
	get_template_part("template-parts/notizia/tipo-notizia");
	
else
	get_template_part("archive");
	
/*** TO DO: tipi_documento ***/
