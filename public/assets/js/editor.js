$(document).ready(function () {



    // Airplane Tickets 
    $(document).on('click', '.ticket-btn', function () {
        const ticketId = $(this).data('id'); 
        const updateForm = $("#updateAirplaneTicket");
        updateForm.attr('action', `/api/airplane-tickets/${ticketId}`);

        $.ajax({
            url: `/api/airplane-tickets/${ticketId}`,
            type: 'GET',
            success: function (data) {
                console.log(data);
                const answeredByName = data.data.answered_by ? data.data.answered_by.name : 'Not Answered Yet';
                const answered = data.data.answer ? data.data.answer : 'Not Answered Yet';
                console.log(answeredByName);
                $('#editUserName').val(data.data.name);
            
                // Display airplane ticket details in the modal
                $('#airplaneTicketType').text(data.data.ticket_type);
                $('#fromDestination').text(data.data.from_destination);
                $('#toDestination').text(data.data.to_destination);
                $('#departureDate').text(data.data.departure_date);
                $('#returnDate').text(data.data.return_date);
                $('#travelAdults').text(data.data.adults);
                $('#travelChildren').text(data.data.children);
                $('#travelBabies').text(data.data.babies);
                $('#travelClass').text(data.data.class);
                $('#contactName').text(data.data.name);
                $('#contactEmail').text(data.data.email);
                $('#contactMessage').text(data.data.message);
                $('#answeredByName').text(answeredByName);
                $('#answerMessage').text(answered);
            
                // Show the modal
                $("#airplaneTicketsModal").removeClass("hidden");
                $("#overlay2").removeClass("hidden");
            },
            error: function (error) {
                console.error('Error fetching contact details:', error);
            }
        });
    });

    // Close modal when the close button is clicked
    $("#closeAirplaneTicketsModal").click(function () {
        $("#airplaneTicketsModal").addClass("hidden");
        $("#overlay2").addClass("hidden");
    });



    $('#updateAirplaneTicket').submit(function (event) {
      
        event.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT', 
            data: formData,
            success: function (data) {

                $("#airplaneTicketsModal").addClass("hidden");
                $("#overlay2").addClass("hidden");
                setTimeout(function() {
                    console.log('This will execute after 1 second');
                    location.reload();
                }, 1);
            },
            error: function (error) {
                console.error('Errors updating airplane ticket:', error);
            }
        });
    });

    // Airplane Tickets complete

    // Contact Us
    $(document).on('click', '.contact-us-btn', function () {
        const contactId = $(this).data('id'); 
        const updateContactForm = $("#updateContactUs");
        updateContactForm.attr('action', `/api/contact-us/${contactId}`);

        $.ajax({
            url: `/api/contact-us/${contactId}`,
            type: 'GET',
            success: function (data) {
                console.log(data);
                const answeredByName = data.data.answered_by ? data.data.answered_by.name : 'Not Answered Yet';
                const answer = data.data.answer ? data.data.answer : 'Not Answered Yet';
                console.log(answeredByName);
                $('#editUserName').val(data.data.name);
            
                // Display airplane ticket details in the modal
                $('#contactUsName').text(data.data.name);
                $('#contactUsEmail').text(data.data.email);
                $('#contactUsMessage').text(data.data.message);
                $('#contactUsAnsweredByName').text(answeredByName);
                $('#contactUsAnswerMessage').text(answer);
            
                // Show the modal
                $("#contactUsModal").removeClass("hidden");
                $("#overlay2").removeClass("hidden");
            },
            error: function (error) {
                console.error('Error fetching contact details:', error);
            }
        });
    });

    // Close modal when the close button is clicked
    $("#closeContactUsModal").click(function () {
        $("#contactUsModal").addClass("hidden");
        $("#overlay2").addClass("hidden");
    });



    $('#updateContactUs').submit(function (event) {
        event.preventDefault();

        // Serialize form data
        var formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            type: 'PUT', 
            data: formData,
            success: function (data) {

                console.log(data);
                $("#contactUsModal").addClass("hidden");
                $("#overlay2").addClass("hidden");
                setTimeout(function() {
                    location.reload();
                }, 1);
            },
            error: function (error) {
                console.error('Errors updating contact Us request:', error);
            }
        });
    });

    // contact us compleated


    //subscribers modal

    $("#openEmailModal").click(function () {
        $("#emailSubscribersModal").removeClass("hidden");
        $("#overlay2").removeClass("hidden");
    });
    $("#closeEmailSubscribersModal").click(function () {
        $("#emailSubscribersModal").addClass("hidden");
        $("#overlay2").addClass("hidden");
    });

    // testimonial modal
    $("#newTestimonial").click(function () {
        $("#testimonialModal").removeClass("hidden");
        $("#overlay2").removeClass("hidden");
    });
    $("#closeTestimonialModal").click(function () {
        $("#testimonialModal").addClass("hidden");
        $("#overlay2").addClass("hidden");
    });

    // Moment modal
    $("#newMoment").click(function () {
        $("#momentModal").removeClass("hidden");
        $("#overlay2").removeClass("hidden");
    });
    $("#closeMomentModal").click(function () {
        $("#momentModal").addClass("hidden");
        $("#overlay2").addClass("hidden");
    });

    // permament delete testimonial / moment 
    // Testimonial deletion confirmation
    $(".delete_testimonial button").click(function () {
        console.log(this);  // Log the button element
        confirmDeleteTestimonial(this);
    });
    function confirmDeleteTestimonial(button) {
        var testimonialId = $(button).data('testimonial-id');
    
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
                // Use the testimonialId variable
                console.log('Testimonial ID:', testimonialId);
    
                // Set the form action dynamically
                var actionUrl = '/testimonials/perm-delete/' + testimonialId;
                $('#deleteForm_' + testimonialId).attr('action', actionUrl);
    
                // Log the constructed URL for debugging
                console.log('Form action:', actionUrl);
    
                // Submit the form
                $('#deleteForm_' + testimonialId).submit();
            }
        });
    }
    

    $("#deleteForm").click(function () {
        confirmDelete()
    });

    // Coutnry modal
    $("#newCountry").click(function () {
        $("#countryModal").removeClass("hidden");
        $("#overlay2").removeClass("hidden");
    });
    $("#closeCountryModal").click(function () {
        $("#countryModal").addClass("hidden");
        $("#overlay2").addClass("hidden");
    });
    // City modal
    $("#newCity").click(function () {
        $("#cityModal").removeClass("hidden");
        $("#overlay2").removeClass("hidden");
    });
    $("#closeCityModal").click(function () {
        $("#cityModal").addClass("hidden");
        $("#overlay2").addClass("hidden");
    });
    $("#newResort").click(function () {
        $("#resortModal").removeClass("hidden");
        $("#overlay2").removeClass("hidden");
    });
    $("#closeResortModal").click(function () {
        $("#resortModal").addClass("hidden");
        $("#overlay2").addClass("hidden");
    });

    $('#new_country_id').change(function () {
        console.log("change happened");
        var countryId = $(this).val();

        $.ajax({
            url: 'http://127.0.0.1:8000/getCities/' + countryId, 
            type: 'GET',
            success: function (data) {
                $('#new_city_id').empty();
        
                if (data.cities.length > 0) {
                    $.each(data.cities, function (key, value) {
        
                        $('#new_city_id').append('<option value="' + value.id + '">' + value.city_name  + '</option>');
                    });
                } else {
                    $('#new_city_id').append('<option value="">No cities yet</option>');
                }
            },
            error: function (error) {
                console.error('Error fetching cities:', error);
            }
        });
        
    });
    // deleteAirplaneTicketForm
    $(document).on('click', '.deleteAirplaneTicketForm button[type="submit"]', function (event) {
        event.preventDefault();
        var button = $(this);
        var form = button.closest('form');
        var ticketId = button.data('ticket-id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var actionUrl = '/editor/airplane-tickets/' + ticketId;
                form.attr('action', actionUrl);
                form.submit();
                setTimeout(function() {
                    location.reload();
                }, 1);
            }
        });
    });
    
    
    // ...

    // Delete contact form submission
    $(document).on('submit', '.deleteContactUsForm', function (event) {
        event.preventDefault();

        var form = $(this);
        var contactId = form.find('button[type="submit"]').data('ticket-id');

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
                // Use the contactId variable
                console.log('Contact ID:', contactId);

                // Set the form action dynamically
                var actionUrl = form.attr('action');
                form.attr('action', actionUrl);

                // Log the constructed URL for debugging
                console.log('Form action:', actionUrl);

                // Perform the Ajax submission
                $.ajax({
                    url: actionUrl,
                    type: 'DELETE',
                    data: form.serialize(),
                    success: function (data) {
                        console.log(data);
                        setTimeout(function () {
                            location.reload();
                        }, 1);
                    },
                    error: function (error) {
                        console.error('Error deleting contact request:', error);
                    }
                });
            }
        });
    });

    // ...
    // delete moment
    $(".delete_moment button").click(function () {
        console.log(this);  // Log the button element
        confirmDeleteMoment(this);
    });
    function confirmDeleteMoment(button) {
        var testimonialId = $(button).data('moment-id');

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
            console.log('Moment ID:', testimonialId);

            var actionUrl = '/moments/perm-delete/' + testimonialId;
            $('#deleteForm_' + testimonialId).attr('action', actionUrl);

            console.log('Form action:', actionUrl);

            $('#deleteForm_' + testimonialId).submit();
        }
    });
    }

    // delete resort
    $(".delete_resort button").click(function () {
        console.log(this); 
        confirmDeleteResort(this);
    });
    function confirmDeleteResort(button) {
        var testimonialId = $(button).data('resort-id');

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
            console.log('Resort ID:', testimonialId);

            var actionUrl = '/resort/perm-delete/' + testimonialId;
            $('#deleteForm_' + testimonialId).attr('action', actionUrl);

            console.log('Form action:', actionUrl);

            $('#deleteForm_' + testimonialId).submit();
        }
    });
    }

    //new apartment modal
    $("#newApartmantBtn").click(function () {
        $("#apartmentModal").removeClass("hidden");
        $("#overlay2").removeClass("hidden");
    });
    $("#closeApartmantModal").click(function () {
        $("#apartmentModal").addClass("hidden");
        $("#overlay2").addClass("hidden");
    });
    //new image modal
    $(".add-image-btn").click(function () {
        $("#imageApartmantModal").removeClass("hidden");
        $("#overlay2").removeClass("hidden");
    });
    $("#closeImageApartmantModal").click(function () {
        $("#imageApartmantModal").addClass("hidden");
        $("#overlay2").addClass("hidden");
    });

    $('.add-image-btn').on('click', function () {
        const apartmentId = $(this).data('apartment-id');
        $('#apartmentIdInput').val(apartmentId);
    });

    $(document).on('click', '.delete-image-btn', function () {
        let imageId = $(this).data('image-id');
    
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // User clicked "Yes," proceed with the native fetch API
                fetch('/apartment-images/' + imageId, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Handle success, maybe remove the image container
                    console.log(data);
                    Swal.fire('Deleted!', 'Your image has been deleted.', 'success');
                    location.reload();
                })
                .catch(error => {
                    // Handle error
                    console.error(error);
                    Swal.fire('Error', 'Failed to delete the image.', 'error');
                });
            }
        });
    });
    
    $(".delete_apartmant button").click(function () {
        var apartmentId = $(this).closest('form').data('apartment-id');
    
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
                $.ajax({
                    type: 'POST',
                    url: '/apartments/perm-delete/' + apartmentId,
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'), // Use the CSRF token from the meta tag
                        _method: 'DELETE'
                    },
                    success: function (response) {
                        console.log(response);
                        window.location.reload();
                    },
                    error: function (error) {
                        console.error(error);
                        Swal.fire('Error', 'An error occurred while deleting the apartment.', 'error');
                    }
                });
            }
        });
    });


    
    $("#add_new_price").click(function () {
        $("#apartmentPriceModal").removeClass("hidden");
        $("#overlay2").removeClass("hidden");
    });
    $("#closeApartmantPriceModal").click(function () {
        $("#apartmentPriceModal").addClass("hidden");
        $("#overlay2").addClass("hidden");
    });

    $('#start_date').on('input', function() {
        var minDate = $(this).val();
        $('#end_date').attr('min', minDate);

        // If the current end date is before the new min date, update the end date value
        if ($('#end_date').val() < minDate) {
            $('#end_date').val(minDate);
        }
    });

    // delete price axios
    $(document).on('click', '.delete-price', function () {
        var priceId = $(this).data('price-id');
    
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
                axios.delete(`/prices/delete/${priceId}`)
                    .then(response => {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Your file has been deleted.',
                            icon: 'success',
                            onClose: () => {
                                // Reload the page after closing the alert
                                location.reload();
                            }
                        });
                    })
                    .catch(error => {
                        // Handle errors, e.g., show an error message
                        Swal.fire('Error!', 'An error occurred while deleting the file.', 'error');
                    });
            }
        });
    });
    

  
});
