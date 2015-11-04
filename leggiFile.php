<!DOCTYPE HTML>
<html>
	<head>
    	<title>Prova</title>
        <link rel="stylesheet" type="text/css" href="stiliCss.css">
		 <!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		
    </head>
    <body>
		<div class="col-md-4">
		</div>
		<div class="col-md-4">
			<h3>ELENCO ESTENSIONI</h3>
			<form method="post" class="form-group" action=leggiFile.php>
				<select class="form-control" name ="select[]" id="estensioni" onchange=submit();>
					<option value="Tutti">Tutti i file</option>
					<?php
						$DIRECTORY_RICERCA='grafici';
						/*-------------DEFINIZIONE DELLE FUNZIONI-------------*/
						/*-------------Funzione "estraiEstensione()", necessaria a ricavare l'estensione dato il nome di un file.-------------*/
						function estraiEstensione($filename) 
						{
							//Ottengo l'estensione del file.
							$ext = explode(".", $filename);
							/*Restituisco l'elemento dell'array contenente l'estensione (ultimo elemento con indice pari alla dimensione
							dell'array diminuita di 1).*/
							return $ext[count($ext)-1];  
						}
						//-------------Funzione "generaSelect()" che genera la select in maniera dinamica-------------.
						function generaSelect($cartella)
						{
							//L'elenco dei file viene memorizzato in un array.
							$elencoFile = array(); //Dichiarazione dell'array.
							//Verifica se al percorso indicato è presente una cartella.
							/*La funzione "opendir()" restituisce "true" se nel percorso indicato è presente una directory, false
							se nel percorso indicato NON è presente una directory.*/	
							if($handle = opendir($cartella))
							{
								//Ciclo di scansione dei file contenuti nella cartella.
								/*Il ciclo continua finchè la funzione "readdir()" non restituisce valore "false" (fine dei file
								presenti nella cartella).*/
								while (($file = readdir($handle))!==false)
								{
									/*La seguente condizione serve a verificare che l'elemento preso in esame non sia la directory
									corrente (indicata con ".") o quella precedente (indicata con "..").*/
									if ($file != "." && $file != "..")
									{
										//Salvataggio del nome del file nell'array.
										$elencoFile[] = estraiEstensione($file);
									} 
								}
								//Chiusura della directory tramite la funzione "closedir()".
								closedir($handle);
								//Definizione dell'array "arrayEstensioni", contenente le estensioni da selezionare.
								$arrayEstensioni = array();
								//Compattazione dell'array delle estensioni.
								$arrayEstensioni = array_unique($elencoFile);
								//Il ciclo seguente serve a generare le opzioni contenute all'interno della select.
								echo("\n");
								foreach($arrayEstensioni as $extension)
								{
									$opzione="<option";
									if(isset($_POST['select']))
									{
										if(strcmp($extension,implode($_POST['select']))==0)
										{
											$opzione=$opzione." "."selected";
										}
									}
									$opzione=$opzione." "."value=\"$extension\">$extension</option>"."\n";
									echo ($opzione);
								}
								echo ("</select>");
							}
							else
							{
								//Se l'elemento indicato nel percorso non è una cartella viene generato un messaggio di errore.
								echo ("<h1>ERRORE! Cartella non trovata</h1>");
							}
							$htmlCode="<textarea class=\"form-control\" id=\"risultato\" col=\"30\" rows=\"10\">";
							echo($htmlCode);
							if(isset($_POST['select']))
							{
								cercaFile($cartella);
							}
							$htmlCode='</textarea>';
							echo($htmlCode);	  
						}
						//-------------Funzione "cercaFile()", necessaria alla ricerca dei file all'interno della cartella.-------------*/
						function cercaFile($cartella)
						{
							//Otteninmento dell'estensione del file.
							$estensione = implode($_POST['select']);
							//Array contenente l'elenco dei file.
							$elencoFile = array();
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
						}
						//Invocazione della funzione "generaSelect()".		
						generaSelect($DIRECTORY_RICERCA);
					?>
		    </form>
        </div>
	</body>
</html>