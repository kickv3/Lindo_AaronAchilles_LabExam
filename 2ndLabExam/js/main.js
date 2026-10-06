const toast = document.querySelector('.toast');
if (toast) {
    setTimeout(() => toast.classList.add('hide'), 5000);
}

const pfpInput = document.getElementById('pfp');
const pfpPreview = document.getElementById('pfp-preview');
if (pfpInput && pfpPreview) {
    pfpInput.addEventListener('change', () => {
        const file = pfpInput.files[0];
        if (file) {
            pfpPreview.src = URL.createObjectURL(file);
        }
    });
}

const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirm_password');
const matchHint = document.getElementById('match-hint');
if (password && confirmPassword && matchHint) {
    const checkMatch = () => {
        if (confirmPassword.value === '') {
            matchHint.textContent = '';
            return;
        }
        const same = password.value === confirmPassword.value;
        matchHint.textContent = same ? 'Passwords match.' : 'Passwords do not match yet.';
        matchHint.className = 'field-hint ' + (same ? 'ok' : 'bad');
    };
    password.addEventListener('input', checkMatch);
    confirmPassword.addEventListener('input', checkMatch);
}
