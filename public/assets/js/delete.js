// for delete action
const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-danger ms-2',
        cancelButton: 'btn btn-secondary'
    },
    buttonsStyling: false
});

function confirmDelete(studentId) {
    swalWithBootstrapButtons.fire({
        title: 'Delete Record',
        text: 'Are you sure you want to delete?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-trash me-2"></i>Delete',
        cancelButtonText: '<i class="fas fa-times me-2"></i>Cancel',
        reverseButtons: true,
        backdrop: true,
        showClass: {
            popup: 'animate__animated animate__fadeIn'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteForm' + studentId).submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
                title: 'Cancelled',
                text: 'This record is safe',
                icon: 'info',
                timer: 2000,
                showConfirmButton: false
            });
        }
    });
}

// Success message notification
function showSuccessMessage(message) {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: message,
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
        customClass: {
            popup: 'colored-toast'
        }
    });
}

// Check for success message on page load
document.addEventListener('DOMContentLoaded', function() {
    const successMessage = document.querySelector('meta[name="success-message"]')?.content;
    if (successMessage) {
        showSuccessMessage(successMessage);
    }
});