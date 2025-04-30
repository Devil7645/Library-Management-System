<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="admin/assets/css/admin.css"> <!-- for side bar -->
    <link rel="stylesheet" href="assets/css/user.css">
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
            <div class="welcome">Welcome John Peter</div>
            <div class="library-info">Library Operating Hours: Monday to Saturday 9 AM to 7 PM, Sunday: Closed</div>
        </div>

        <div class="widgets-container">
            <div class="widget-card">
                <div class="widget-icon">03</div>
                <h3 class="widget-title">Lended Books</h3>
                <div class="widget-value">03</div>
                <p class="widget-description">Total books currently borrowed</p>
            </div>
            <div class="widget-card">
                <div class="widget-icon overdue">02</div>
                <h3 class="widget-title">Books overdue for return</h3>
                <div class="widget-value">01</div>
                <p class="widget-description">Total books currently borrowed</p>
            </div>
            <div class="widget-card">
                <div class="widget-icon reserved">02</div>
                <h3 class="widget-title">Reserved Books</h3>
                <div class="widget-value">02</div>
                <p class="widget-description">Books reserved but not yet issued</p>
            </div>
        </div>

        <div class="charts-row">
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Fines</h3>
                    <div class="chart-filter">2024</div>
                </div>
                <div class="chart-body fines-chart-body">
                    <div class="pie-chart-wrapper">
                        <div class="pie-chart-inner">100%</div>
                    </div>
                    <div class="fines-legend">
                        <div class="legend-item">
                            <div class="legend-color pending"></div>
                            ₹ 7.00 (70%) Overdue Fines
                        </div>
                        <div class="legend-item">
                            <div class="legend-color paid"></div>
                            ₹ 3.00 (30%) Lost/Damaged Book Fines
                        </div>
                    </div>
                </div>
            </div>
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Lending Activity</h3>
                    <div class="chart-filter">2024</div>
                </div>
                <div class="chart-body">
                    Placeholder for Lending Activity Chart
                </div>
            </div>
        </div>

        <div class="new-arrivals-section">
            <div class="arrivals-header">
                <h3 class="arrivals-title">New Arrivals</h3>
                <div class="arrivals-navigation">
                    <button>&lt;</button>
                    <button>&gt;</button>
                </div>
            </div>
            <div class="arrivals-list">
                <div class="book-item">
                    <img src="https://via.placeholder.com/100x120/4CAF50/FFFFFF?Text=Cover" alt="Chotrigal" class="book-cover">
                    <h4 class="book-title">Chotrigal - 2 Volumes - Tamil</h4>
                    <p class="book-author">by K. A. Nilakanta Sastri</p>
                    <button class="view-book-btn">View Book</button>
                </div>
                <div class="book-item">
                    <img src="https://via.placeholder.com/100x120/F44336/FFFFFF?Text=Cover" alt="Ponniyin Selvan" class="book-cover">
                    <h4 class="book-title">Ponniyin Selvan - 5 Volumes Set</h4>
                    <p class="book-author">Amarar Kalki</p>
                    <button class="view-book-btn">View Book</button>
                </div>
                <div class="book-item">
                    <img src="https://via.placeholder.com/100x120/FF9800/FFFFFF?Text=Cover" alt="Kandar Shashti Kavacham" class="book-cover">
                    <h4 class="book-title">Kandar Shashti Kavacham</h4>
                    <p class="book-author">Muruga Stotra Book</p>
                    <button class="view-book-btn">View Book</button>
                </div>
                <div class="book-item">
                    <img src="https://via.placeholder.com/100x120/2196F3/FFFFFF?Text=Cover" alt="Tirukkural Moolam" class="book-cover">
                    <h4 class="book-title">Tirukkural Moolam - Tamil</h4>
                    <p class="book-author">Educational Books</p>
                    <button class="view-book-btn">View Book</button>
                </div>
            </div>
        </div>
    </div>
  </div>
    
</div>
<?php include 'includes/footer.php'; ?> 
</body>
</html>