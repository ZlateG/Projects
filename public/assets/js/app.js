$(document).ready(function () {
    // Initial load of users
    loadUsers();

    
    function loadUsers() {
        $.ajax({
            url: '/get-users',
            method: 'GET',
            dataType: 'json',
            success: function (users) {
                // Clear existing content in the user-container
                clearUserContainer();

                // Display users in the user-container
                displayUsers(users);
            },
            error: function (error) {
                console.error('Error fetching users:', error);
            }
        });
    }

    // Function to clear existing content in the user-container
    function clearUserContainer() {
        const userContainer = $('#user-container');
        userContainer.empty();
    }

    // Function to display users in the user-container
    function displayUsers(users) {
        const userContainer = $('#user-container');
        userContainer.html(renderUsersTable(users));
    }


        // Function to render users table
        function renderUsersTable(users) {
            let html = '<table class="min-w-full border">';
            // Add table header
            html += '<thead><tr class="bg-gray-300">';
            html += '<th class="border px-4 py-2">ID</th>';
            html += '<th class="border px-4 py-2">Name</th>';
            html += '<th class="border px-4 py-2">Email</th>';
            html += '<th class="border px-4 py-2">Role</th>';
            html += '<th class="border px-4 py-2">Status</th>';
            html += '<th class="border px-4 py-2">Actions</th>';
            html += '</tr></thead><tbody>';
            // Add user rows
            users.forEach(user => {
                html += '<tr>';
                html += `<td class="border px-4 py-2">${user.id}</td>`;
                html += `<td class="border px-4 py-2">${user.name}</td>`;
                html += `<td class="border px-4 py-2">${user.email}</td>`;
                html += `<td class="capitalize  border px-4 py-2">${user.role.name}</td>`;
                html += `<td class="border px-4 py-2">${user.status === 1 ? 'Active' : 'Not Active'}</td>`;
                html += '<td class="border px-4 py-2">';
                html += `<button class="edit-user bg-blue-400 text-white p-1 border border-blue-500 mr-1 hover:bg-blue-500 rounded" data-id="${user.id}">Edit</button>`;
                html += `<button class="delete-user bg-red-400 text-white p-1 border border-red-500 hover:bg-red-500 rounded" data-id="${user.id}" ${user.role.name =='admin' ? 'disabled' : ''}>Delete</button>`;
                html += '</td></tr>';
            });
            html += '</tbody></table>';
            return html;
        }

    // click event for edit buttons
    $(document).on('click', '.edit-user', function () {
        const userId = $(this).data('id'); // Get the user ID from the button
    
        // Fetch user details 
        fetchUserDetails(userId);
        
        // Show the editUserModal
        $("#editUserModal").removeClass("hidden");
        $("#overlay").removeClass("hidden");
    });


    // Close modal when the close button is clicked
    $("#closeEditUserModal").click(function () {
        $("#editUserModal").addClass("hidden");
        $("#overlay").addClass("hidden");
    });

    // Use jQuery to handle the click event for delete buttons
    $(document).on('click', '.delete-user', function () {
        const userId = $(this).data('id'); // Use jQuery to get data attribute

        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Send AJAX request to delete user
                deleteUser(userId);
            }
        });
    });

    // Function to delete user via AJAX
    function deleteUser(userId) {

        axios.delete(`/admin/users/${userId}`)
            .then(response => {
                // Handle success
                Swal.fire({
                    title: 'Deleted!',
                    text: 'User has been deleted.',
                    icon: 'success'
                });
                // Reload users after deletion
                loadUsers();
            })
            .catch(error => {
                // Handle error
                console.error('Error deleting user:', error);
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while deleting the user.',
                    icon: 'error'
                });
            });
    }


    // modal add user
    // Show modal when the button is clicked
    $("#addUserButton").click(function () {
        $("#addUserModal").removeClass("hidden");
    });

    // Close modal when the close button is clicked
    $("#closeModalButton").click(function () {
        $("#addUserModal").addClass("hidden");
    });

    // Close modal when clicking outside the modal content
    $(document).on("click", function (e) {
        if ($(e.target).is("#addUserModal")) {
            $("#addUserModal").addClass("hidden");
        }
    });


    //// ///////////////////////////

        function fetchUserDetails(userId) {
            $.ajax({
                url: `/get-user-details/${userId}`,
                method: 'GET',
                dataType: 'json',
                success: function (userDetails) {
                    console.log('User Details:', userDetails);
                    console.log('Current Role ID:', userDetails.role);
        
                    // Populate the modal with user details
                    $('#editUserID').val(userDetails.id);
                    $('#editUserName').val(userDetails.name);
                    $('#editUserEmail').val(userDetails.email);
                    $('#editUserStatus').val(userDetails.status);
        
                    // Fetch and populate user role dropdown
                    fetchUserRolesAndPopulateDropdown(userDetails.role_id);
        
                    // Set the form action dynamically based on the user ID
                    $('#editUserForm').attr('action', '/admin/users/' + userDetails.id);
                },
                error: function (error) {
                    console.error('Error fetching user details:', error);
                }
            });
        }
        

// Function to fetch user roles and populate the role dropdown
function fetchUserRolesAndPopulateDropdown(selectedRoleId) {
    $.ajax({
        url: '/admin/get-roles', // Replace with the actual route to fetch roles
        method: 'GET',
        dataType: 'json',
        success: function (roles) {
            // Clear existing options in the dropdown
            $('#editUserRole').empty();

            // Add default option
            $('#editUserRole').append('<option value="" disabled>Select Role</option>');

            // Iterate through roles and add options to the dropdown
            roles.forEach(role => {
                const option = $('<option></option>');
                option.attr('value', role.id);
                option.text(role.name);

                // Check if the role id matches the selectedRoleId
                if (role.id == selectedRoleId) {
                    option.prop('selected', true);
                }

                // Append the option to the dropdown
                $('#editUserRole').append(option);
            });
        },
        error: function (error) {
            console.error('Error fetching roles:', error);
        }
    });
}

    

        
        //  modal is opened
        $('#editUserModal').on('show.bs.modal', function (event) {
            const userId = $(event.relatedTarget).data('user-id');
            fetchUserDetails(userId);
        });

  
        
    /////////////////////////////


});
