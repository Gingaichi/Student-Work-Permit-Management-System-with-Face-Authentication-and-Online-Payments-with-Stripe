document.addEventListener("DOMContentLoaded", function () {
    const steps = Array.from(document.querySelectorAll('form .step'));
    const nextBtns = document.querySelectorAll('form .next-btn');
    const prevBtns = document.querySelectorAll('form .prev-btn'); 
    const form = document.querySelector('form');

    nextBtns.forEach(button => {
        button.addEventListener('click', () => {
            changeStep('next');
        });
    });

    prevBtns.forEach(button => {
        button.addEventListener('click', () => {
            changeStep('prev');
        });
    });

    function changeStep(btn) {
        let index = 0;
        const active = document.querySelector('form .step.active');
        index = steps.indexOf(active);
        steps[index].classList.remove('active');

        if (btn === 'next') {
            index++;
        } else if (btn === 'prev') {
            index--;
        }

        if (index >= 0 && index < steps.length) {
            steps[index].classList.add('active');
        }
    }
});
