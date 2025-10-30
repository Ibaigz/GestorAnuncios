function inicio() {}

function inicioIragarkiaSortu() {
  let ekitaldiak = document.getElementsByName("ekitaldiak");
  for (let i = 0; i < ekitaldiak.length; i++) {
    ekitaldiak[i].addEventListener("click", function () {
      datakErakutzi(ekitaldiak[i].value);
    });
  }

  let botoia = document.getElementById("sortu");
  botoia.addEventListener("click", validatuIragarkia, false);
}

function validatuIragarkia(e) {
  let izena = document.getElementById("izena");
  let spanIz = document.getElementById("izenaError");
  let desk = document.getElementById("deskribapena");
  let spanDesk = document.getElementById("deskribapenaError");
  let prezioa = document.getElementById("prezioa");
  let spanPre = document.getElementById("prezioaError");
  let kokapena = document.getElementById("kokapena");
  let spanKok = document.getElementById("kokapenaError");
  let ekitaldia = document.getElementsByName("ekitaldiak");
  let dataHasiera = document.getElementById("data_hasiera");
  let spanDataHas = document.getElementById("data_hasieraError");
  let dataBukaera = document.getElementById("data_bukaera");
  let spanDataBuk = document.getElementById("data_bukaeraError");
  let irudia = document.getElementById("irudia");
  let spanIrudia = document.getElementById("irudiaError");

  let ekit = 0;
  for (let i = 0; i < ekitaldia.length; i++) {
    if (ekitaldia[i].checked == true) {
      ekit = ekitaldia[i].value;
    }
  }

  if (ekit == 0) {
    // ez da ekitaldia
    if (
      validaText(izena, spanIz) &&
      validaText(desk, spanDesk) &&
      validarFloat(prezioa, spanPre) &&
      validaText(kokapena, spanKok) &&
      validarImg(irudia, spanIrudia) &&
      confirm("Ziur zaude iragarkia sortu nahi duzula?")
    ) {
      return true;
    } else {
      e.preventDefault();
      return false;
    }
  } else {
    // ekitaldia da
    if (
      validaText(izena, spanIz) &&
      validaText(desk, spanDesk) &&
      validarFloat(prezioa, spanPre) &&
      validaText(kokapena, spanKok) &&
      validarDatak(dataHasiera, spanDataHas) &&
      validarDatak(dataBukaera, spanDataBuk) &&
      kompData(dataHasiera, spanDataHas, dataBukaera, spanDataBuk) &&
      validarImg(irudia, spanIrudia) &&
      confirm("Ziur zaude iragarkia sortu nahi duzula?")
    ) {
      return true;
    } else {
      e.preventDefault();
      return false;
    }
  }
}

function validaText(elemento, span) {
  if (!elemento.checkValidity()) {
    if (elemento.validity.valueMissing) {
      elemento.style.border = "2px solid red";
      mensajeError(span, "Eremu hau ezin da hutsik egon");
      elemento.focus();
    }

    if (elemento.validity.tooLong) {
      elemento.style.border = "2px solid red";
      mensajeError(span, "Eremu hau luzeegia da");
      elemento.focus();
    }

    return false;
  }
  span.innerHTML = "";
  return true;
}

function validarFloat(elemento, span) {
  if (!elemento.checkValidity()) {
    if (elemento.validity.valueMissing) {
      elemento.style.border = "2px solid red";
      mensajeError(span, "Eremu hau ezin da hutsik egon");
      elemento.focus();
    }

    if (elemento.validity.patternMismatch) {
      elemento.style.border = "2px solid red";
      mensajeError(
        span,
        "Zenbakia 0 edo handiagoa izan behar da eta gehienez 2 hamartar onartzen dira"
      );
      elemento.focus();
    }
    return false;
  }
  span.innerHTML = "";
  return true;
}

function validarDatak(elemento, span) {
  if (elemento.value == "") {
    elemento.style.border = "2px solid red";
    mensajeError(span, "Eremu hau ezin da hutsik egon");
    elemento.focus();
    return false;
  } else {
    if (!elemento.checkValidity()) {
      if (elemento.validity.valueMissing) {
        elemento.style.border = "2px solid red";
        mensajeError(span, "Eremu hau ezin da hutsik egon");
        elemento.focus();
      }
      return false;
    }
  }
  span.innerHTML = "";
  return true;
}

function kompData(elementoHas, spanHas, elementoBuk, spanBuk) {
  if (elementoBuk.value < elementoHas.value) {
    elementoHas.style.border = "2px solid red";
    elementoBuk.style.border = "2px solid red";
    mensajeError(
      spanHas,
      "Data hasiera ezin da data bukaeraren baino handiagoa izan"
    );
    mensajeError(
      spanBuk,
      "Data bukaera ezin da data hasieraren baino txikiagoa izan"
    );
    elementoHas.focus();
    return false;
  }

  spanHas.innerHTML = "";
  spanBuk.innerHTML = "";
  return true;
}

function validarImg(elemento, span) {
  if (!elemento.checkValidity()) {
    if (elemento.validity.valueMissing) {
      elemento.style.border = "2px solid red";
      mensajeError(span, "Eremu hau ezin da hutsik egon");
      elemento.focus();
    }

    return false;
  }

  if (elemento.files.length > 0) {
    for (let i = 0; i < elemento.files.length; i++) {
      let extension = elemento.files[i].name
        .substring(elemento.files[i].name.lastIndexOf(".") + 1)
        .toLowerCase();
      if (extension != "png" && extension != "jpg" && extension != "jpeg") {
        elemento.style.border = "2px solid red";
        mensajeError(
          span,
          "Irudiak .png, .jpg edo .jpeg luzapena izan behar du"
        );
        elemento.focus();
        return false;
      }
    }
  }

  span.innerHTML = "";
  return true;
}

function datakErakutzi(ekitaldia) {
  let datakView = document.getElementById("datakView");
  if (ekitaldia == null) {
    ekitaldia = false;
  } else if (ekitaldia == 0) {
    ekitaldia = false;
  } else if (ekitaldia == 1) {
    ekitaldia = true;
  }

  if (ekitaldia) {
    datakView.style.display = "";
  } else {
    datakView.style.display = "none";
  }
}

function mensajeError(span, mesua) {
  span.innerHTML = mesua;
}

function inicioPasahitzaBerrezarri() {
  let botoia = document.getElementById("aldatu");
  botoia.addEventListener("click", validatuPasahitzaBerrezarri, false);
}

function validatuPasahitzaBerrezarri(e) {
  let pass = document.getElementById("pass");
  let spanError1 = document.getElementById("passwordError");
  let pass2 = document.getElementById("pass2");
  let spanError2 = document.getElementById("passwordError2");
  if (
    revisaContra(pass, spanError1) &&
    revisaContra(pass2, spanError2) &&
    pasahitzaKonp(pass, spanError1, pass2, spanError2) &&
    confirm("Ziur zaude pasahitz hau sartu nahi duzula?")
  ) {
    console.log("Dena ondo");
    return true;
  } else {
    console.log("Zerbait gaizki");
    e.preventDefault();
    return false;
  }
}

function revisaContra(elemento, span) {
  if (!elemento.checkValidity()) {
    if (elemento.validity.valueMissing) {
      elemento.style.border = "2px solid red";
      mensajeError(span, "Eremu hau ezin da hutsik egon");
      elemento.focus();
    }

    if (elemento.validity.patternMismatch) {
      elemento.style.border = "2px solid red";
      mensajeError(
        span,
        "Pasahitza 9 zenbaki baino gehiago eta gutxienez letra larri bat izan behar du"
      );
      elemento.focus();
    }
    return false;
  }
  elemento.style.border = "2px solid black";
  span.innerHTML = "";
  return true;
}

function pasahitzaKonp(pasahitza1, span1, pasahitza2, span2) {
  if (pasahitza1.value == pasahitza2.value) {
    pasahitza1.style.border = "2px solid black";
    pasahitza2.style.border = "2px solid black";
    span1.innerHTML = "";
    span2.innerHTML = "";
    console.log("Komp ondo");
    return true;
  } else {
    pasahitza1.style.border = "2px solid red";
    pasahitza2.style.border = "2px solid red";
    mensajeError(span1, "Pasahitzak berdinak izan behar dira");
    mensajeError(span2, "Pasahitzak berdinak izan behar dira");
    console.log("Komp txarto");
    return false;
  }
}

// AdminPage
let pasatuta = false;

function inicioAdminPage() {
  let div = document.getElementsByClassName("erabiltzailea-admin");
  for (let i = 0; i < div.length; i++) {
    div[i].addEventListener("click", div1);
  }

  let divImg1 = document.getElementsByClassName("divImg");
  for (let i = 0; i < divImg1.length; i++) {
    divImg1[i].addEventListener("click", divImg);
  }

  let divP1 = document.getElementsByClassName("divP");
  for (let i = 0; i < divP1.length; i++) {
    divP1[i].addEventListener("click", divP);
  }

  let zureBotoia1 = document.getElementsByClassName("zureBotoia");
  for (let i = 0; i < zureBotoia1.length; i++) {
    zureBotoia1[i].addEventListener("click", zureBotoia);
  }

  let zureDiv1 = document.getElementsByClassName("zuerDiv");
  for (let i = 0; i < zureDiv1.length; i++) {
    zureDiv1[i].addEventListener("click", zureDiv);
  }

  let botoiakOndo = document.getElementsByClassName("botoiakOndo");
  for (let i = 0; i < botoiakOndo.length; i++) {
    botoiakOndo[i].addEventListener("click", gaitu);
  }

  let iconoOndoImg = document.getElementsByClassName("iconoOndo");
  for (let i = 0; i < iconoOndoImg.length; i++) {
    iconoOndoImg[i].addEventListener("click", gaituImg);
  }

  let botoiakTxarto = document.getElementsByClassName("botoiakTxarto");
  for (let i = 0; i < botoiakTxarto.length; i++) {
    botoiakTxarto[i].addEventListener("click", ezGaitu);
  }

  let iconoTxartoImg = document.getElementsByClassName("iconoTxarto");
  for (let i = 0; i < iconoTxartoImg.length; i++) {
    iconoTxartoImg[i].addEventListener("click", ezGaituImg);
  }

  let botoiaEzabatuAdmin =
    document.getElementsByClassName("botoiaEzabatuAdmin");
  for (let i = 0; i < botoiaEzabatuAdmin.length; i++) {
    botoiaEzabatuAdmin[i].addEventListener("click", ezabatuAdmin);
  }

  let iconoEzabatuAdmin = document.getElementsByClassName("iconoEzabatuAdmin");
  for (let i = 0; i < iconoEzabatuAdmin.length; i++) {
    iconoEzabatuAdmin[i].addEventListener("click", ezabatuAdminImg);
  }

  let botoiaGehituAdmin = document.getElementsByClassName("botoiaGehituAdmin");
  for (let i = 0; i < botoiaGehituAdmin.length; i++) {
    botoiaGehituAdmin[i].addEventListener("click", gehituAdmin);
  }

  let iconoGehituAdmin = document.getElementsByClassName("iconoGehituAdmin");
  for (let i = 0; i < iconoGehituAdmin.length; i++) {
    iconoGehituAdmin[i].addEventListener("click", gehituAdminImg);
  }

  let botoiaErabEzabatu = document.getElementsByClassName("botoiaErabEzabatu");
  for (let i = 0; i < botoiaErabEzabatu.length; i++) {
    botoiaErabEzabatu[i].addEventListener("click", erabEzabatu);
  }

  let iconoErabEzabatu = document.getElementsByClassName("iconoErabEzabatu");
  for (let i = 0; i < iconoErabEzabatu.length; i++) {
    iconoErabEzabatu[i].addEventListener("click", erabEzabatuImg);
  }

  // Kategoriak

  let botoiaKategoriaKendu = document.getElementsByClassName(
    "botoiaKategoriaKendu"
  );
  for (let i = 0; i < botoiaKategoriaKendu.length; i++) {
    botoiaKategoriaKendu[i].addEventListener("click", kategoriaKendu);
  }

  let iconoKategoriaKendu = document.getElementsByClassName(
    "iconoKategoriaKendu"
  );
  for (let i = 0; i < iconoKategoriaKendu.length; i++) {
    iconoKategoriaKendu[i].addEventListener("click", kategoriaKenduImg);
  }

  let botoiaEditKategoria = document.getElementsByClassName(
    "botoiaEditKategoria"
  );
  for (let i = 0; i < botoiaEditKategoria.length; i++) {
    botoiaEditKategoria[i].addEventListener("click", kategoriaEditatu);
  }

  let iconoEditKategoria =
    document.getElementsByClassName("iconoEditKategoria");
  for (let i = 0; i < iconoEditKategoria.length; i++) {
    iconoEditKategoria[i].addEventListener("click", kategoriaEditatuImg);
  }

  let botoiaKategoriaGehitu = document.getElementsByClassName("kategoriaAdd");
  for (let i = 0; i < botoiaKategoriaGehitu.length; i++) {
    botoiaKategoriaGehitu[i].addEventListener("click", kategoriaGehitu);
  }

  let iconoKategoriaGehitu = document.getElementsByClassName(
    "iconoKategoriaGehitu"
  );
  for (let i = 0; i < iconoKategoriaGehitu.length; i++) {
    iconoKategoriaGehitu[i].addEventListener("click", kategoriaGehituImg);
  }

  // Iragarkiak

  let botoiakOndoIragarkia = document.getElementsByClassName(
    "botoiakOndoIragarkia"
  );
  for (let i = 0; i < botoiakOndoIragarkia.length; i++) {
    botoiakOndoIragarkia[i].addEventListener("click", gaituIragarkia);
  }

  let iconoOndoIragarkia =
    document.getElementsByClassName("iconoOndoIragarkia");
  for (let i = 0; i < iconoOndoIragarkia.length; i++) {
    iconoOndoIragarkia[i].addEventListener("click", gaituIragarkiaImg);
  }

  let botoiakTxartoIragarkia = document.getElementsByClassName(
    "botoiakTxartoIragarkia"
  );
  for (let i = 0; i < botoiakTxartoIragarkia.length; i++) {
    botoiakTxartoIragarkia[i].addEventListener("click", ezGaituIragarkia);
  }

  let iconoTxartoIragarkia = document.getElementsByClassName(
    "iconoTxartoIragarkia"
  );
  for (let i = 0; i < iconoTxartoIragarkia.length; i++) {
    iconoTxartoIragarkia[i].addEventListener("click", ezGaituIragarkiaImg);
  }

  let botoiakEzabatuIragarkia = document.getElementsByClassName(
    "botoiakEzabatuIragarkia"
  );
  for (let i = 0; i < botoiakEzabatuIragarkia.length; i++) {
    botoiakEzabatuIragarkia[i].addEventListener("click", ezabatuIragarkia);
  }

  let iconoEzabatuIragarkia = document.getElementsByClassName(
    "iconoEzabatuIragarkia"
  );
  for (let i = 0; i < iconoEzabatuIragarkia.length; i++) {
    iconoEzabatuIragarkia[i].addEventListener("click", ezabatuIragarkiaImg);
  }
}

function div1(e) {
  if (!pasatuta) {
    let id = e.target.getAttribute("id");
    location.href = "perfilaAdmin.php?id=" + id;
  } else {
    pasatuta = false;
  }
}

function divImg(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.getAttribute("id");
    location.href = "perfilaAdmin.php?id=" + id;
    pasatuta = true;
  }
}

function divP(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.getAttribute("id");
    location.href = "perfilaAdmin.php?id=" + id;
    pasatuta = true;
  }
}

function zureBotoia(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.getAttribute("id");
    location.href = "perfilaAdmin.php?id=" + id;
    pasatuta = true;
  }
}

function zureDiv(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.getAttribute("id");
    location.href = "perfilaAdmin.php?id=" + id;
    pasatuta = true;
  }
}

function gaitu(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "ziurtatuGaituErab.php?id=" + id;
  }
}

function gaituImg(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "ziurtatuGaituErab.php?id=" + id;
  }
}

function ezGaitu(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "arrazoitu_erab_ez_gaitua.php?id=" + id;
  }
}

function ezGaituImg(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "arrazoitu_erab_ez_gaitua.php?id=" + id;
  }
}

function ezabatuAdmin(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "arrazoitu_ezabatuPermisoAdmin.php?id=" + id;
  }
}

function ezabatuAdminImg(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "arrazoitu_ezabatuPermisoAdmin.php?id=" + id;
  }
}

function gehituAdmin(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "ziurtatuGehituAdmin.php?id=" + id;
  }
}

function gehituAdminImg(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "ziurtatuGehituAdmin.php?id=" + id;
  }
}

function erabEzabatu(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "arrazoitu_erab_ezabatu.php?id=" + id;
  }
}

function erabEzabatuImg(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "arrazoitu_erab_ezabatu.php?id=" + id;
  }
}

function kategoriaKendu(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.getAttribute("id");
    location.href = "kategoria_kendu.php?id=" + id;
  } else {
    pasatuta = false;
  }
}

function kategoriaKenduImg(e) {
  if (!pasatuta) {
    console.log("hola2");
    let id = e.target.parentNode.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "kategoria_kendu.php?id=" + id;
  }
}

function kategoriaEditatu(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.getAttribute("id");
    location.href = "kategoria_editatu.php?id=" + id;
  } else {
    pasatuta = false;
  }
}

function kategoriaEditatuImg(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "kategoria_editatu.php?id=" + id;
  }
}

function kategoriaGehitu(e) {
  if (!pasatuta) {
    pasatuta = true;
    location.href = "kategoria_gehitu.php";
  } else {
    pasatuta = false;
  }
}

function kategoriaGehituImg(e) {
  if (!pasatuta) {
    pasatuta = true;
    location.href = "kategoria_gehitu.php";
  }
}

function gaituIragarkia(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "iragarkiakGaitu.php?id=" + id;
  } else {
    pasatuta = false;
  }
}

function gaituIragarkiaImg(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "iragarkiakGaitu.php?id=" + id;
  }
}

function ezGaituIragarkia(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "arrazoitu_irag_ez_gaitua.php?id=" + id;
  } else {
    pasatuta = false;
  }
}

function ezGaituIragarkiaImg(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "arrazoitu_irag_ez_gaitua.php?id=" + id;
  }
}

function ezabatuIragarkia(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "arrazoitu_irag_ezabatu.php?id=" + id;
  } else {
    pasatuta = false;
  }
}

function ezabatuIragarkiaImg(e) {
  if (!pasatuta) {
    let id = e.target.parentNode.parentNode.parentNode.getAttribute("id");
    pasatuta = true;
    location.href = "arrazoitu_irag_ezabatu.php?id=" + id;
  }
}

function openTab(tabName) {
  switch (tabName) {
    case "Erabiltzaileak":
      location.href = "adminpage.php?id=1";
      break;

    case "Gaitzeko erabiltzaileak":
      location.href = "adminpage.php?id=2";
      break;

    case "Administratzaileak":
      location.href = "adminpage.php?id=3";
      break;

    case "Iragarkiak":
      location.href = "adminpage.php?id=4";
      break;

    case "Gaitzeko Iragarkiak":
      location.href = "adminpage.php?id=5";
      break;

    case "Kategoriak":
      location.href = "adminpage.php?id=6";
      break;
  
    default:
      location.href = "adminpage.php?id=1";
      break;
  }
}

function openTab1(tab, tabName) {
  let i, tabcontent, tablinks;

  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    if (i == tab) {
      tablinks[i].className += " styled-link-active";
    } else {
      tablinks[i].className = tablinks[i].className.replace(" styled-link-active", "");
    }
  }

  document.getElementById(tabName).style.display = "block";

  if (tabName == "Kategoriak") {
    let kat = document.getElementById("kategoriaAdd");
    kat.style.display = "block";
  } else {
    let kat = document.getElementById("kategoriaAdd");
    kat.style.display = "none";
  }
}

function openTabPerfil(tabName) {
  switch (tabName) {
    case "Zure Iragarkiak":
      location.href = "perfila.php?nav=1";
      break;

    case "Gogokoak":
      location.href = "perfila.php?nav=2";
      break;

    default:
      location.href = "perfila.php?nav=1";
      break;
  }
}

function openTabPerfil1(tab, tabName) {
  let i, tabcontent, tablinks;

  tabcontent = document.getElementsByClassName("tabcontent1");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  tablinks = document.getElementsByClassName("tablinks1");
  for (i = 0; i < tablinks.length; i++) {
    if (i == tab) {
      tablinks[i].className += " styled-link-active";
    } else {
      tablinks[i].className = tablinks[i].className.replace(" styled-link-active", "");
    }
  }

  document.getElementById(tabName).style.display = "block";
}

function dialog() {
  let iconContainer = document.getElementsByClassName('icon-container');
  let infoModal = document.getElementById('info-modal');
  let closeModalButton = document.getElementById('close-modal');

  let iconHelpContainer = document.getElementsByClassName('icon-help-container');
  let helpModal = document.getElementById('help-modal');
  let closeHelpModalButton = document.getElementById('close-modal-help');

  for (i = 0; i < iconContainer.length; i++) {
      iconContainer[i].addEventListener('click', () => {
          infoModal.classList.add('show');
          document.body.classList.add('modal-open');
      });
  }
  

  closeModalButton.addEventListener('click', () => {
      infoModal.classList.remove('show');
      document.body.classList.remove('modal-open');
  });

  for (i = 0; i < iconHelpContainer.length; i++) {
      iconHelpContainer[i].addEventListener('click', () => {
          helpModal.classList.add('show');
          document.body.classList.add('modal-open');
      });
  }

  closeHelpModalButton.addEventListener('click', () => {
      helpModal.classList.remove('show');
      document.body.classList.remove('modal-open');
  });
}

function inicioMenu() {
  let dark = document.getElementById("dark");
  let light = document.getElementById("light");
  dark.addEventListener("click", darkMode);
  light.addEventListener("click", darkMode);

  let dark1 = document.getElementById("dark1");
  let light1 = document.getElementById("light1");
  dark1.addEventListener("click", darkMode);
  light1.addEventListener("click", darkMode);
}

function darkMode(e) {
  let id = e.target.getAttribute("id");
  if (id == "dark") {
    document.getElementById("darkli").style.display = "none";
    document.getElementById("lightli").style.display = "block";
    location.href = "dark-mode.php?id=2";
  } else if (id == "light") {
    document.getElementById("darkli").style.display = "block";
    document.getElementById("lightli").style.display = "none";
    location.href = "dark-mode.php?id=1";
  } else if (id == "dark1") {
    document.getElementById("darkli1").style.display = "none";
    document.getElementById("lightli1").style.display = "block";
    location.href = "dark-mode.php?id=2";
  } else if (id == "light1") {
    document.getElementById("darkli1").style.display = "block";
    document.getElementById("lightli1").style.display = "none";
    location.href = "dark-mode.php?id=1";
  }
}
