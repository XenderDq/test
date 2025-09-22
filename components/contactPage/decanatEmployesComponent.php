<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/db.php';

try {
    $stmt = $pdo->prepare("SELECT full_name, post_code, post, phone_number, email, image_path FROM contacts WHERE post_code = 'employer'");
    $stmt->execute();
    $contactsA = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $full_name = htmlspecialchars($row['full_name'], ENT_QUOTES, 'UTF-8');
        $post_code = htmlspecialchars($row['post_code'], ENT_QUOTES, 'UTF-8');
        $post = htmlspecialchars($row['post'], ENT_QUOTES, 'UTF-8');
        $phone_number = htmlspecialchars($row['phone_number'], ENT_QUOTES, 'UTF-8');
        $email = htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8');
        $image_path = htmlspecialchars($row['image_path'], ENT_QUOTES, 'UTF-8');

        $contactsData = [
            'full_name' => $full_name,
            'post_code' => $post_code,
            'post' => $post,
            'phone_number' => $phone_number,
            'email' => $email,
            'image_path' => $image_path,
        ];

        $contactsA[] = $contactsData;
    }
} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    echo "Произошла ошибка при работе с базой данных. Пожалуйста, попробуйте позже.";
    exit;
}
?>

<div class="employees_content_info">
                    <div class="top_employees_content">
                        <?php foreach ($contactsA as $contact): ?>
                            <div class="employees_content_item">
                            <div class="employees_content_item-img">
                                <img src=<?= $contact['image_path'] ?> alt="" class="employees_content-img">
                            </div>
                            <div class="employees_content_item-text">
                                <p class="employees_content-text"><?= $contact['full_name'] ?></p>
                            </div>
                            <div class="top_chapter__contact-phone">
                            <div class="top_chapter__contact_phone-img">
                                <svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g filter="url(#filter0_i_137_91)">
                                    <path d="M14.0074 5.20487C14.9894 5.40519 15.8918 5.90735 16.5993 6.64707C17.3067 7.38679 17.787 8.33042 17.9786 9.35718L14.0074 5.20487ZM14.0074 1C16.0476 1.23698 17.95 2.19226 19.4024 3.70899C20.8548 5.22573 21.7708 7.21376 22 9.34667L14.0074 1ZM20.9946 17.7354V20.889C20.9958 21.1818 20.9384 21.4716 20.8263 21.7398C20.7141 22.0081 20.5496 22.2489 20.3433 22.4468C20.1369 22.6447 19.8933 22.7954 19.6281 22.8892C19.3629 22.983 19.0818 23.0178 18.803 22.9915C15.7093 22.64 12.7377 21.5346 10.1267 19.7642C7.69763 18.1503 5.63816 15.9968 4.0946 13.4569C2.39553 10.7145 1.33816 7.59218 1.00816 4.34287C0.983037 4.05217 1.01608 3.75919 1.10518 3.48258C1.19428 3.20597 1.33749 2.95178 1.52568 2.73621C1.71388 2.52064 1.94295 2.34841 2.19829 2.23047C2.45364 2.11254 2.72967 2.05149 3.00882 2.05122H6.02489C6.51279 2.0462 6.9858 2.22685 7.35574 2.55952C7.72568 2.89218 7.96731 3.35415 8.0356 3.85931C8.1629 4.86855 8.39899 5.85949 8.73935 6.81323C8.87462 7.18949 8.90389 7.5984 8.82371 7.99152C8.74352 8.38464 8.55724 8.74549 8.28694 9.0313L7.01014 10.3663C8.44132 12.9981 10.5253 15.1772 13.0423 16.6736L14.3191 15.3386C14.5924 15.056 14.9375 14.8612 15.3135 14.7774C15.6895 14.6935 16.0805 14.7241 16.4404 14.8656C17.3525 15.2214 18.3002 15.4683 19.2654 15.6014C19.7538 15.6734 20.1998 15.9307 20.5186 16.3241C20.8375 16.7176 21.0069 17.2198 20.9946 17.7354Z" fill="#90C959"/>
                                    </g>
                                    <path d="M14.0074 5.20487C14.9894 5.40519 15.8918 5.90735 16.5993 6.64707C17.3067 7.38679 17.787 8.33042 17.9786 9.35718L14.0074 5.20487ZM14.0074 1C16.0476 1.23698 17.95 2.19226 19.4024 3.70899C20.8548 5.22573 21.7708 7.21376 22 9.34667L14.0074 1ZM20.9946 17.7354V20.889C20.9958 21.1818 20.9384 21.4716 20.8263 21.7398C20.7141 22.0081 20.5496 22.2489 20.3433 22.4468C20.1369 22.6447 19.8933 22.7954 19.6281 22.8892C19.3629 22.983 19.0818 23.0178 18.803 22.9915C15.7093 22.64 12.7377 21.5346 10.1267 19.7642C7.69763 18.1503 5.63816 15.9968 4.0946 13.4569C2.39553 10.7145 1.33816 7.59218 1.00816 4.34287C0.983037 4.05217 1.01608 3.75919 1.10518 3.48258C1.19428 3.20597 1.33749 2.95178 1.52568 2.73621C1.71388 2.52064 1.94295 2.34841 2.19829 2.23047C2.45364 2.11254 2.72967 2.05149 3.00882 2.05122H6.02489C6.51279 2.0462 6.9858 2.22685 7.35574 2.55952C7.72568 2.89218 7.96731 3.35415 8.0356 3.85931C8.1629 4.86855 8.39899 5.85949 8.73935 6.81323C8.87462 7.18949 8.90389 7.5984 8.82371 7.99152C8.74352 8.38464 8.55724 8.74549 8.28694 9.0313L7.01014 10.3663C8.44132 12.9981 10.5253 15.1772 13.0423 16.6736L14.3191 15.3386C14.5924 15.056 14.9375 14.8612 15.3135 14.7774C15.6895 14.6935 16.0805 14.7241 16.4404 14.8656C17.3525 15.2214 18.3002 15.4683 19.2654 15.6014C19.7538 15.6734 20.1998 15.9307 20.5186 16.3241C20.8375 16.7176 21.0069 17.2198 20.9946 17.7354Z" stroke="#90C959" stroke-linecap="round" stroke-linejoin="round"/>
                                    <defs>
                                    <filter id="filter0_i_137_91" x="0.5" y="0.499969" width="22" height="27" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                                    <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                                    <feOffset dy="4"/>
                                    <feGaussianBlur stdDeviation="2"/>
                                    <feComposite in2="hardAlpha" operator="arithmetic" k2="-1" k3="1"/>
                                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                                    <feBlend mode="normal" in2="shape" result="effect1_innerShadow_137_91"/>
                                    </filter>
                                    </defs>
                                    </svg>
                            </div>
                            <div class="top_chapter__contact-text">
                                <a class="top_chapter__contact_phone-link" href="#"><?= $contact['phone_number'] ?></a>
                            </div>
                            </div>  
                            <div class="top_chapter__contact-mail">
                                <div class="top_chapter__contact_mail-img">
                                     <svg width="27" height="28" viewBox="0 0 27 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M23.5 0.5C24.3759 0.5 25.1367 0.966431 25.6621 1.64941C26.1875 2.33246 26.5 3.25457 26.5 4.25V23.75C26.5 24.7454 26.1875 25.6675 25.6621 26.3506C25.1367 27.0336 24.3759 27.5 23.5 27.5H3.5C2.62406 27.5 1.86333 27.0336 1.33789 26.3506C0.812474 25.6675 0.5 24.7454 0.5 23.75V4.25C0.5 3.25457 0.812474 2.33246 1.33789 1.64941C1.86333 0.966431 2.62406 0.5 3.5 0.5H23.5ZM13.4004 17.6865C13.305 17.8141 13.1544 17.8883 12.9951 17.8867C12.8356 17.885 12.6856 17.8075 12.5928 17.6777L1.86816 2.67578C1.63946 3.11817 1.5 3.65926 1.5 4.25V23.75C1.5 24.542 1.75005 25.2452 2.13086 25.7402C2.51166 26.2353 3.00101 26.5 3.5 26.5H23.5C23.999 26.5 24.4883 26.2353 24.8691 25.7402C25.2499 25.2452 25.5 24.542 25.5 23.75V4.25C25.5 3.47952 25.2619 2.79429 24.8984 2.30176L13.4004 17.6865ZM3.5 1.5C3.1572 1.5 2.82019 1.62651 2.51855 1.86523L13.0088 16.5391L24.0996 1.7002C24.1125 1.68296 24.128 1.6684 24.1426 1.65332C23.9354 1.55397 23.7193 1.5 23.5 1.5H3.5Z" fill="#90C959"/>
                                    </svg>
                                </div>
                                <div class="top_chapter__contact-text">
                                    <a class="top_chapter__contact_mail-link" href="#"><?= $contact['email'] ?></a>
                                </div>
                            </div>  
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>