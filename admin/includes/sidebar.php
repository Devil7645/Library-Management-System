
<ul>
      <li class="<?= ($activePage === 'dashboard') ? 'active' : '' ?>"><a href="../admin/">Dashboard</a></li>
      <!-- <li class="<?= ($activePage === 'resources') ? 'active' : '' ?>"><a href="resources.php">Resources</a></li> -->
      <li class="<?= ($activePage === 'manage-books') ? 'active' : '' ?>"><a href="manage-books.php">Manage Books</a></li>
      <li class="<?= ($activePage === 'lend') ? 'active' : '' ?>"><a href="lend_book.php">Lend Book</a></li>
      <li class="<?= ($activePage === 'lended-books') ? 'active' : '' ?>"><a href="lended.php">Lended Books</a></li>
      <li class="<?= ($activePage === 'members') ? 'active' : '' ?>"><a href="members.php">Members</a></li>
      <li class="<?= ($activePage === 'settings') ? 'active' : '' ?>"><a href="settings.php">Settings</a></li>
      <!-- <li class="<?= ($activePage === 'notifications') ? 'active' : '' ?>"><a href="notifications.php">Notifications</a></li> -->
      <li><a href="../logout.php">Logout</a></li>
    </ul>