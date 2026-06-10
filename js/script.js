// Ждем полной загрузки DOM-дерева
document.addEventListener('DOMContentLoaded', () => {
    // Находим все необходимые элементы на странице
    const slides = document.querySelectorAll('.slide');
    const prevBtn = document.querySelector('.slider-btn.prev');
    const nextBtn = document.querySelector('.slider-btn.next');
    
    let currentSlideIndex = 0; // Начинаем с самого первого слайда (индекс 0)

    // Функция, которая прячет старый слайд и показывает новый
    function showSlide(index) {
        // 1. Удаляем класс active у текущего активного слайда
        slides[currentSlideIndex].classList.remove('active');
        
        // 2. Обновляем индекс текущего слайда
        currentSlideIndex = index;
        
        // 3. Добавляем класс active новому слайду
        slides[currentSlideIndex].classList.add('active');
    }

    // Обработчик клика на кнопку "Вперед"
    nextBtn.addEventListener('click', () => {
        let nextIndex = currentSlideIndex + 1;
        
        // Если дошли до конца — перелистываем на самый первый слайд
        if (nextIndex >= slides.length) {
            nextIndex = 0;
        }
        
        showSlide(nextIndex);
    });

    // Обработчик клика на кнопку "Назад"
    prevBtn.addEventListener('click', () => {
        let prevIndex = currentSlideIndex - 1;
        
        // Если ушли в минус — перелистываем на самый последний слайд
        if (prevIndex < 0) {
            prevIndex = slides.length - 1;
        }
        
        showSlide(prevIndex);
    });

    // ОПЦИОНАЛЬНО: Автоматическое перелистывание каждые 5 секунд
    setInterval(() => {
        nextBtn.click(); // Имитируем клик по кнопке "вперед"
    }, 10000);



    const form = document.querySelector('.brutal-form');

    if (form) {
        form.addEventListener('submit', async (event) => {
            event.preventDefault(); // Намертво блокируем перезагрузку страницы браузером

            // Автоматически собираем все данные из инпутов (name="name", name="email", name="phone")
            const formData = new FormData(form);

            try {
                // Отправляем данные "вдогонку" в будущий PHP файл
                const response = await fetch('handlers/send.php', {
                    method: 'POST',
                    body: formData
                });

                // Ждем ответ от сервера
                const result = await response.text();

                if (response.ok) {
                    alert('Заявка успешно отправлена! Ответ сервера: ' + result);
                    form.reset(); // Очищаем поля формы после успешной отправки
                } else {
                    alert('Ошибка сервера. Попробуйте позже.');
                }
            } catch (error) {
                console.error('Ошибка отправки:', error);
                alert('Не удалось связаться с сервером.');
            }
        });
    }
});
