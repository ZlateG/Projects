$(function() {
    
    // show alert function
    function showMessage(messageElement, messageText, delay) {
        messageElement.text(messageText);
        messageElement.show().delay(delay).fadeOut(2000);
    }
    
    // handle the message 
    // showMessage($('#categoryMessage'), "Item was successfully removed", 5000); 

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
        


    // get the quotes from the appi --DONE
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

    // get unapproved comments using AJAX get --DONE
    function fetchUnapprovedComments() {
        $.ajax({
            url: "../resourses/includes/fetchComments.php",
            method: "GET",
            dataType: "json",
            success: function(data) {
                var tableBody = $("#commentsTable tbody");
                tableBody.empty();
                if (data.length ===0) {
                    tableBody.append('<tr><td colspan="5" class="py-2 px-4 border text-center">All comments are approved.</td></tr>');
                } 
                else 
                {
                    data.forEach(function(comment) {
                        var row = $("<tr>");
                        row.append('<td class="py-2 px-4 border border-gray-300">' + comment.book_title + '</td>');
                        row.append('<td class="py-2 px-4 border border-gray-300">' + comment.author_name + '</td>');
                        row.append('<td class="py-2 px-4 border border-gray-300">' + comment.user_uid + '</td>');
                        row.append('<td class="py-2 px-4 border border-gray-300">' + comment.comment + '</td>');
        
                        var approveButton = $('<button>Approve Comment</button>');
                        approveButton.attr('value', comment.comments_id);
                        approveButton.addClass('approve-btn bg-green-400 hover:bg-green-500 px-4 py-1 rounded-lg mr-4')
                        row.append($('<td class="py-2 px-4 border">').append(approveButton));
                        tableBody.append(row);
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX error:", jqXHR, textStatus, errorThrown);
            }
        });
    }
    // call the function 
    fetchUnapprovedComments();

    // approve comments on click -- DONE
    $('table').on('click', '.approve-btn', function(e) {
        e.preventDefault();

        var commentId = $(this).attr('value');
          Swal.fire({
            title: 'Are you sure?',
            text: "Approve This Comment?",
            icon:  'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../resourses/includes/approveComment.php",
                    method: "POST",
                    data: {
                        comment_id: commentId
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            showMessage($('#commentMessage'), "Comment approved successfully.", 3000); 
                            fetchUnapprovedComments();
                        } else {
                            showMessage($('#commentMessage'), "Comment approval failed.", 3000);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error:", textStatus, errorThrown);
                    }
                });
            }
        });

    });

    // Function to fetch and display categories --DONE

    function updateCategory(categoryId, newCategoryName, callback) {
        $.ajax({
            url: "../resourses/includes/update_category.php", 
            method: "POST",
            data: {
                category_id: categoryId,
                new_category_name: newCategoryName
            },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    
                    callback(true);
                } else {
                  
                    callback(false);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", jqXHR, textStatus, errorThrown);
                callback(false);
            }
        });
    }
    
    // Function to fetch and display categories
    function displayCategories() {
        $.ajax({
            url: "../resourses/includes/get_categories.php",
            method: "GET",
            dataType: "json",
            success: function(data) {
                var categoriesTableBody = $('#categories-table tbody');
                categoriesTableBody.empty();

                data.forEach(function(category) {
                    var row = '<tr>' +
                        '<td class="py-2 px-4 border border-gray-300">' + category.category_id + '</td>' +
                        '<td class="py-2 px-4 border border-gray-300">' +
                        '<span class="category-name">' + category.category_name + '</span>' +
                        '<input type="text" class="edit-category-input border p-1 w-full hidden">' +
                        '</td>' +
                        '<td class="py-2 px-4 border border-gray-300">' + '<button class="edit-btn bg-blue-400 hover:bg-blue-500 px-4 py-1 rounded-lg mr-4" data-category-id="' + category.category_id + '">Edit</button>'+ '</td>' +
                        '<td  class="py-2 px-4 border border-gray-300">';
                
                    if (category.is_deleted === 1) {
                        row += '<button class="undo-btn bg-green-400 hover:bg-green-500 px-4 py-1 rounded-lg mr-4">Undo Delete</button>';
                    } else {
                        row += '<button class="delete-btn bg-red-400 hover:bg-red-500 text-white px-4 py-2 rounded-lg">Delete</button>';
                    }
                
                    row += '</td>' +
                        '</tr>';
                    categoriesTableBody.append(row);
                });

                // Function to handle the edit functionality
                function handleEditCategory() {
                    $('#categories-table').on('click', '.edit-btn', function() {
                        var categoryId = $(this).data('category-id');
                        var row = $(this).closest('tr');
                        var categoryNameSpan = row.find('.category-name');
                        var editCategoryInput = row.find('.edit-category-input');
                        var editButton = $(this);
                        var isEditing = editButton.data('isEditing') || false;

                        if (!isEditing) {
                            // Switch to edit mode
                            categoryNameSpan.addClass('hidden');
                            editCategoryInput.removeClass('hidden').val(categoryNameSpan.text());
                            editButton.text('Save');
                            editButton.data('isEditing', true);
                        } else {
                            // Handle the save action here
                            var newCategoryName = editCategoryInput.val();

                            updateCategory(categoryId, newCategoryName, function(success) {
                                if (success) {
                                    categoryNameSpan.text(newCategoryName);
                                    categoryNameSpan.removeClass('hidden');
                                    editCategoryInput.addClass('hidden');
                                    editButton.text('Edit');
                                    editButton.data('isEditing', false);
                                } else {
                                    // If there's an error, revert the button and input field to their original state
                                    categoryNameSpan.removeClass('hidden');
                                    editCategoryInput.addClass('hidden');
                                    editButton.text('Edit');
                                    editButton.data('isEditing', false);
                                    alert('Failed to update category.');
                                }
                            });
                        }
                    });
                }




                // Call the function to initialize the edit functionality
                handleEditCategory();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", jqXHR, textStatus, errorThrown);
            }
        });
    }

    // Call the function to display categories --DONE
    displayCategories();


    // soft delete ajax call for categories --DONE
    $('#categories-table').on('click', '.delete-btn', function() {
        var categoryRow = $(this).closest('tr');
        var categoryId = categoryRow.find('td:eq(0)').text(); 
        
        Swal.fire({
        title: 'Are you sure?',
        text: "This will delete the category.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../resourses/includes/soft_delete_category.php",
                    method: "POST",
                    data: { category_id: categoryId },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            showMessage($('#categoryMessage'), "Category deleted successfully.", 5000);
                            displayCategories();
                        } else {
                            showMessage($('#categoryMessage'), "Category deletion failed.", 5000);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error:",jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });


     
    });

    // soft undo deletion on categories --DONE
    $('#categories-table').on('click', '.undo-btn', function() {
        var categoryRow = $(this).closest('tr');
        var categoryId = categoryRow.find('td:eq(0)').text();
        
      Swal.fire({
            title: 'Are you sure?',
            text: "This will undo the delition of the category.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes,undo delete!'
        }).then((result) => {
            if (result.isConfirmed) {
              
                $.ajax({
                    url: "../resourses/includes/soft_undo_category.php", 
                    method: "POST",
                    data: { category_id: categoryId },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            showMessage($('#categoryMessage'), "Undo delete successful.", 5000);
                            displayCategories();
                        } else {
                            showMessage($('#categoryMessage'), "Undo delete failed.", 5000);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error:", jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });


    });

    // Add new category --DONE
    $('#addCategoryBtn').on('click', function() {
        var newCategoryName = $('#newCategoryName').val();
    
        $.ajax({
            url: "../resourses/includes/add_category.php", 
            method: "POST",
            data: { category_name: newCategoryName },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $('#newCategoryName').val('');
                    showMessage($('#categoryMessage'), "Category added successfully.", 3000); 
                    displayCategories();
                } else {
                    showMessage($('#categoryMessage'), "Category addition failed.", 3000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:",jqXHR, textStatus, errorThrown);
            }
        });
    });

    // function displayAuthors() {
    //     var authorsTableBody = $('#authors-table tbody');
    //     $.ajax({
    //         url: "../resourses/includes/get_authors.php",
    //         method: "GET",
    //         dataType: "json",
    //         success: function(data) {
    //             authorsTableBody.empty(); 
    //             data.forEach(function(author) {
    //                 var row = '<tr>' +
    //                     '<td class="py-2 px-4 border border-gray-300">' + author.first_name + '</td>' +
    //                     '<td class="py-2 px-4 border border-gray-300">' + author.last_name + '</td>' +
    //                     '<td class="py-2 px-4 border border-gray-300">' + author.short_bio + '</td>' +
    //                     '<td class="py-2 px-4 border border-gray-300">';
                    
    //                 if (author.is_deleted === 1) {
    //                     row += '<button class="undo-author-btn bg-green-400 hover:bg-green-500 px-4 py-1 rounded-lg mr-2" data-author-id="' + author.author_id + '">Undo Delete</button>';
    //                 } else {
    //                     row += '<button class="delete-author-btn bg-red-400 hover:bg-red-500 text-white px-4 py-2 rounded-lg mr-2" data-author-id="' + author.author_id + '">Delete</button>';
    //                 }
    
    //                 row += '</td>' +
    //                     '</tr>';
    //                 authorsTableBody.append(row);
    //             });
    //         },
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             console.error("AJAX error:", jqXHR, textStatus, errorThrown);
    //         }
    //     });
    // }

    displayAuthors();
    function displayAuthors() {
        var authorsTableBody = $('#authors-table tbody');
        $.ajax({
            url: "../resourses/includes/get_authors.php",
            method: "GET",
            dataType: "json",
            success: function(data) {
                authorsTableBody.empty();
                data.forEach(function(author) {
                    var row = '<tr>' +
                        '<td class="py-2 px-4 border border-gray-300">' + author.first_name + '</td>' +
                        '<td class="py-2 px-4 border border-gray-300">' + author.last_name + '</td>' +
                        '<td class="py-2 px-4 border border-gray-300">' + author.short_bio + '</td>' +
                        '<td class="py-2 px-4 border border-gray-300">';
                    
                    if (author.is_deleted === 1) {
                        row += '<button class="undo-author-btn bg-green-400 hover:bg-green-500 px-4 py-1 rounded-lg mr-2" data-author-id="' + author.author_id + '">Undo Delete</button>';
                    } else {
                        row += '<button class="delete-author-btn bg-red-400 hover:bg-red-500 text-white px-4 py-2 rounded-lg mr-2" data-author-id="' + author.author_id + '">Delete</button>';
                    }
    
                    // Add an "Edit" button
                    row += '<button class="edit-author-btn bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded-lg" data-author-id="' + author.author_id + '">Edit</button>';
                    

                    row += '<input type="hidden" class="author-first-name" value="' + author.first_name + '">';
                    row += '<input type="hidden" class="author-last-name" value="' + author.last_name + '">';
                    row += '<input type="hidden" class="author-short-bio" value="' + author.short_bio + '">';
    
                    row += '</td>' +
                        '</tr>';
                    authorsTableBody.append(row);
                });
    
                $('.edit-author-btn').on('click', function () {
                    var row = $(this).closest('tr');
                    var firstName = row.find('.author-first-name').val();
                    var lastName = row.find('.author-last-name').val();
                    var shortBio = row.find('.author-short-bio').val();
                    
                    $('#new_first_name').val(firstName);
                    $('#new_last_name').val(lastName);
                    $('#new_short_bio').val(shortBio);
                    $('#editTray').removeClass('hidden');
                   
                    var authorId = $(this).data('author-id');
                    $('#editAuthor').data('author-id', authorId);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", jqXHR, textStatus, errorThrown);
            }
        });
    }
    
    $('#editAuthor').on('click', function() {
        var authorId = $(this).data('author-id');
        var newFirstName = $('#new_first_name').val();
        var newLastName = $('#new_last_name').val();
        var newShortBio = $('#new_short_bio').val();
        
        // Perform input validation here if needed
    
        var dataToSend = {
            author_id: authorId,
            new_first_name: newFirstName,
            new_last_name: newLastName,
            new_short_bio: newShortBio
        };
    
        $.ajax({
            url: '../resourses/includes/update_author.php',
            method: 'POST',
            data: dataToSend,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    displayAuthors();
                    $('#editTray').addClass('hidden');
                    Swal.fire('Success!', 'Operation completed successfully.', 'success');
                } else {
                    // Handle the case where the update failed
                    Swal.fire('Error!', 'All feilds are Mandatory and short bio needs to be 20 chars or more.', 'error');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX error:', jqXHR, textStatus, errorThrown);
                console.log('Response Text:', jqXHR.responseText);
                alert('An error occurred while updating the author.');
            }
        });
    });
    

    // soft delete ajax call for authors --DONE
    $('#authors-table').on('click', '.delete-author-btn', function() {
        var authorId = $(this).data('author-id'); 
        
        $.ajax({
            url: "../resourses/includes/soft_delete_author.php",
            method: "POST",
            data: { author_id: authorId },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    showMessage($('#authorBioError'), "Author deleted successfully.", 5000);
                    displayAuthors();
                } else {
                    showMessage($('#authorBioError'), "Author deletion failed.", 5000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", jqXHR, textStatus, errorThrown);
            }
        });
    });

    // soft undo deletion on authors --DONE
    $('#authors-table').on('click', '.undo-author-btn', function() {
        var authorId = $(this).data('author-id'); 

        $.ajax({
            url: "../resourses/includes/soft_undo_authors.php",
            method: "POST",
            data: { author_id: authorId }, 
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    showMessage($('#authorBioError'), "Author Deletion Undone.", 5000);
                    displayAuthors();
                } else {
                    showMessage($('#authorBioError'), "Author Deletion Undone failed.", 5000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", jqXHR, textStatus, errorThrown);
            }
        });
    });
    
    // Add new author --DONE
    $('#addAuthor').on('click', function() {
        var newFirstName = $('#first_name').val();
        var newLastName = $('#last_name').val();
        var newBio = $('#short_bio').val(); 
        if (newBio.length < 20) {
            showMessage($('#authorBioError'), "Short bio must be at least 20 chars long", 5000); 
            return;
        }
        $.ajax({
            url: "../resourses/includes/add_author.php",
            method: "POST",
            data: {
                first_name: newFirstName,
                last_name: newLastName,
                short_bio: newBio
            },
            dataType: "json",
            success: function(response) {
                displayAuthors();
                if (response.success) {
                    $('#first_name').val('');
                    $('#last_name').val('');
                    $('#short_bio').val('');
                    showMessage($('#authorBioError'), "Author Added !", 5000); 
                } else {
                    showMessage($('#authorBioError'), "Author already Exists", 5000); 
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", jqXHR, textStatus, errorThrown);
            }
        });
    });

    // populate dropdown list with authors --DONE
    $.ajax({
        url: "../resourses/includes/get_active_authors.php", 
        method: "GET",
        dataType: "json",
        success: function(authors) {
            var authorDropdown = $("#newAuthor");
            
            authorDropdown.empty();
            authors.forEach(function(author) {
                var fullName = author.first_name + ' ' + author.last_name;
                authorDropdown.append($('<option>').val(author.author_id).text(fullName));
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX error:", jqXHR, textStatus, errorThrown);
        }
    });

    // populate dropdown list with categories --DONE
    $.ajax({
        url: "../resourses/includes/get_categories.php",
        method: "GET",
        dataType: "json",
        success: function(categories) {
            var categoryDropdown = $("#newCategory"); 
            
            categoryDropdown.empty();
            
            categories.forEach(function(category) {
                categoryDropdown.append($('<option>').val(category.category_id).text(category.category_name));
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX error:", jqXHR, textStatus, errorThrown);
        }
    });

    // adding new book --DONE
    $("#addBookBtn").on("click", function() {
        var title = $("#newTitle").val();
        var author = $("#newAuthor").val();
        var publishedAt = $("#newPublishedAt").val();
        var noOfPages = $("#newNoOfPages").val();
        var category = $("#newCategory").val();
        var imageUrl = $("#newImageUrl").val();
    
        // Check if all mandatory fields are filled out
        if (!title || !author || !publishedAt || !noOfPages || !category || !imageUrl) {
            showMessage($('#addBookMessage'), "Please fill out all mandatory fields.", 5000);
            return;
        }
    
        // Check if the book already exists --DONE
        $.ajax({
            url: "../resourses/includes/check_book_exists.php",
            method: "POST",
            data: { title: title },
            dataType: "json",
            success: function(data) {
                if (data.bookExists) {
                    showMessage($('#addBookMessage'), "This book already exists..", 5000);
                } else {
                    $.ajax({
                        url: "../resourses/includes/add_book.php", 
                        method: "POST",
                        data: {
                            title: title,
                            author: author,
                            published_at: publishedAt,
                            no_of_pages: noOfPages,
                            category: category,
                            image_url: imageUrl
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.success) {
                                showMessage($('#addBookMessage'), response.message, 5000);
                                $("#newTitle").val("");
                                $("#newAuthor").val("");
                                $("#newPublishedAt").val("");
                                $("#newNoOfPages").val("");
                                $("#newCategory").val("");
                                $("#newImageUrl").val("");
                            } else {
                                showMessage($('#addBookMessage'), response.message, 5000);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("AJAX error:", jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", jqXHR, textStatus, errorThrown);
            }
        });
    });


    function populateEditForm(bookId) {
        $('#bookId').val(bookId);
        // Use AJAX to fetch the book information based on the bookId
        $.ajax({
            url: "../resourses/includes/get_book_info.php",
            method: "GET",
            data: { book_id: bookId },
            dataType: "json",
            success: function (data) {
                $('#newTitle1').val(data.title);
                $('#newPublishedAt1').val(data.published_at);
                $('#newNoOfPages1').val(data.no_of_pages);
                $('#newImageUrl1').val(data.image_url);
    
                // Populate the Author dropdown
                $.ajax({
                    url: "../resourses/includes/get_authors.php",
                    method: "GET",
                    dataType: "json",
                    success: function (authorsData) {
                        var authorSelect = $('#newAuthor1');
                        authorSelect.empty(); // Clear existing options
                        authorsData.forEach(function (author) {
                            authorSelect.append($('<option>', {
                                value: author.author_id,
                                text: author.first_name + ' ' + author.last_name
                            }));
                        });
                        authorSelect.val(data.author_id); // Set the selected author
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error:", jqXHR, textStatus, errorThrown);
                    }
                });
    
                // Populate the Category dropdown
                $.ajax({
                    url: "../resourses/includes/get_categories.php",
                    method: "GET",
                    dataType: "json",
                    success: function (categoriesData) {
                        var categorySelect = $('#newCategory1');
                        categorySelect.empty(); // Clear existing options
                        categoriesData.forEach(function (category) {
                            categorySelect.append($('<option>', {
                                value: category.category_id,
                                text: category.category_name
                            }));
                        });
                        categorySelect.val(data.category_id); // Set the selected category
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error:", jqXHR, textStatus, errorThrown);
                    }
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", jqXHR, textStatus, errorThrown);
            }
        });
    }
    
    function displayBooks() {
        var booksTableBody = $('#booksTable');
    
        $.ajax({
            url: "../resourses/includes/get_books.php",
            method: "GET",
            dataType: "json",
            success: function (data) {
                booksTableBody.empty();
                data.forEach(function (book) {
                    var row = $('<tr>');
                    row.append('<td class="py-2 px-4 border border-gray-300">' + book.title + '</td>');
                    row.append('<td class="py-2 px-4 border border-gray-300">' + book.author_name + '</td>');
                    row.append('<td class="py-2 px-4 border border-gray-300">' + book.published_at + '</td>');
                    row.append('<td class="py-2 px-4 border border-gray-300">' + book.no_of_pages + '</td>');
                    row.append('<td class="py-2 px-4 border border-gray-300">' + book.category_name + '</td>');
    
                    // Soft Delete button column
                    if (book.is_deleted === 1) {
                        var undoDeleteButton = $('<button>Return</button>');
                        undoDeleteButton.attr('data-book-id', book.book_id);
                        undoDeleteButton.addClass('undo-delete-book-btn bg-green-400 hover:bg-green-500 px-4 py-2 rounded-lg');
                        row.append($('<td class="py-2 px-4 border">').append(undoDeleteButton));
                    } else {
                        var deleteButton = $('<button>Remove</button>');
                        deleteButton.attr('data-book-id', book.book_id);
                        deleteButton.addClass('delete-book-btn bg-red-400 hover:bg-red-500 text-white px-4 py-2 rounded-lg');
                        row.append($('<td class="py-2 px-4 border">').append(deleteButton));
                          // Permanent Delete button column
                    var permanentDeleteButton = $('<button>Delete</button>');
                    permanentDeleteButton.attr('data-book-id', book.book_id);
                    permanentDeleteButton.addClass('permanent-delete-book-btn bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg');
                    row.append($('<td class="py-2 px-4 border">').append(permanentDeleteButton));
                        // Edit button column
                        var editButton = $('<button>Edit</button>');
                        editButton.attr('data-book-id', book.book_id);
                        editButton.addClass('edit-book-btn bg-blue-400 hover:bg-blue-500 text-white px-4 py-2 rounded-lg');
                        row.append($('<td class="py-2 px-4 border">').append(editButton));
    
                        // Edit button click handler
                        editButton.on('click', function () {
                            console.log("Edit button clicked"); 
                            var bookId = $(this).data('book-id');
                            populateEditForm(bookId);
                        });
                    }
                    
                    booksTableBody.append(row);
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", jqXHR, textStatus, errorThrown);
            }
        });
    }
    
    // Call the displayBooks function to initially populate the table
    displayBooks();
    


    // Handle soft delete for books --DONE
    $('#booksTable').on('click', '.delete-book-btn', function() {
        var bookId = $(this).data('book-id');

        Swal.fire({
            title: 'Are you sure?',
            text: "This will Remove the book from the shelves!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Remove it!'
        }).then((result) => {
            if (result.isConfirmed) {
              
                $.ajax({
                    url: "../resourses/includes/soft_delete_book.php",
                    method: "POST",
                    data: { book_id: bookId },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            showMessage($('#bookMessage'), "Book removed successfully.", 5000);
                            displayBooks();
                        } else {
                            showMessage($('#bookMessage'), "Book removal failed.", 5000);
                        }
                    },

                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error:", jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });


    });
    // Handle soft undo delete for books --DONE
    $('#booksTable').on('click', '.undo-delete-book-btn', function() {
        var bookId = $(this).data('book-id');
        // console.log(bookId);

        Swal.fire({
            title: 'Are you sure?',
            text: "This will return the book.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, return it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../resourses/includes/soft_undo_book.php",
                    method: "POST",
                    data: { book_id: bookId },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            showMessage($('#bookMessage'), "Return successful.", 5000);
                            displayBooks();
                        } else {
                            showMessage($('#bookMessage'), "Returning failed.", 5000);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error:", jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
       
    });
    
    
    // Handle permanent delete for books --DONE
    $('#booksTable').on('click', '.permanent-delete-book-btn', function() {
        var bookId = $(this).data('book-id');
        
    
        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the book and its associated comments and notes.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed the deletion
                $.ajax({
                    url: "../resourses/includes/permanent_delete_book.php",
                    method: "POST",
                    data: { book_id: bookId }, 
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            showMessage($('#bookMessage'), "Book and associated data permanently deleted successfully.", 5000);
                            displayBooks(); // Reload the table after deletion
                        } else {
                            showMessage($('#bookMessage'), "Book and associated data permanent deletion failed.", 5000);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error:", jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    });



})