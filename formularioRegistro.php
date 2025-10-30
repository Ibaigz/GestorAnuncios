<button class="btnVolverF" onclick="vuelveAlLogin()"><label >Loginera bueltatu</label ><label> </label><label > ↩</label></button>
<?php
    if (isset($_COOKIE["dark"])) {
        if ($_COOKIE["dark"] == "on") {
            ?>
            <form id="miFormulario" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="formReg testuaIragarkiaDivOscuro">
            <?php
        } else {
            ?>
            <form id="miFormulario" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="formReg">
            <?php
        }
    } else {
        ?>
        <form id="miFormulario" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="formReg">
        <?php
    }
    ?>

    <h2>Zure datuak bete:</h2><br>
    <div class="container1">
        <label id="nomUsu">Erabiltzaile izena:</label><label id="textoErrorNombre" class="errorTextos">Erabiltzailea izena erabilita dago</label><br>
        <input id="textUsuario" class="textArea" type="text" name="erabiltzaileIzena" required onblur="revisaUsuario()"><br><br>
        <label>Pasahitza:</label></label><label id="textoErrorContrasenya" class="errorTextos">Pasahitzak 9 karaktere izan behar ditu</label><br>
        <input id="textContrasenya" class="textArea" type="password" name="pasahitza" required onblur="revisaContra()"><br><br>
        <label>Pasahitza errepikatu:</label></label><label id="textoErrorContrasenyaRepe" class="errorTextos">Pasahitz berdina jarri behar duzu</label><br>
        <input id="textContrasenyaRepe" class="textArea" type="password" name="pasahitzaRepe" required onblur="revisaContraRepe()"><br><br>
        <label>Izena:</label><br>
        <input type="text" class="textArea" name="izena" required><br><br>
        <label>Abizenak:</label><br>
        <input type="text" name="abizenak" class="textArea" required><br><br>
        <label>Adina:</label></label><label id="textoErrorEdad" class="errorTextos">Adin egoki bat sartu</label><br>
        <input id="textEdad" type="text" class="textArea" name="adina" required onblur="revisaEdad()">
    </div>
    <div class="container2">
        <label>NAN zenbakia:</label></label><label id="textoErrorDni" class="errorTextos">NAN zenbaki egoki bat sartu</label><br>
        <input id="textDni" type="text" class="textArea" name="nan" required onblur="revisaDni()"><br><br>
        <label>Posta elektronikoa:</label></label><label id="textoErrorEmail" class="errorTextos">Posta elektroniko egoki bat sartu</label><br>
        <input id="textEmail" type="text" class="textArea" name="email" required onblur="revisaEmail()"><br><br>
        <label>Telefonoa:</label></label><label class="optional" id="optTfno"> - Aukerazkoa</label><label id="textoErrorTfno" class="errorTextos">Telefono zenbaki egoki bat sartu</label><br>
        <input id="textTfno" type="text" class="textArea" name="tfno" onblur="revisaTfno()"><br><br>
        <label>Helbidea:</label><label class="optional"> - Aukerazkoa</label><br>
        <input type="text" name="helbidea" class="textArea"><br><br>
        <label>Deskribapena:</label><label class="optional"> - Aukerazkoa</label><br>
        <input type="text" name="deskribapena" class="textArea"><br><br>
        <label>Perfil argazkia:</label><label class="optional"> - Aukerazkoa</label><br>
        <input type="file" name="image" value="Argazkia igo" accept="image/*">
    </div>
    <br><br>
    <input type="submit" id="btnForm" value="Datuak gorde" name="envio">
</form>


<script>

    function vuelveAlLogin() {
        window.location.href = "login.php";
    }
    
    function revisaUsuario() {
        document.getElementById('textoErrorNombre').style.display = "none";
        document.getElementById('textUsuario').style.border = "2px solid black";
    }

    function revisaContra() {
        var inputValueContra = document.getElementById('textContrasenya').value;

        if (inputValueContra.length >= 9) {
            document.getElementById('textoErrorContrasenya').style.display = "none";
            document.getElementById('textContrasenya').style.border = "2px solid black";
            
            var regex = /^(?=.*[A-Za-z])(?=.*[A-Z]).{9,}$/;

            if (regex.test(inputValueContra)) {
                document.getElementById('textoErrorContrasenya').style.display = "none";
                document.getElementById('textContrasenya').style.border = "2px solid black";
                return false;
            } else {
                document.getElementById('textoErrorContrasenya').innerHTML = "Pasahitzak letra larri bat izan behar du"
                document.getElementById('textoErrorContrasenya').style.display = "inline-block";
                document.getElementById('textContrasenya').style.border = "2px solid red";
                return true;
            }

        } else {
            document.getElementById('textoErrorContrasenya').innerHTML = "Pasahitzak 9 karaktere izan behar ditu"
            document.getElementById('textoErrorContrasenya').style.display = "inline-block";
            document.getElementById('textContrasenya').style.border = "2px solid red";
            return true;
        }
    }

    function revisaContraRepe() {
        var inputValueContra = document.getElementById('textContrasenya').value;
        var inputValueContraRepe = document.getElementById('textContrasenyaRepe').value;

        if (inputValueContra === inputValueContraRepe) {
            document.getElementById('textoErrorContrasenyaRepe').style.display = "none";
            document.getElementById('textContrasenyaRepe').style.border = "2px solid black";
            return false;
        } else {
            document.getElementById('textoErrorContrasenyaRepe').style.display = "inline-block";
            document.getElementById('textContrasenyaRepe').style.border = "2px solid red";
            return true;
        }
    }

    function revisaEdad() {
        var patron = /^\d+$/;
        var edadInt = 0;

        if (patron.test(document.getElementById('textEdad').value)) {
            document.getElementById('textoErrorEdad').style.display = "none";
            document.getElementById('textEdad').style.border = "2px solid black";
            
            edadInt = parseInt(document.getElementById('textEdad').value);

            if (edadInt >= 16) {
                document.getElementById('textoErrorEdad').style.display = "none";
                document.getElementById('textEdad').style.border = "2px solid black";
                return false;
            } else {
                document.getElementById('textoErrorEdad').innerHTML = "16 urte baino gehiago izan behar dituzu";
                document.getElementById('textoErrorEdad').style.display = "inline-block";
                document.getElementById('textEdad').style.border = "2px solid red";
                return true;
            }

        } else {
            document.getElementById('textoErrorEdad').innerHTML = "Adin egoki bat sartu";
            document.getElementById('textoErrorEdad').style.display = "inline-block";
            document.getElementById('textEdad').style.border = "2px solid red";
            return true;
        }
    }

    function revisaTfno() {
        var patron = /^\d+$/;
        var num = document.getElementById('textTfno').value;

        if (num.length != 0) {
            if (!patron.test(num) || num.length != 9) {
                document.getElementById('optTfno').style.display = "none";
                document.getElementById('textoErrorTfno').style.display = "inline-block";
                document.getElementById('textTfno').style.border = "2px solid red";
                return true;
            } else {
                document.getElementById('optTfno').style.display = "inline-block";
                document.getElementById('textoErrorTfno').style.display = "none";
                document.getElementById('textTfno').style.border = "2px solid black";
                return false;
            }
        } else {
            document.getElementById('optTfno').style.display = "inline-block";
            document.getElementById('textoErrorTfno').style.display = "none";
            document.getElementById('textTfno').style.border = "2px solid black";
            return false;
        }
        
    }

    function revisaDni() {
        var dni = document.getElementById('textDni').value.trim().toUpperCase();

        if (/^[0-9]{8}[A-Z]$/.test(dni)) {
            var letras = "TRWAGMYFPDXBNJZSQVHLCKE";
            var numero = dni.substr(0, 8);
            var letra = dni.charAt(8);

            var indice = numero % 23;

            if (letras.charAt(indice) === letra) {
                document.getElementById('textoErrorDni').style.display = "none";
                document.getElementById('textDni').style.border = "2px solid black";
                return false;
            } else {
                document.getElementById('textoErrorDni').style.display = "inline-block";
                document.getElementById('textDni').style.border = "2px solid red";
                return true;
            }
        } else {
            document.getElementById('textoErrorDni').style.display = "inline-block";
            document.getElementById('textDni').style.border = "2px solid red";
            return true;
        }
    }

    function revisaEmail() {
        var patron = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

        var emailValido = patron.test(document.getElementById('textEmail').value);

        if (emailValido) {
            document.getElementById('textoErrorEmail').style.display = "none";
            document.getElementById('textEmail').style.border = "2px solid black";
            return false;
        } else {
            document.getElementById('textoErrorEmail').style.display = "inline-block";
            document.getElementById('textEmail').style.border = "2px solid red";
            return true;
        }
    }

    document.getElementById('miFormulario').addEventListener('submit', function(event) {
        
        if (revisaContra() || revisaEdad() || revisaTfno() || revisaDni() || revisaEmail()) {
            event.preventDefault(); // Evita el envío predeterminado del formulario
        }
        
    });
</script>