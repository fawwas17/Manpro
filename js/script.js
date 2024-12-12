/*
"Paw Store" adalah toko online alat kesehatan yang dikembangkan untuk keperluan akademis. Desain dan pengembangan oleh Achmad Sirajul Fahmi. (c) 2024 Hak Cipta Dilindungi.
*/

function validateLogin() {
  if (document.getElementById("txtEmail").value == "") {
    alert("Masukkan alamat email");
    document.getElementById("txtEmail").focus();
    return false;
  }

  if (document.getElementById("txtPassword").value == "") {
    alert("Masukkan password");
    document.getElementById("txtPassword").focus();
    return false;
  }

  return true;
}

function validateRegister() {
  if (document.getElementById("txtName").value == "") {
    alert("Masukkan nama");
    document.getElementById("txtName").focus();
    return false;
  }

  if (document.getElementById("txtAddress").value == "") {
    alert("Masukkan alamat");
    document.getElementById("txtAddress").focus();
    return false;
  }

  if (document.getElementById("txtEmail").value == "") {
    alert("Masukkan alamat email");
    document.getElementById("txtEmail").focus();
    return false;
  }

  var email = document.getElementById("txtEmail").value;
  var atpos = email.indexOf("@");
  var dotpos = email.lastIndexOf(".");
  var len = email.length;

  if (atpos < 2 || dotpos - atpos < 3 || len - dotpos < 3) {
    alert("Masukkan alamat email yang valid");
    document.getElementById("txtEmail").focus();
    return false;
  }

  if (document.getElementById("txtPassword").value == "") {
    alert("Masukkan password");
    document.getElementById("txtPassword").focus();
    return false;
  }

  if (
    document.getElementById("txtConfPassword").value !=
    document.getElementById("txtPassword").value
  ) {
    alert("Konfirmasi password tidak cocok");
    document.getElementById("txtPassword").focus();
    return false;
  }

  return true;
}

function validateAddProduct() {
  if (document.getElementById("txtName").value == "") {
    alert("Masukkan nama");
    document.getElementById("txtName").focus();
    return false;
  }

  if (document.getElementById("txtDescription").value == "") {
    alert("Masukkan deskripsi");
    document.getElementById("txtDescription").focus();
    return false;
  }

  if (document.getElementById("fileImage").value == "") {
    alert("Pilih gambar");
    return false;
  }

  if (document.getElementById("txtPrice").value == "") {
    alert("Masukkan harga");
    document.getElementById("txtPrice").focus();
    return false;
  }

  if (isNaN(document.getElementById("txtPrice").value)) {
    alert("Masukkan harga yang valid");
    document.getElementById("txtPrice").focus();
    return false;
  }

  return true;
}

function validateOrder() {
  if (document.getElementById("txtCredit").value == "") {
    alert("Masukkan nomor kartu kredit");
    document.getElementById("txtCredit").focus();
    return false;
  }

  if (
    isNaN(document.getElementById("txtCredit").value) ||
    document.getElementById("txtCredit").value.length != 10
  ) {
    alert("Masukkan nomor kartu kredit 10 digit");
    document.getElementById("txtCredit").focus();
    return false;
  }

  if (document.getElementById("txtAddress").value == "") {
    alert("Masukkan alamat pengiriman");
    document.getElementById("txtAddress").focus();
    return false;
  }

  return true;
}

function confirmDelete() {
  var ret = confirm("Apakah Anda yakin ingin menghapus ini?");
  return ret;
}

function confirmValidate() {
  var ret = confirm("Apakah Anda yakin ingin memvalidasi ini?");
  return ret;
}
