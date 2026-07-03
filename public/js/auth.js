document.addEventListener('DOMContentLoaded', () => {
    // 1. Existing Carousel Handling
    const carousel = document.querySelector('#authCarousel');
    if (carousel && window.bootstrap) {
        bootstrap.Carousel.getOrCreateInstance(carousel, {
            interval: 4500,
            ride: 'carousel',
            pause: false,
            touch: true,
            wrap: true,
        });
    }

    // 2. Register Form Validation UX
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        const fields = {
            name: {
                el: document.getElementById('name'),
                errEl: document.getElementById('name-error'),
                validate: (val) => {
                    if (!val.trim()) return 'Full name is required.';
                    if (!/^[a-zA-Z\s]+$/.test(val)) return 'Name can only contain letters and spaces.';
                    if (val.trim().length < 2) return 'Name must be at least 2 characters.';
                    if (val.length > 100) return 'Name cannot exceed 100 characters.';
                    return '';
                }
            },
            email: {
                el: document.getElementById('email'),
                errEl: document.getElementById('email-error'),
                validate: (val) => {
                    const trimmed = val.trim();
                    if (!trimmed) return 'Email address is required.';
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(trimmed)) return 'Please enter a valid email address.';
                    
                    const domain = trimmed.split('@')[1]?.toLowerCase();
                    const disposableDomains = [
                        'mailinator.com', 'yopmail.com', 'tempmail.com', 'guerrillamail.com',
                        '10minutemail.com', 'throwawaymail.com', 'dispostable.com',
                        'getairmail.com', 'maildrop.cc', 'sharklasers.com',
                        'guerrillamailblock.com', 'guerrillamail.net', 'guerrillamail.org',
                        'guerrillamail.biz', 'guerrillamail.de'
                    ];
                    if (disposableDomains.includes(domain)) {
                        return 'Disposable email addresses are not allowed.';
                    }
                    return '';
                }
            },
            password: {
                el: document.getElementById('password'),
                errEl: document.getElementById('password-error'),
                validate: (val) => {
                    if (!val) return 'Password is required.';
                    if (val.length < 8) return 'Password must be at least 8 characters.';
                    if (val.length > 64) return 'Password cannot exceed 64 characters.';
                    
                    const hasUpper = /[A-Z]/.test(val);
                    const hasLower = /[a-z]/.test(val);
                    const hasNumber = /[0-9]/.test(val);
                    const hasSpecial = /[^a-zA-Z0-9]/.test(val);
                    if (!hasUpper || !hasLower || !hasNumber || !hasSpecial) {
                        return 'Password must contain uppercase, lowercase, number and special character.';
                    }
                    return '';
                }
            },
            password_confirmation: {
                el: document.getElementById('password_confirmation'),
                errEl: document.getElementById('password_confirmation-error'),
                validate: (val) => {
                    if (!val) return 'Please confirm your password.';
                    const passwordVal = document.getElementById('password').value;
                    if (val !== passwordVal) {
                        return 'Password confirmation does not match.';
                    }
                    return '';
                }
            }
        };

        // Helper to validate a specific field
        function validateField(fieldName) {
            const field = fields[fieldName];
            if (!field || !field.el) return true;
            
            const errorMsg = field.validate(field.el.value);
            if (errorMsg) {
                field.el.classList.add('is-invalid');
                field.errEl.textContent = errorMsg;
                return false;
            } else {
                field.el.classList.remove('is-invalid');
                field.errEl.textContent = '';
                return true;
            }
        }

        // Attach event listeners for each field
        Object.keys(fields).forEach(key => {
            const field = fields[key];
            if (field.el) {
                // Validate on blur
                field.el.addEventListener('blur', () => {
                    validateField(key);
                });

                // Clear/validate live on input once marked invalid (optional, but makes UX super slick!)
                field.el.addEventListener('input', () => {
                    if (field.el.classList.contains('is-invalid')) {
                        validateField(key);
                    }
                });
            }
        });

        // Additional listener for password confirmation live check
        if (fields.password_confirmation.el && fields.password.el) {
            fields.password.el.addEventListener('input', () => {
                if (fields.password_confirmation.el.value) {
                    validateField('password_confirmation');
                }
            });
        }

        // Validate all on form submit
        registerForm.addEventListener('submit', (e) => {
            let isValid = true;
            Object.keys(fields).forEach(key => {
                const isFieldValid = validateField(key);
                if (!isFieldValid) {
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                // Scroll the first invalid element into view smoothly
                const firstInvalid = registerForm.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstInvalid.focus();
                }
            }
        });
    }
});
