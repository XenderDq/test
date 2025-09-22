<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';
?>
 <main class="main">
    
        <div class="aplicant_and_admission-tabs">
            <button class="aplicant_and_admission-tab" data-tab="aplicant-item">О поступлении</button>
            <button class="aplicant_and_admission-tab" data-tab="admission-item">Направления</button>
        </div>

        <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/components/aplicantsPage/aplicantsDirectionsPart.php';
        ?>

        <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/components/aplicantsPage/aplicantsAdmissionPart.php';
        ?>

        <?php
            include $_SERVER['DOCUMENT_ROOT'] . '/include/feedbackFormElement.php';
        ?>

    </main>
<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/include/footer.php';
?>