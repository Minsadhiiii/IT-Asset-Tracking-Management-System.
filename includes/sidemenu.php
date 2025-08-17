    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <div class="sidebar">
        <div class="logo-details">
            <div class="logo_name">
                <img src="./assets/images/logo.png" alt="logo image" style="width: 150px;">
            </div>
            <i class='bx bx-menu' id="btn"></i>
        </div>

        <ul class="nav-list-vertical">
            <?php if ($_SESSION["user"]["role"] == 'Admin' || $_SESSION["user"]["role"] == 'Assistant' || $_SESSION["user"]["role"] == 'Manager'): ?>
                <li>
                    <a href="./assets.php">
                        <i class='bx bx-laptop'></i>
                        <span class="links_name"><?php echo ($_SESSION["user"]["role"] == 'Employee') ? 'View Assets' : 'Assets' ?></span>
                    </a>
                    <span class="tooltip">Assets</span>
                </li>
                <li>
                    <a href="./dashboard.php">
                        <i class='bx bx-grid-alt'></i>
                        <span class="links_name">Dashboard</span>
                    </a>
                    <span class="tooltip">Dashboard</span>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION["user"]["role"] == 'Admin' || $_SESSION["user"]["role"] == 'Assistant'): ?>
                <li>
                    <a href="./licenses.php">
                        <i class='bx bx-window-alt'></i>
                        <span class="links_name">Licenses</span>
                    </a>
                    <span class="tooltip">Licenses</span>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION["user"]["role"] == 'Admin' || $_SESSION["user"]["role"] == 'Assistant'): ?>
                <li>
                    <a href="./accessories.php">
                        <i class='bx bxs-keyboard'></i>
                        <span class="links_name">Accessories</span>
                    </a>
                    <span class="tooltip">Accessories</span>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION["user"]["role"] == 'Admin' || $_SESSION["user"]["role"] == 'Assistant'): ?>
                <li>
                    <a href="./components.php">
                        <i class="fa-solid fa-hard-drive"></i>
                        <span class="links_name">Components</span>
                    </a>
                    <span class="tooltip">Components</span>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION["user"]["role"] == 'Admin' || $_SESSION["user"]["role"] == 'Assistant'): ?>
                <li>
                    <a href="./consumables.php">
                        <i class='bx bxs-droplet'></i>
                        <span class="links_name">Consumable</span>
                    </a>
                    <span class="tooltip">Consumable</span>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION["user"]["role"] == 'Admin'): ?>
                <li>
                    <a href="./manageUsers.php">
                        <i class='bx bxs-user'></i>
                        <span class="links_name">Saved</span>
                    </a>
                    <span class="tooltip">People</span>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION["user"]["role"] == 'Admin' || $_SESSION["user"]["role"] == 'Assistant'): ?>
                <li>
                    <a href="./maintenance.php">
                        <i class="fa-solid fa-wrench"></i>
                        <span class="links_name">Maintenance</span>
                    </a>
                    <span class="tooltip">Maintenance</span>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION["user"]["role"] == 'Admin'): ?>
                <li>
                    <a href="./audit.php">
                        <i class="fa-regular fa-clipboard"></i>
                        <span class="links_name">Audit</span>
                    </a>
                    <span class="tooltip">Audit</span>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION["user"]["role"] == 'Admin'): ?>
                <li>
                    <a href="./activityLog.php">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span class="links_name">Audit Log</span>
                    </a>
                    <span class="tooltip">Audit Log</span>
                </li>
            <?php endif; ?>
            <?php if ($_SESSION["user"]["role"] == 'Manager'): ?>
                <li>
                    <a href="./activityLog.php">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span class="links_name">Audit Log</span>
                    </a>
                    <span class="tooltip">Audit Log</span>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION["user"]["role"] == 'Admin'): ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <i class="fa-solid fa-gear"></i>
                        <span class="links_name">Settings</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Manage Suppliers</a></li>
                        <li><a href="#">Manage Categories</a></li>
                        <li><a href="#">Manufacturers</a></li>
                        <li><a href="#">Offices</a></li>
                        <li><a href="#">Suppliers</a></li>
                    </ul>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION["user"]["role"] == 'Manager'): ?>
                <li>
                    <a href="./maintenance.php">
                        <i class="fa-solid fa-chart-line"></i>
                        <span class="links_name">Predict Maintenance</span>
                    </a>
                    <span class="tooltip">Predict Maintenance</span>
                </li>

                <li>
                    <a href="./warrantyExpires.php">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span class="links_name">Warranty Expires</span>
                    </a>
                    <span class="tooltip">Warranty Expires</span>
                </li>
            <?php endif; ?>

            <?php if ($_SESSION["user"]["role"] == 'Employee'): ?>
                <li>
                    <a href="./empDashboard.php">
                        <i class='bx bx-grid-alt'></i>
                        <span class="links_name">Dashboard</span>
                    </a>
                    <span class="tooltip">Dashboard</span>
                </li>

                <li>
                    <a href="./maintenance.php">
                        <i class='bx bx-laptop'></i>
                        <span class="links_name">Request Maintenance</span>
                    </a>
                    <span class="tooltip">Request Maintenance</span>
                </li>

                <li>
                    <a href="./empAssetAssignment.php">
                        <i class='bx bx-task'></i>
                        <span class="links_name">My Assignments</span>
                    </a>
                    <span class="tooltip">Assignments</span>
                </li>
            <?php endif; ?>


        </ul>
    </div>
    <section class="home-section">
        <div class="header-bar">
            <div class="logo" style="width: 400px; padding-left: 10px;">
                <h1>Asset Tracking & Management System</h1>
            </div>
            <div class="middle-section">
                <ul class="nav-list-horizontal">
                </ul>
            </div>
            <div class="settings">
                <ul class="nav-list-horizontal">
                    <li>
                        <a href="account.php">
                            <span style="min-width: 90px; color: #130856; font-weight: bold;" class="links_name"><?php echo $_SESSION["user"]["fname"] . " " . $_SESSION["user"]["lname"] ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                        <span class="tooltip">Logout</span>
                    </li>
                </ul>
            </div>
        </div>
        <script src="./assets/js/hamburger.js"></script>
        <script>
            let sidebar = document.querySelector(".sidebar");
            let closeBtn = document.querySelector("#btn");
            closeBtn.addEventListener("click", () => {
                sidebar.classList.toggle("open");
                menuBtnChange(); //calling the function(optional)
            });
            // following are the code to change sidebar button(optional)
            function menuBtnChange() {
                if (sidebar.classList.contains("open")) {
                    closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); //replacing the iocns class
                } else {
                    closeBtn.classList.replace("bx-menu-alt-right", "bx-menu"); //replacing the iocns class
                }
            }
        </script>
        <script>
            document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    const parent = this.closest('.dropdown');
                    parent.classList.toggle('open');
                });
            });
        </script>

        </body>

        </html>