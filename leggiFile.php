<!DOCTYPE HTML>
<html>
	<head>
    	<title>Prova</title>
        <!--<link rel="stylesheet" type="text/css" href="stiliCss.css">-->
		 <!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script type="text/javascript"> 
		/*Funzione della libreria JQuery necessaria all'esecuzione di AJAX*/
			//La funzione viene eseguita quando l'intero documento viene caricato.
			$(document).ready(function()
			{
				//Definizione della variabile "dati", contenente i risultati dell'elaborazione della pagina php.
				var dati; 
						//La funzione viene eseguita quando si verifica l'evento "change".
						$("#estensioni").change(function(){ 
							//Prelevamento dei dati dal form.
							dati = $("#estensioni").serialize();
							//Chiamata Ajax di tipo "POST".
							$.ajax({     
								type: "POST",   
								url: "http://localhost/cercaFile.php",  
								data: dati, 
								success: function(response){ 
									//Append dei dati restituiti sull'apposita area di testo.
									$("#risultato").html(response); 
								} 
							});  
						});  
			});
		</script>
		
    </head>
    <body>
		<div class="col-md-4">
		</div>
		<div class="col-md-4">
    <h1>ELENCO ESTENSIONI</h1>
    <form action="cercaFile.php" method="post" class="form-group">
    	<select class="form-control" name ="select[]" id="estensioni">
		<option value="Tutti">Tutti i file</option>
					<?php

						  function estraiEstensione($filename) 
						  {
							$ext = explode(".", $filename);
							return $ext[count($ext)-1];  
						  }
						  /*
						  $est = 'jpg';
						  $prova = glob('ElencoFile/*'.'.'.$est);
						  for($i=0;$i<count($prova);$i++)
						  {
							echo basename($prova[$i]."\n");
						  }
						  */
						  //Funzione "generaSelect()" che genera la select in maniera dinamica.
						  function generaSelect()
						  {
						  //L'elenco dei file viene memorizzato in un array.
						  $elencoFile = array(); //Dichiarazione dell'array.
						  //Verifica se al percorso indicato è presente una cartella.
						  /*La funzione "opendir()" restituisce "true" se nel percorso indicato è presente una directory, false
						  se nel percorso indicato NON è presente una directory.*/
						  
						  $cartella = 'grafici';
							
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
							 
							 //Compattazione dell'array delle estensioni.
							 $arrayEstensioni = array();
							 for($i=0;$i<count($elencoFile)-1;$i++)
							 {
								for($j=$i+1;$j<count($elencoFile);$j++)
								{
									if(strcmp($elencoFile[$i],$elencoFile[$j])==0)
									{
										$elencoFile[$i]="0";
									}
								}
							 }
							//Inizializzazione dell'indice "j", necessario al caricamento del secondo vettore
							$j=0;
							//Carciamento del vettore "vet2"
							for($i=0;$i<count($elencoFile);$i++)
							{
								/*Se l'elemento con indice "i" del vettore non assume valore "0", il suo valore viene
								copiato nel vettore "$arrayEstensioni" e l'indice "j" viene incrementato di 1*/
								if(strcmp($elencoFile[$i],"0")!=0)
								{
									$arrayEstensioni[$j]=$elencoFile[$i];
									$j++;
								}
							}

							 //Il ciclo seguente serve a generare le opzioni contenute all'interno della select.
							 for($i=0;$i<count($arrayEstensioni);$i++)
							  {
								  echo ("<option value=\"$arrayEstensioni[$i]\">$arrayEstensioni[$i]</option>"."\n");
							  
							  }
						  }
						  else
						  {
						  //Se l'elemento indicato nel percorso non è una cartella viene generato un messaggio di errore.
						  echo ("<h1>ERRORE! Cartella non trovata</h1>");
						  }
						}
						//Invocazione della funzione "generaSelect()".
						generaSelect(); 
					?>
					</select>
					<textarea class="form-control" id="risultato" col="30" rows="10">
					</textarea>
				</form>
			</div>
		</form>
	</body>
</html>


