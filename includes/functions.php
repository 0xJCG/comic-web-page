<?php
	class Functions
	{
		var $servidor = "localhost";
		var $user = "root";
		var $pass = "";
		var $db = "comic";
		var $cn;
		function Connect()
		{
			$this->cn = new mysqli($this->servidor, $this->user, $this->pass, $this->db);
			if (mysqli_connect_errno())
				die("Connection failed: " . mysqli_connect_error());
		}
		function PerformQuery($sql, $items)
		{
			if ($stmt = $this->cn->prepare($sql))
			{
				$stmt->execute();
				switch ($items)
				{
					case 2:
						$stmt->bind_result($result[0], $result[1]);
						break;
					case 3:
						$stmt->bind_result($result[0], $result[1], $result[2]);
						break;
					case 5:
						$stmt->bind_result($result[0], $result[1], $result[2], $result[3], $result[4]);
						break;
				}
				$stmt->fetch();
				$stmt->close();
				return $result;
			}
			return FALSE;
		}
		function PerformInsert($sql)
		{
			if ($stmt = $this->cn->prepare($sql))
			{
				$stmt->execute();
				return TRUE;
			}
			return FALSE;
		}
		function Disconnect()
		{
			if ($this->cn)
				$this->cn->close();
		}
		function Login($user, $pass)
		{
			$query = sprintf("SELECT id, username, type FROM users WHERE username=\"%s\" AND password=\"%s\"", stripslashes(mysqli_real_escape_string($this->cn, $user)), stripslashes(mysqli_real_escape_string($this->cn, $pass)));
			$rs = $this->PerformQuery($query, 3);
			if (!empty($rs))
			{
				$_SESSION['id'] = $rs[0];
				$_SESSION['user'] = $rs[1];
				$_SESSION['type'] = $rs[2];
				return TRUE;
			}
			else
				return FALSE;
		}
		function ShowForm($number)
		{
			switch ($number)
			{
				case 1:
?>
				<form action="login.php" method="post">
					<p>
						<label>
							Usuario
							<span class="small">M&aacute;x. 30 caracteres:</span>
						</label>
						<input type="text" name="user" maxlength="30" />
						<label>
							Contrase&ntilde;a
							<span class="small">Introduce tu contrase&ntilde;a:</span>
						</label>
						<input type="password" name="pass" />
						<br />
						<input type="hidden" name="login" value="1" />
						<input id="boton" type="submit" value="Conectar" />
					</p>
				</form>
<?php
					break;
				case 2:
?>
				<form action="new.php" method="post" enctype="multipart/form-data">
					<label>
						T&iacute;tulo
						<span class="small">M&aacute;x. 50 caracteres:</span>
					</label>
					<input type="text" name="title" />
					<label>
						C&oacute;mic
						<span class="small">Debe ser una imagen:</span>
					</label>
					<input type="file" name="comic" />
					<br />
					<input type="hidden" name="send" value="1" />
					<input id="boton" type="submit" value="Enviar" />
				</form>
<?php
					break;
			}
		}
		function NewComic($title, $destination_dir, $name_media_field)
		{
			$img_file = $this->UploadImage($destination_dir, $name_media_field);
			if (!empty($img_file))
			{
				$id = $_SESSION['id'];
				return $this->PerformInsert("INSERT INTO comics (author, title, path, date) VALUES ($id, '$title', '$img_file', '" . date('Y-m-d') . "')");
			}
		}
		function UploadImage($destination_dir, $name_media_field) // http://yophpro.com/problema/subir-imagenes-en-php.html
		{
			$tmp_name = $_FILES[$name_media_field]['tmp_name'];
			//si hemos enviado un directorio que existe realmente y hemos subido el archivo    
			if (is_dir($destination_dir) && is_uploaded_file($tmp_name))
			{
				$img_file = $_FILES[$name_media_field]['name'] ;
				$img_type = $_FILES[$name_media_field]['type'];
				//¿es una imágen realmente?           
				if (strpos($img_type, "gif") || strpos($img_type, "jpeg") || strpos($img_type,"jpg") || strpos($img_type,"png"))
				{
					//¿Tenemos permisos para subir la imágen?
					if (move_uploaded_file($tmp_name, $destination_dir.'/'.$img_file))
						return $img_file;
				}
			}
			//si llegamos hasta aquí es que algo ha fallado
			return FALSE;
		}
	}
?>