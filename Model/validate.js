function validateForm() {
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

let form = document.getElementById("form");
form.addEventListener("submit", (e) => {
    if (!validateForm()) {
        e.preventDefault();
    }
})