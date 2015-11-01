<?php
/*Questo script PHP consente di cercare i file di una data estensione all'interno del percorso indicato.*/
//Ottenimento dell'estensione inserita dall'utente tramite la form.
$estensione = implode($_POST['select']);
//Array contenente l'elenco dei file.
$elencoFile = array();
//Cartelal di ricerca.
$cartella = 'grafici';
if(strcmp($estensione,"Tutti")!=0)
{
	//Se l'utente ha scelto di visualizzare i file di una specifica estensione essi vengono salvati nell'array mediante la funzione "glob()".
	$elencoFile = glob($cartella.'/'.'*'.'.'.$estensione);
	//Stampa dell'elenco dei file dell'estensione indicata.
	foreach($elencoFile as $file)
	{
		echo basename($file)."\n";
	}
}
/*Nel caso in cui l'utente abbia scelto di visualizzare l'elenco completo dei file presenti alla posizione indicata, lo script restituirà
il nome di tali files.*/
else
{
		if($handle = opendir($cartella))
		{	 
			while (($file = readdir($handle))!==false)
			{
				if ($file != "." && $file != "..")
				{
					echo $file."\n";
				} 
			}
			closedir($handle);
	}

	
}
	
?>