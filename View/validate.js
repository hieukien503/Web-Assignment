function validateForm() {
<<<<<<< HEAD
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
=======
    const email = document.getElementById("email").value;
    const password = document.getElementById("passwrd").value;
    
    var validEmail = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
    if (!email.match(validEmail)) {
        alert('Invalid email address!');
        return false;
    }
    else {
        validPassword = /^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])([a-zA-Z0-9]{8,})$/;
        if (!password.match(validPassword)) {
            alert('Invalid password!');
            return false;
        }
    }
    return true;
}
>>>>>>> 9448510d2a3d7f944975ef7539391a49fb926d08

let form = document.getElementById("form");
form.addEventListener("submit", (e) => {
    if (!validateForm()) {
        e.preventDefault();
    }
})