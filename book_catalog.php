<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="admin/assets/css/admin.css"> <!-- for side bar -->
    <style>

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .welcome {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .library-info {
            background-color: #fff3e0;
            color: #e65100;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 14px;
        }

        .book-catalog {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .book-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Add this */
        }

        .book-cover {
            width: 100%;
            height: 200px;
            object-fit: cover;
            margin-bottom: 10px;
            border-radius: 3px;
            background-color: #eee;
        }

        .book-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .book-author {
            font-size: 14px;
            color: #777;
            margin-bottom: 10px;
        }

        .book-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-top: 10px; /* Add this */
        }


        .view-book-btn,
        .borrow-book-btn {
            background-color: #1976d2;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }

        .borrow-book-btn {
            background-color: #4caf50;
        }

        .view-book-btn:hover,
        .borrow-book-btn:hover {
            opacity: 0.9;
        }

       /* Responsive Design */
        @media (max-width: 1024px) {
            .book-catalog {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .book-catalog {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }
            .header {
                flex-direction: column;
                text-align: center;
            }
            .library-info{
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="body">

  <div class="sidebar">
    <?php include 'includes/sidebar.php'; ?>
  </div>

  <div class="main"> 

    <div class="dashboard-container">
        <div class="header">
            <div class="welcome">Welcome to the Library</div>
            <div class="library-info">Explore our collection of books.</div>
        </div>

        <div class="book-catalog">
            <div class="book-card">
                <img src="https://via.placeholder.com/150x200/4CAF50/FFFFFF?Text=Book+1" alt="Book 1" class="book-cover">
                <h2 class="book-title">Chhatrapati - 2 Volume Set</h2>
                <p class="book-author">by K. N. Sardesai</p>
                 <div class="book-actions">
                    <button class="view-book-btn">View</button>
                    <button class="borrow-book-btn">Borrow</button>
                 </div>
            </div>
            <div class="book-card">
                <img src="https://via.placeholder.com/150x200/F44336/FFFFFF?Text=Book+2" alt="Book 2" class="book-cover">
                <h2 class="book-title">Samvidhan - Ek Sankalpana</h2>
                <p class="book-author">by ---</p>
                <div class="book-actions">
                    <button class="view-book-btn">View</button>
                    <button class="borrow-book-btn">Borrow</button>
                 </div>
            </div>
            <div class="book-card">
                <img src="https://via.placeholder.com/150x200/FF9800/FFFFFF?Text=Book+3" alt="Book 3" class="book-cover">
                <h2 class="book-title">Anandmathi - Godantar</h2>
                <p class="book-author">by ---</p>
                <div class="book-actions">
                    <button class="view-book-btn">View</button>
                    <button class="borrow-book-btn">Borrow</button>
                 </div>
            </div>
            <div class="book-card">
                <img src="https://via.placeholder.com/150x200/2196F3/FFFFFF?Text=Book+4" alt="Book 4" class="book-cover">
                <h2 class="book-title">Tukaram Maharaj - Vangmay</h2>
                <p class="book-author">by ---</p>
                <div class="book-actions">
                    <button class="view-book-btn">View</button>
                    <button class="borrow-book-btn">Borrow</button>
                 </div>
            </div>
            <div class="book-card">
                <img src="https://via.placeholder.com/150x200/8BC34A/FFFFFF?Text=Book+5" alt="Book 5" class="book-cover">
                <h2 class="book-title">The Great Indian Novel</h2>
                <p class="book-author">by Shashi Tharoor</p>
                 <div class="book-actions">
                    <button class="view-book-btn">View</button>
                    <button class="borrow-book-btn">Borrow</button>
                 </div>
            </div>
            <div class="book-card">
                <img src="https://via.placeholder.com/150x200/9C27B0/FFFFFF?Text=Book+6" alt="Book 6" class="book-cover">
                <h2 class="book-title">A Suitable Boy</h2>
                <p class="book-author">by Vikram Seth</p>
                 <div class="book-actions">
                    <button class="view-book-btn">View</button>
                    <button class="borrow-book-btn">Borrow</button>
                 </div>
            </div>
        </div>
    </div>

  </div>
    
</div>
<?php include 'includes/footer.php'; ?> 
</body>
</html>