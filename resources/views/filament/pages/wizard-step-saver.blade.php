<script>
document.addEventListener("livewire:navigated", () => {
    const wizard = document.querySelector('[data-wizard]');
    if (!wizard) return;

    // Simpan step wizard saat berubah
    const observer = new MutationObserver(() => {
        const activeStep = wizard.querySelector('[data-step][data-active]');
        if (activeStep) {
            localStorage.setItem('wizard_step_order_create', activeStep.dataset.step);
        }
    });

    observer.observe(wizard, { attributes: true, subtree: true });

    // Restore step wizard
    const savedStep = localStorage.getItem('wizard_step_order_create');
    if (savedStep) {
        const targetBtn = wizard.querySelector(`[data-step-button="${savedStep}"]`);
        if (targetBtn) targetBtn.click();
    }
});
</script>
