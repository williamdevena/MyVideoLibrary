// CONTROLLA CHE I FORM SIANO RIEMPITI NEL CASO IN CUI IL BROWSER NON LO FACESSE
function validazioneLogin() {
  if (document.login.email.value=="") {
    alert("Inserire email");
    return false;
  }
  if (document.login.password.value=="") {
    alert("Inserire password");
    return false;
  }
  return true;
}


// VALIDA IL FORM DELLA REGISTRAZIONE
function validazioneRegistr() {

  var risul=true;

  if (document.registr.nome.value == "") {
    document.getElementById("div_nome").style.borderBottom = "2px solid red";
    risul = false;
  }

  if (document.registr.cognome.value == "") {
    document.getElementById("div_cognome").style.borderBottom = "2px solid red";
    risul = false;
  }

  if (document.registr.email.value == "") {
    document.getElementById("div_email").style.borderBottom = "2px solid red";
    risul = false;
  }

  if (document.registr.password.value == "") {
    document.getElementById("div_password").style.borderBottom = "2px solid red";
    risul = false;
  }

  if (document.registr.ConfermaPassword.value == "") {
    document.getElementById("div_ConfermaPassword").style.borderBottom = "2px solid red";
    risul = false;
  }

  //il nome non può contenere numeri
  if (document.registr.nome.value.match(/.*[0-9].*/) != null) {
    document.getElementById("div_nome").style.borderBottom = "2px solid red";
    document.getElementById("registration_box").style.height = "73%";
    document.getElementById("div_errore").style.visibility="visible";
    document.getElementById("div_errore").innerHTML="<p>Il nome non può contenere numeri</p>";
    risul = false;
  } else {
    document.getElementById("div_nome").style.borderBottom = "2px solid #adadad";
  }



  //il cognome non può contenere numeri
  if (document.registr.cognome.value.match(/.*[0-9].*/) != null) {
    document.getElementById("div_cognome").style.borderBottom = "2px solid red";
    document.getElementById("registration_box").style.height = "73%";
    document.getElementById("div_errore").style.visibility="visible";
    document.getElementById("div_errore").innerHTML="<p>Il cognome non può contenere numeri</p>";
    risul = false;
  } else {
    document.getElementById("div_cognome").style.borderBottom = "2px solid #adadad";
  }


  // l' email deve contenere la @
  if (document.registr.email.value.match(/.*@.*/) == null  && document.registr.email.value!="") {
    document.getElementById("div_email").style.borderBottom = "2px solid red";
    document.getElementById("registration_box").style.height = "73%";
    document.getElementById("div_errore").style.visibility="visible";
    document.getElementById("div_errore").innerHTML="<p>Manca la @ nella email</p>";
    risul = false;
  } else {
    document.getElementById("div_email").style.borderBottom = "2px solid #adadad";
  }



  // la password deve essere minimo 8 caratteri
  if (document.registr.password.value.length < 8) {
    document.getElementById("div_password").style.borderBottom = "2px solid red";
    document.getElementById("registration_box").style.height = "73%";
    document.getElementById("div_errore").style.visibility="visible";
    document.getElementById("div_errore").innerHTML="<p>Minimo 8 caratteri per la password</p>";
    risul = false;
  } else {
    document.getElementById("div_password").style.borderBottom = "2px solid #adadad";
  }


  // le due password devono coincidere
  if (document.registr.ConfermaPassword.value!=document.registr.password.value) {
    document.getElementById("div_password").style.borderBottom = "2px solid red";
    document.getElementById("div_ConfermaPassword").style.borderBottom = "2px solid red";
    document.getElementById("registration_box").style.height = "73%";
    document.getElementById("div_errore").style.visibility="visible";
    document.getElementById("div_errore").innerHTML="<p>Le due password non coincidono</p>";
    risul = false;
  } else {
    document.getElementById("div_password").style.borderBottom = "2px solid #adadad";
    document.getElementById("div_ConfermaPassword").style.borderBottom = "2px solid #adadad";
  }



  return risul;
}


// VALIDA IL FORM DI MODIFICA PROFILO
function validazioneModifica() {

  var risul=true;

 if (document.mainForm.inputNome.value == "") {
    document.getElementById("inputNome").style.border = "2px solid red";
    risul = false;
  }

  if (document.mainForm.inputCognome.value == "") {
    document.getElementById("inputCognome").style.border = "2px solid red";
    risul = false;
  }

  if (document.mainForm.inputPassword.value == "") {
    document.getElementById("inputPassword").style.border = "2px solid red";
    risul = false;
  }


  //il nome non può contenere numeri
  if (document.mainForm.inputNome.value.match(/.*[0-9].*/) != null) {
    document.getElementById("inputNome").style.border = "2px solid red";
    document.getElementById("div_errore").style.visibility="visible";
    document.getElementById("div_errore").innerHTML="<p>Il nome non può contenere numeri</p>";
    risul = false;
  } else {
    document.getElementById("inputNome").style.border = "2px solid #adadad";
  }

  

  //il cognome non può contenere numeri
  if (document.mainForm.inputCognome.value.match(/.*[0-9].*/) != null) {
    document.getElementById("inputCognome").style.border = "2px solid red";
    document.getElementById("div_errore").style.visibility="visible";
    document.getElementById("div_errore").innerHTML="<p>Il cognome non può contenere numeri</p>";
    risul = false;
  } else {
    document.getElementById("inputCognome").style.border = "2px solid #adadad";
  }



  // // la password deve essere minimo 8 caratteri
  if (document.mainForm.inputPassword.value.length < 8) {
    document.getElementById("inputPassword").style.border = "2px solid red";
    document.getElementById("div_errore").style.visibility="visible";
    document.getElementById("div_errore").innerHTML="<p>Minimo 8 caratteri per la password</p>";
    risul = false;
  } else {
    document.getElementById("inputPassword").style.border = "2px solid #adadad";
  }



  return risul;
}

