<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';
?>
     <main class="main">
        <div class="content">
            <div class="filter-container">
                <?php
                    include $_SERVER['DOCUMENT_ROOT'] . '/components/teachersPage/teachersPageTabs.php';
                ?>
                <div class="filter-content">
                <?php
                    include $_SERVER['DOCUMENT_ROOT'] . '/components/teachersPage/teachersComponent.php';
                ?>
                </div>
            </div>
        </div>
    </main>
<?php
   include $_SERVER['DOCUMENT_ROOT'] . '/include/footer.php';
?>