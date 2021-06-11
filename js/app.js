$(() => {
    document.getElementById("loginForm").addEventListener("submit", (e) => {
        e.preventDefault();

        let loginForm = document.getElementById("loginForm");
        let data = new FormData(loginForm);

        fetch("includes/functions.php", {
            method: "POST",
            body: data,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.resp == "OK") {
                    Swal.fire({
                        icon: "success",
                        title: "Correcto!",
                        text: data.message,
                    });
                    setTimeout(() => {
                        window.location.href = data.url;
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: data.message,
                    });
                    setTimeout(() => {
                        window.location.href = data.url;
                    }, 2000);
                }
            });
    });
});


$(() => {
    document.getElementById("openModal").addEventListener('click', (e) => {
        e.preventDefault();

        document.getElementById("operation").value = "create";

    })
})

$(() => {
    document.getElementById("editAdd").addEventListener("submit", (e) => {
        e.preventDefault();

        let loginForm = document.getElementById("editAdd");
        let data = new FormData(loginForm);

        console.log(data);

        fetch("includes/functions.php", {
            method: "POST",
            body: data,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.resp == "OK") {
                    Swal.fire({
                        icon: "success",
                        title: "Correcto!",
                        text: data.message,
                    });
                    setTimeout(() => {
                        window.location.href = data.url;
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: data.message,
                    });
                    setTimeout(() => {
                        window.location.href = data.url;
                    }, 2000);
                }
            });
    });
});

StatusUser = (id) => {

    let data = new FormData();

    data.append('id',id);
    data.append('operation', 'updateStatus');

    fetch("includes/functions.php", {
        method: "POST",
        body: data,
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);

            if (data.resp == "OK") {
                Swal.fire({
                    icon: "success",
                    title: "Correcto!",
                    text: data.message,
                });
                setTimeout(() => {
                    window.location.href = data.url;
                }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: data.message,
                });
            }
        })
}

EditUser = (Id) => {

    let data = new FormData();

    data.append('id',Id);
    data.append('operation', 'read');

    fetch("includes/functions.php", {
        method: "POST",
        body: data,
    })
        .then( (response) => response.json())
        .then((data) => {
        if (data.resp == "OK") {
            $("#addEditUser").modal("show");
            document.getElementById("person").value = data.name;
            document.getElementById("middle").value = data.middle;
            document.getElementById("username-o").value = data.username;
            document.getElementById("role").value = data.role;
            document.getElementById("pass-o").value = data.pass;
            document.getElementById("userId").value = data.id;
            document.getElementById("operation").value = 'update';
        } else {

            console.log(data);
        }
        })
        .catch(function(err) {
            console.log(err);
         });
};

DeleteUser = (Id) => {

    const data = new FormData();

    data.append('id', Id);
    data.append('operation', "delete");

    fetch("includes/functions.php", {
        method: "POST",
        body: data,
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);

            if (data.resp == "OK") {
                Swal.fire({
                    icon: "success",
                    title: "Correcto!",
                    text: data.message,
                });
                setTimeout(() => {
                    window.location.href = data.url;
                }, 2000);
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: data.message,
                });
            }
        })
        .catch(function(err) {
            console.log(err);
         });
};
