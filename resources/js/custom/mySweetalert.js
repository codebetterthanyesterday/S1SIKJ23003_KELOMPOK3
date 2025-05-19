import Swal from 'sweetalert2';
document.querySelector(".do-logout").onclick = function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Are you sure?",
        text: "Are you sure you want to log out? Any unsaved changes may be lost.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#757575",
        confirmButtonText: "Yes, logout!",
    }).then((result) => {
        if (result.isConfirmed) {
            this.closest("form").submit();
        }
    });
};
