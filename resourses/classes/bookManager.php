<?php



class BookManager extends Dbh
{
    public function getCategoriesWithBooks() {
        $conn = $this->connect(); 
        
        $categories = array();
        $categoryQuery = "SELECT * FROM category WHERE is_deleted = 0";
        $categoryResult = $conn->query($categoryQuery);

        while ($categoryRow = $categoryResult->fetch(PDO::FETCH_ASSOC)) {
            $category = array(
                "category_id" => $categoryRow["category_id"],
                "category_name" => $categoryRow["category_name"],
                "books" => $this->getBooksForCategory($conn, $categoryRow["category_id"])
            );

            $categories[] = $category;
        }

        return $categories;
    }

    // search options for category
    public function getBooksForSelectedCategories($selectedCategories) {
        $conn = $this->connect();
        
        $selectedCategoriesString = implode(",", $selectedCategories);
        $books = array();
        
        $booksQuery = "SELECT books.*, authors.first_name, authors.last_name, category.category_name
                        FROM books
                        JOIN authors ON books.author_id = authors.author_id
                        JOIN category on books.category_id = category.category_id
                        WHERE books.category_id IN ($selectedCategoriesString) AND books.is_deleted = 0";
                        
        $booksResult = $conn->query($booksQuery);

        while ($bookRow = $booksResult->fetch(PDO::FETCH_ASSOC)) {
            $book = array(
                "book_id" => $bookRow["book_id"],
                "category_name" => $bookRow["category_name"],
                "category_id" => $bookRow["category_id"],
                "title" => $bookRow["title"],
                "image_url" => $bookRow["image_url"],
                "author_name" => $bookRow["first_name"] . ' ' . $bookRow["last_name"]
            );
            $books[] = $book;
        }

        return $books;
    }

    // get all books (not deleted)
    public function getAllBooks($conn) {
        $books = array();
        $booksQuery = "SELECT * FROM books WHERE is_deleted = 0";
        $booksResult = $conn->query($booksQuery);

        while ($bookRow = $booksResult->fetch(PDO::FETCH_ASSOC)) {
            $book = array(
                "book_id" => $bookRow["book_id"],
                "title" => $bookRow["title"]
            );
            $books[] = $book;
        }

        return $books;
    }

    // search for books or authors
    public function searchBooksAndAuthors($searchValue) {
        $conn = $this->connect();
        $searchValue = "%$searchValue%"; // Add wildcards to searchValue
    
        $query = "SELECT books.title, books.book_id, authors.first_name, authors.last_name, books.image_url, CONCAT(authors.first_name, ' ', authors.last_name) AS author_name
                FROM books
                LEFT JOIN authors ON books.author_id = authors.author_id
                WHERE books.is_deleted = 0 AND books.title LIKE :searchValue
                OR CONCAT(authors.first_name, ' ', authors.last_name) LIKE :searchValue";
    
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':searchValue', $searchValue, PDO::PARAM_STR);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getBooksForCategory($conn, $category_id) {
        $books = array();
        $booksQuery = "SELECT books.*, authors.first_name, authors.last_name
                        FROM books
                        JOIN authors ON books.author_id = authors.author_id
                        WHERE books.category_id = $category_id AND books.is_deleted = 0";
        $booksResult = $conn->query($booksQuery);

        while ($bookRow = $booksResult->fetch(PDO::FETCH_ASSOC)) {
            $book = array(
                "book_id" => $bookRow["book_id"],
                "title" => $bookRow["title"],
                "image_url" => $bookRow["image_url"],
                "author_name" => $bookRow["first_name"] . ' ' . $bookRow["last_name"]
            );
            $books[] = $book;
        }

        return $books;
    }


    public function getAllUsers() {
        $conn = $this->connect();
        
        $users = array();
        $userQuery = "SELECT * FROM users";
        $userResult = $conn->query($userQuery);

        while ($userRow = $userResult->fetch(PDO::FETCH_ASSOC)) {
            $user = array(
                "user_id" => $userRow["user_id"],
                "user_uid" => $userRow["user_uid"],
                "user_pwd" => $userRow["user_pwd"],
                "user_email" => $userRow["user_email"],
                "is_admin" => $userRow["is_admin"]
            );
            $users[] = $user;
        }

        return $users;
    }

    public function deleteUser($userId) {
        $conn = $this->connect();
    
        // Prepare and execute the SQL query to delete the user
        $deleteQuery = "DELETE FROM users WHERE user_id = :userId";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    
        // Execute the query
        if ($stmt->execute()) {
            return true; // User deleted successfully
        } else {
            return false; // Failed to delete user
        }
    }
}


// $bookManager = new BookManager();
// $categories = $bookManager->getCategoriesWithBooks();