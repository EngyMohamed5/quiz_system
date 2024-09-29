
// document.querySelectorAll('.sidebar ul li').forEach(function (item) {
//     item.addEventListener('click', function () {
//         document.querySelector('.sidebar ul li.active')?.classList.remove('active');
//         item.classList.add('active');
//     });
// });


document.querySelector('.open-btn').addEventListener('click', function () {
    document.querySelector('.sidebar').classList.add('active');
});


document.querySelector('.close-btn').addEventListener('click', function () {
    document.querySelector('.sidebar').classList.remove('active');
});

document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const formElement = this;

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    formElement.submit();
                }
            });
        });
});

