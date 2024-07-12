<aside id="sidebar" class="expand">
    <div class="d-flex">
        <button class="toggle-btn" type="button">
            <i class="lni lni-chef-hat"></i>
        </button>
        <div class="sidebar-logo">
            <a href="index.php">Menu Master</a>
        </div>

    </div>

    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="index.php" class="sidebar-link">
                <i class="lni lni-grid-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="menu.php" class="sidebar-link">
                <i class="lni lni-service"></i>
                <span>Dishes</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="ingredients.php" class="sidebar-link">
                <i class="lni lni-spinner"></i>
                <span>Ingredients</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="calendar.php" class="sidebar-link">
                <i class="lni lni-calendar"></i>
                <span>Planner</span>
            </a>
            <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed" data-bs-toggle="collapse" data-bs-target="#multi-two" aria-expanded="false" aria-controls="multi-two">
                        None
                    </a>
                    <ul id="multi-two" class="sidebar-dropdown list-unstyled collapse">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Link 1</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Link 2</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class="lni lni-users"></i>
                <span>Role</span>
            </a>
        </li>
        <li class="sidebar-item">
        </li>
    </ul>
    <div class="sidebar-footer">
        <a href="login.php" class="sidebar-link">
            <i class="lni lni-exit"></i>
            <span>Logout</span>
        </a>
    </div>
</aside>