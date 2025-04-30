# Library-Management-System

library-management/
│
├── index.php               ← Home page (served by PHP)
├── login.php               ← Login/Signup form page
├── dashboard.php           ← After login (admin/user dashboard)
├── logout.php              ← Logs the user out (destroys session)
│
├── includes/               ← Reusable PHP parts (header, footer, DB)
│   ├── db.php              ← Database connection
│   ├── header.php          ← Common header HTML
│   ├── footer.php          ← Common footer HTML
│   └── auth.php            ← Session/auth check logic
│
├── assets/
│   ├── css/
│   │   └── style.css       ← All your styles (home, forms, etc.)
│   │
│   ├── js/
│   │   ├── home.js         ← Hamburger menu, dark mode, etc.
│   │   └── login.js        ← Login/Signup toggle logic
│   │
│   └── images/             ← Your images/logo/icons
│
├── actions/                ← Handles PHP form submissions
│   ├── login_action.php    ← Login logic (DB + session)
│   └── signup_action.php   ← Signup logic (insert into DB)
│
└── README.md               ← (Optional) Project overview