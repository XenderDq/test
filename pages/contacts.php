<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';
?>
 <main class="main">
        <div class="content">
            <div class="top_chapter-decanat">
                <?php
                    include $_SERVER['DOCUMENT_ROOT'] . '/components/contactPage/decan.php';
                ?>
            </div>
            <div class="top_deputy-decanat">
                <?php
                    include $_SERVER['DOCUMENT_ROOT'] . '/components/contactPage/decansHelperComponent.php';
                ?>
            </div>
        <div class="top_employees-decanat">
            <div class="employees_main-text">
                <h3 class="employees_title">Сотрудники деканата</h3>
            </div>
            <div class="employees_slider_img-left">
                <svg width="34" height="60" viewBox="0 0 34 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.17157 27.1716C-0.390524 28.7337 -0.390524 31.2663 1.17157 32.8284L26.6274 58.2843C28.1895 59.8464 30.7222 59.8464 32.2843 58.2843C33.8464 56.7222 33.8464 54.1895 32.2843 52.6274L9.65685 30L32.2843 7.37258C33.8464 5.81049 33.8464 3.27783 32.2843 1.71573C30.7222 0.153631 28.1895 0.153631 26.6274 1.71573L1.17157 27.1716ZM5 30L5 26H4L4 30V34H5L5 30Z" fill="black"/>
                </svg>
            </div>
            <div class="slider-container">
                <?php
                    include $_SERVER['DOCUMENT_ROOT'] . '/components/contactPage/decanatEmployesComponent.php';
                ?>
            </div>
            <div class="employees_slider_img-right">
                <svg width="34" height="60" viewBox="0 0 34 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M32.8284 32.8284C34.3905 31.2663 34.3905 28.7337 32.8284 27.1716L7.37258 1.71573C5.81049 0.153631 3.27783 0.153631 1.71573 1.71573C0.153631 3.27783 0.153631 5.81049 1.71573 7.37258L24.3431 30L1.71573 52.6274C0.153631 54.1895 0.153631 56.7222 1.71573 58.2843C3.27783 59.8464 5.81049 59.8464 7.37258 58.2843L32.8284 32.8284ZM29 30V34H30V30V26H29V30Z" fill="black"/>
                </svg>
            </div>
        </div>
            <?php
                include $_SERVER['DOCUMENT_ROOT'] . '/include/feedbackFormElement.php';
            ?>
        </div>
    </main>
     <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/include/footer.php';
?>