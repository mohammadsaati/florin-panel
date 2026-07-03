function initCardForms() {
    document.querySelectorAll('[data-card-form]').forEach(form => {
        if (form.dataset.cardFormInited) return;
        form.dataset.cardFormInited = '1';
        form.addEventListener('submit', onCardFormSubmit);
    });
}

function onCardFormSubmit(event) {
    const form   = event.currentTarget;
    const btn    = form.querySelector('[data-card-form-submit]');
    const spinner = form.querySelector('[data-card-form-spinner]');

    if (!btn) return;

    btn.disabled = true;
    btn.classList.add('opacity-75', 'pointer-events-none');

    if (spinner) {
        spinner.classList.remove('hidden');
    }
}

document.addEventListener('DOMContentLoaded', initCardForms);
document.addEventListener('livewire:navigated', initCardForms);
