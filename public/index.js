$(function() {
    // swal alert message

    // Swal.fire({
    //     title: 'Are you sure?',
    //     text: "This will permanently delete the book and its associated comments and notes.",
    //     icon: 'warning',
    //     showCancelButton: true,
    //     confirmButtonColor: '#3085d6',
    //     cancelButtonColor: '#d33',
    //     confirmButtonText: 'Yes, delete it!'
    // }).then((result) => {
    //     if (result.isConfirmed) {
    //         // User confirmed the deletion
    //         // Call your AJAX request here
    //     }
    // });
 
    // get the quotes from the appi
    let quotableParagraph = $('#quotable')
    
    $.ajax({
        method: 'get',
        url: 'http://api.quotable.io/random',
        success: function(data) {
            let fullQuotable = data.content + ' By: ' + data.author;
            quotableParagraph.html(fullQuotable);
            console.log(data.content);
        }
    });


    // alert messages
    function showMessage(messageElement, messageText, delay) {
        messageElement.text(messageText);
        messageElement.show().delay(delay).fadeOut(2000);
    }
    // handle the alert message
    // showMessage($('#id-tag'), "Item was successfully removed", 5000); 
    
    
    // display comments --DONE
    function displayComments() {
        if (typeof bookId === 'undefined') {
            console.log("bookId is not defined. Cannot display comments.");
            return;
        }
    
        $.ajax({
            url: "../resourses/includes/comments.php",
            method: "GET",
            data: { book_id: bookId },
            dataType: "json",
            success: function(data) {
                console.log("comment data", data);
                console.log('ova e userid: ', userId);
    
                var commentsContainer = $('#comments');
                commentsContainer.empty();
    
                data.forEach(function(comment) {
                    var commentContainer = $('<div class="bg-white shadow-xl rounded-lg overflow-hidden max-w-xs mt-4 comment-container">');
                    var commentContent = $('<div class="p-4">');
    
                    commentContent.append('<h3 class="text-xl font-semibold mb-2">Comment</h3>');
                    commentContent.append('<p class="comment-text">' + comment.comment + '</p>');
                    commentContent.append('<p>Comment by: ' + comment.user_uid + '</p>');
    
                    if (comment.user_id === userId) {
                        var deleteButton = $('<button class="delete-comment-btn bg-red-400 hover:bg-red-500 text-white px-4 py-2 rounded-lg">Delete Comment</button>');
                        deleteButton.data('comment-id', comment.comments_id);
    
                        deleteButton.on('click', function() {
                            var commentId = $(this).data('comments-id');
                            deleteComment(commentId); 
                        });
    
                        commentContent.append(deleteButton);
                    }
    
                    if (comment.is_approved === 0) {
                        if (comment.user_id !== userId) {
                            return; 
                        }
    
                        commentContent.append('<br/>', "(comment awaiting approval)");
                    }
    
                    commentContainer.append(commentContent);
                    commentsContainer.append(commentContainer);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", jqXHR,  textStatus, errorThrown);
            }
        });
    }
    
    displayComments(); 

    // delete comment function --DONE
    function deleteComment(commentId) {

        Swal.fire({
            title: 'Are you sure?',
            text: "This delete your comment.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../resourses/includes/delete_comment.php',
                    method: 'POST',
                    data: { comments_id: commentId },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            showMessage($('#commentMessage'), 'Comment deleted successfully', 5000); 
                            console.log('Comment deleted successfully');
                            displayComments();
                        } else {
                            showMessage($('#commentMessage'), 'Failed to delete comment', 5000); 
                            console.error('Failed to delete comment');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX error:', jqXHR, textStatus, errorThrown);
                    }
                });
            }
    });
      
    
    }

    //click event to delete comment buttons --DONE
    $('#comments').on('click', '.delete-comment-btn', function() {
        var commentId = $(this).data('comment-id'); 
        deleteComment(commentId);
    });

    // Handle form submission to add a new comment --DONE
    $('#add-comment-form').submit(function(e) {
        e.preventDefault();

        // Use SweetAlert2 for confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to add this comment?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, add it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var commentText = $('#comment-text').val();

                $.ajax({
                    url: "../resourses/includes/add_comment.php",
                    method: "POST",
                    data: {
                        book_id: bookId,
                        comment: commentText
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log("Comment data:", response);
                        if (response.success) {
                            $('#comment-text').val('');
                            displayComments();
                            showMessage($('#commentMessage'), "Comment added successfully", 5000);
                            console.log('Comment added successfully');
                        } else {
                            showMessage($('#commentMessage'), "Comment insertion failed.", 5000);
                            console.error("Comment insertion failed.");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error:", jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    });

    

    // Display Notes using AJAX --DONE
 
    function displayNotes() {
        if (typeof bookId === 'undefined') {
            console.log("bookId is not defined.");
            return;
        }
        $.ajax({
            url: "../resourses/includes/notes.php",
            method: "GET",
            data: { book_id: bookId },
            dataType: "json",
            success: function(data) {
                console.log("Notes data:", data);
                var notesContainer = $('#notes');
                notesContainer.empty();
    
                data.forEach(function(note) {
                    var noteContainer = $('<div class="bg-white shadow-xl rounded-lg overflow-hidden max-w-xs mt-4 note-container">');
                    var noteContent = $('<div class="p-4">');
    
                    noteContent.append('<h3 class="text-xl font-semibold mb-2">Your Note</h3>');
                    noteContent.append('<p class="note">' + note.note + '</p>');
    
                    var deleteNoteLink = $('<button class="delete-note-btn bg-red-400 hover:bg-red-500 text-white px-4 py-2 rounded-lg mr-4 cursor-pointer" data-note-id="' + note.note_id + '">Delete Note</button>');
                    deleteNoteLink.on('click', function() {
                        var noteId = $(this).data('note-id');
                        // Handle delete functionality here
                        // You can call a function to delete the note
                    });
    
                    var editNoteLink = $('<button class="edit-note-btn bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded-lg mr-4 cursor-pointer" data-note-id="' + note.note_id + '">Edit Note</button>');
                    editNoteLink.on('click', function() {
                        var noteId = $(this).data('note-id');
                        // Handle edit functionality here
                        // You can call a function to edit the note
                    });
    
                    noteContent.append(editNoteLink);
                    noteContent.append(deleteNoteLink);
                    noteContainer.append(noteContent);
                    notesContainer.append(noteContainer);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", textStatus, errorThrown);
            }
        });
    }
    

    displayNotes();

    //update notes
    function updateNote(noteId, newNoteContent) {
     
        var dataToSend = {
            note_id: noteId,
            new_note: newNoteContent
        };

        $.ajax({
            url: '../resourses/includes/update_notes.php',
            method: 'POST',
            data: dataToSend,
            dataType: 'json',
            success: function (response) {
                
                if (response.success) {
                 
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Note updated successfully',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update note: ' + response.error,
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('AJAX error:', textStatus, errorThrown);
                console.log('Response Text:', jqXHR.responseText); 
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating the note.',
                });
            }
        });
    }
    $(document).on('click', '.edit-note-btn', function () {
        var noteId = $(this).data('note-id');
        Swal.fire({
            title: 'Edit Note',
            input: 'text',
            inputValue: '', // You can pre-fill the input with the existing note content
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Cancel',
            inputValidator: (value) => {
                if (!value) {
                    return 'Note content is required';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                var newNoteContent = result.value;
                updateNote(noteId, newNoteContent);
                displayNotes();
            }
        });
    });
    
    // Handle form submission to add a new note --DONE
    $('#add-note-form').submit(function(event) {
        event.preventDefault();

        var noteText = $('#note-text').val();

        Swal.fire({
            title: 'Are you sure?',
            text: "This Add your note.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, add the note!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../resourses/includes/add_note.php",
                    method: "POST",
                    data: {
                        book_id: bookId,
                        note: noteText,
                        user_id: userId
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            showMessage($('#noteMessage'), "Note Added ", 5000); 
                            $('#note-text').val('');
                            displayNotes();
                        } else {
                            showMessage($('#noteMessage'), "Note insertion failed.", 5000); 
                            console.error("Note insertion failed.");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error:", textStatus, errorThrown);
                    }
                });
            }
        });

    
    });
    

    // delete note button with a class of "delete-note-btn" --DONE
    $('#notes').on('click', '.delete-note-btn', function() {
        var noteId = $(this).data('note-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete your note!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make an AJAX request to delete the note --DONE
                $.ajax({
                    url: '../resourses/includes/delete_note.php',
                    method: 'POST',
                    data: { note_id: noteId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            showMessage($('#noteMessage'), "Note deleted successfully", 5000); 
                            console.log('Note deleted successfully');
                            displayNotes();
                        } else {
                            showMessage($('#noteMessage'), "Failed to delete note", 5000); 
                            console.error('Failed to delete note');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX error:',jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    

    });

    $('.category-checkbox').on('change', function() {
        var selectedCategories = [];
        $('.category-checkbox:checked').each(function() {
            selectedCategories.push($(this).val());
        });

        // search options call --DONE
        $.ajax({
            url: '../resourses/includes/search_options.php',
            method: 'POST',
            data: { selectedCategories: selectedCategories },
            dataType: 'html',
            success: function(response) {
                
                $('#categoryResults').html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX error:' , jqXHR, textStatus, errorThrown);
            }
        });
    });


    // search input --DONE
    $("#searchInput").keyup(function() {
        var searchValue = $(this).val().trim();
        if (searchValue != '') {
            $.ajax({
                url: "../resourses/includes/search.php", 
                method: "POST",
                data: { search: searchValue },
                dataType: "html",
                success: function(response) {
                    $("#searchResults").html(response);
                }
            });
        } else {
            $("#searchResults").html("");
        }
    });

    // Function to add a book to the cart --DONE
    function addToCart(bookId) {

        Swal.fire({
            title: 'Add to Cart?',
            text: "This book will be added to your cart.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, add it!'
        }).then((result) => {
            if (result.isConfirmed) {
                    
                $.ajax({
                    type: "POST",
                    url: "../resourses/includes/add_to_cart.php",
                    data: { bookId: bookId },
                    success: function (response) {
                        showMessage($('#cartMessage'), response, 5000); 
            
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    },
                });
            }
        });
 

    }

    // Add click event listener to "Add to Cart" button --DONE
   
    $("#add-to-cart").click(function () {
        var bookId = $(this).data("book-id");
        addToCart(bookId);
    });
    

   
    function removeCartItem(bookId) {
        var cartItem = $('.cart-item[data-book-id="' + bookId + '"]');
        cartItem.remove();
    }

    // Handle "Remove from cart" button click --DONE
    $('.remove-from-cart').on('click', function() {
        var bookId = $(this).data('book-id');

            Swal.fire({
            title: 'Are you sure?',
            text: "This will remove the book from your cart",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '../resourses/includes/removeFromCart.php',
                    data: { book_id: bookId },
                    success: function(response) {
                        if (response === 'success') {
                            showMessage($('#cartMessage'), "Item was successfully removed", 5000); 
                            removeCartItem(bookId);  
                            setTimeout(function() { location.reload();  }, 3000);
                        } else {
                            alert('An error occurred while removing the item.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while making the AJAX request.');
                    }
                });
            }
            });

 
    });

    // Get the error parameter from the URL --DONE
    const urlParams = new URLSearchParams(window.location.search);
    const errorParam = urlParams.get("error");

   
    const errorMessages = {
        "emptyinput": "Please fill in all fields.",
        "username": "Invalid username. Use only letters and numbers.",
        "email": "Invalid email address.",
        "pasworddontmatch1": "Passwords do not match.",
        "userIDnotUnique": "Username or email is already taken."
    };

    // Display error message if error parameter exists
    if (errorParam && errorMessages[errorParam]) {
        const errorMessage = errorMessages[errorParam];
        $("#signUpError").text(errorMessage).removeClass("hidden");
    }


})