<div class="top_feedback_form">
    <div class="top_feedback_form-text">
        <h1 class="feedback_form-title">Форма обратной связи</h1>
        <p class="feedback_form-subtitle">Напишите нам для получения дополнительной информации</p>
    </div>
    <div class="top_feedback_form_content">
        <div class="top_feedback_form_input">   
            <div class="feedback_group_about-item">
                <input type="text" id="name" name="name" required placeholder="Ваше ФИО">
            </div>  
            <div class="feedback_group_about-item">
                <input type="tel" id="tel" name="tel" required placeholder="+7 (___) ___-__-__" data-parsley-phone-required>
            </div>
            <div class="feedback_group_about-item">
                <input type="email" id="email" name="email" required placeholder="E-mail">
            </div>
        </div>
        <div class="feedback_tell_send">
            <div class="feedback_tellus-text">
                <div class="feedback_tellus_text-item">
                    <textarea
                        id="tellus"
                        name="tellus"
                        required
                        placeholder="Напишите нам"
                    ></textarea>
                </div>
            </div>
            <div class="feedback-but">
                <button class="feedback-button">Отправить</button>
            </div>
        </div>           
        <div class="feedback_subtitle">
            <p class="feedback_subtitle-text">
            Мы всегда рады ответить на ваши вопросы и помочь вам c любой информацией, связанной c нашим университетом. Заполните форму, и мы c вами свяжемся.
            </p>
        </div>
    </div>       
</div>
<div id="feedback_toast" class="hidden"></div>
</div>