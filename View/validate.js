function validateForm() {
    alert("reached here");
    let x = document.forms["form"]["email"].value;
    let mailformat = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

    if (x.match(mailformat) == null) {
        document.getElementById('invalid-pwd').style.display = 'none';
        document.getElementById('invalid-mail').style.display = 'block';
        return false;
    } else {
        document.getElementById('invalid-mail').style.display = 'none';
    };
    let y = document.forms["form"]["passwrd"].value;
    if (y.length < 8) {
        document.getElementById('invalid-pwd').style.display = 'block';
        return false;
    };
};

let form = document.getElementById("form");
form.addEventListener("submit", (e) => {
    if (!validateForm()) {
        e.preventDefault();
    }
})