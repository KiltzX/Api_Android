<?php
//CONECTAR AO BANCO!
$servidor = "127.0.0.1:3306";
$usuario = "crm_admin";
$senha = "senai";
$banco = "crm";
	

$pdo = new PDO("mysql:host=$servidor;dbname=$banco", "$usuario", "$senha"); 
$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
$conexao = mysqli_connect($servidor, $usuario,
	$senha, $banco);
if(!$conexao){
	die(mysqli_error($conexao));
}
//se o comando foi enviado...
$comando = verificaValorPost("comando");
if($comando === "teste"){
	// se o valor foi setado
	$valor = verificaValorPost('valor');
	//enviar duplicado de volta para o android
	echo("$valor $valor");
}
else if($comando == 'inserir'){
	/*$resultado = mysqli_query($conexao, 
		"INSERT INTO clientes 
		(nome,cpf,sexo,endereco,cidade,estado,telefone)
		VALUES (\"$nome\", \"$cpf\",\"$sexo\",
			\"$endereco\", \"$cidade\",\"$estado\",
			\"$telefone\") ");*/
			//echo($_POST["nome"]);
	$cpf = verificaValorPost('cpf');
	$nome = verificaValorPost('nome');
	$endereco = verificaValorPost('endereco');
	$telefone = verificaValorPost('telefone');
	$data = [
		[$cpf, $nome, $endereco, $telefone]
	];
	$sql = "INSERT INTO cliente
		(cpf,nome,endereco,telefone) VALUES (?,?,?,?)";
	$stmt= $pdo->prepare($sql);
	try {
		$pdo->beginTransaction();
		foreach ($data as $row)
		{
			$stmt->execute($row);
		}
		$pdo->commit();
		echo("insert ok");
	}catch (Exception $e){
		$pdo->rollback();
		echo("insert erro ".$e->getCode());
		switch($e->getCode()){
			case 23000:
				echo(" CPF já existente!");
			break;
			case 22001:
				echo(" Algum campo excedeu o limite de caracteres");
			break;
		}
		//throw $e->getCode();
	}
}

function verificaValorPost($var){
	if(!isset($_POST["$var"])){
		echo("Faltou o $var");
	}
	return $_POST["$var"];
}

/*
$isDebug = false;
$jsonArray = array();
if(isset($_POST['teste']) || $isDebug){
	if($isDebug) $_POST['teste'] = "debug";
	array_push($jsonArray, 
		array('resultado'=>$_POST['teste'].''.$_POST['teste']));
	//equivalente à $jsonArray['resultado'] = 'OK';
	echo json_encode(array('teste'=>$jsonArray));
}

//verifica se a chave do $_POST está preenchida ou não
if(isset($_POST['comando']))$comando = $_POST['comando'];
if(isset($_POST['nome']))$nome = $_POST['nome'];
else $nome = '';
if(isset($_POST['cpf']))$cpf = $_POST['cpf'];
else $cpf = '';
if(isset($_POST['sexo']))$sexo = $_POST['sexo'];
else $sexo = '';
if(isset($_POST['endereco']))$endereco = $_POST['endereco'];
else $endereco = '';
if(isset($_POST['cidade']))$cidade = $_POST['cidade'];
else $cidade = '';
if(isset($_POST['estado']))$estado = $_POST['estado'];
else $estado = '';
if(isset($_POST['telefone']))$telefone = $_POST['telefone'];
else $telefone = '';

if($comando == 'inserir' || $isDebug){
	if($isDebug){}
	$resultado = mysqli_query($conexao, 
		"INSERT INTO clientes 
		(nome,cpf,sexo,endereco,cidade,estado,telefone)
		VALUES (\"$nome\", \"$cpf\",\"$sexo\",
			\"$endereco\", \"$cidade\",\"$estado\",
			\"$telefone\") ");
}elseif($comando == 'alterar' || $isDebug){
	if($isDebug){}
	$resultado = mysqli_query($conexao, 
		"UPDATE clientes 
		SET nome=\"$nome\", sexo=\"$sexo\",
			endereco=\"$endereco\", cidade=\"$cidade\",
			estado=\"$estado\", telefone=\"$telefone\"
		WHERE cpf=\"$cpf\"; ");
}elseif($comando == 'excluir' || $isDebug){
	if($isDebug){}
	$resultado = mysqli_query($conexao, 
		"DELETE FROM clientes WHERE cpf=\"$cpf\"; ");
}
elseif ($comando == 'buscarCpf' || $isDebug) {
	if($isDebug){}
	$resultado = mysqli_query($conexao, 
		"SELECT * FROM clientes WHERE cpf=\"$cpf\" ;");
	if($resultado){
		$linha = mysqli_fetch_array($resultado);
		$registros = array();
		//extraindo os dados do bd
		$linha2 = array(
			'nome'=>$linha['nome'], 
			'cpf'=>$linha['cpf'],
			'sexo' =>$linha['sexo'],
			'endereco' =>$linha['endereco'],
			'cidade'=>$linha['cidade'],
			'estado'=>$linha['estado'],
			'telefone'=>$linha['telefone']);
		array_push($registros, $linha2);
		array_push($jsonArray, array('registros'=>$registros));
	}
}
elseif ($comando == 'buscarNome' || $isDebug) {
	if($isDebug){}
	$resultado = mysqli_query($conexao, 
		"SELECT * FROM clientes WHERE nome LIKE \"%$nome%\" ;");
	if($resultado){
		$registros = array();
		while($linha = mysqli_fetch_array($resultado)){
			$linha2 = array(
			'nome'=>$linha['nome'], 
			'cpf'=>$linha['cpf'],
			'sexo' =>$linha['sexo'],
			'endereco' =>$linha['endereco'],
			'cidade'=>$linha['cidade'],
			'estado'=>$linha['estado'],
			'telefone'=>$linha['telefone']);
			array_push($registros, $linha2);
		}
		array_push($jsonArray, array('registros'=>$registros));
	}
}
if($resultado){
							//B 				C
	array_push($jsonArray, array('resultado'=>'OK'));
}else{
	array_push($jsonArray, array('resultado'=>'NOK'));
}
						//A
echo json_encode(array($comando=>$jsonArray));
/*
//echo("$nome, $cpf, $sexo, $endereco, $cidade, $estado, $telefone, $operacao");

if($sexo == "masculino") $sexo = "M";
else $sexo = "F";


if($operacao == "Inserir"){
	

}elseif($operacao == "Alterar"){
	$resultado = mysqli_query($conexao, 
		"UPDATE clientes 
		SET nome=\"$nome\", sexo=\"$sexo\",
			endereco=\"$endereco\", cidade=\"$cidade\",
			estado=\"$estado\", telefone=\"$telefone\"
		WHERE cpf=\"$cpf\"; ");
	if($resultado){
		echo("<br>Dados atualizados com sucesso!");
	}else{
		echo("<br>Os dados não puderam ser atualizados. Erro:");
		mysqli_error($conexao);
	}
}elseif($operacao == "Excluir"){
	$resultado = mysqli_query($conexao,
		"DELETE FROM clientes WHERE cpf=\"$cpf\"; ");
	if($resultado) echo("<br>Dados deletados com sucesso!");
	else echo("<br>Os dados não puderam ser excluídos.");
}
elseif($operacao == "Buscar por CPF"){
	$resultado = mysqli_query($conexao,
		"SELECT * FROM clientes WHERE cpf=\"$cpf\" ;");
	while($linha = mysqli_fetch_array($resultado)){
		echo(''.$linha['nome'].
			' '.$linha['cpf'].
			' '.$linha['telefone']);
		//header("Location: index.php");
	}
}else if($operacao == "Buscar por nome"){
	$resultado = mysqli_query($conexao,
		"SELECT * FROM clientes WHERE nome LIKE \"%$nome%\" ;");
	if($resultado){
		echo("<table style=\"border:1px solid black\">
				<tr>
				<th>Nome</th>
				<th>CPF</th>
				<th>Sexo</th>
				<th>Endereço</th>
				<th>Cidade</th>
				<th>Estado</th>
				<th>Telefone</th>
				</tr>");
		while($linha = mysqli_fetch_array($resultado)){
			echo("<tr>
				<td>".$linha['nome']."</td>
				<td>".$linha['cpf']."</td>
				<td>".$linha['sexo']."</td>
				<td>".$linha['endereco']."</td>
				<td>".$linha['cidade']."</td>
				<td>".$linha['estado']."</td>
				<td>".$linha['telefone']."</td>
				</tr>");
		}
		echo("</table>");
	}else{
		echo("<br>Os dados não puderam ser buscados.");
	}
	
}
*/
?>