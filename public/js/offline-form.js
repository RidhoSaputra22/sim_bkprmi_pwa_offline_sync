/**
 * SIM BKPRMI - Offline Form Handler
 * Intercepts form submissions for offline support
 */

class OfflineFormHandler {
    constructor() {
        this.forms = new Map();
    }

    init() {
        // Auto-attach to forms with data-offline attribute
        document.querySelectorAll('form[data-offline]').forEach(form => {
            this.attachToForm(form);
        });

        // Watch for dynamically added forms
        const observer = new MutationObserver((mutations) => {
            mutations.forEach(mutation => {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === 1) {
                        if (node.matches && node.matches('form[data-offline]')) {
                            this.attachToForm(node);
                        }
                        node.querySelectorAll?.('form[data-offline]').forEach(form => {
                            this.attachToForm(form);
                        });
                    }
                });
            });
        });

        observer.observe(document.body, { childList: true, subtree: true });
        console.log('[OfflineForm] Handler initialized');
    }

    attachToForm(form) {
        if (this.forms.has(form)) return;

        const config = {
            type: form.dataset.offlineType || 'form-submit',
            endpoint: form.dataset.offlineEndpoint || form.action,
            method: form.dataset.offlineMethod || form.method || 'POST',
            successMessage: form.dataset.offlineSuccess || 'Data berhasil disimpan',
            offlineMessage: form.dataset.offlineMessage || 'Data disimpan offline'
        };

        form.addEventListener('submit', (e) => this.handleSubmit(e, form, config));
        this.forms.set(form, config);

        console.log('[OfflineForm] Attached to form:', config.type);
    }

    async handleSubmit(event, form, config) {
        event.preventDefault();

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        // Handle arrays (checkboxes, multi-selects)
        formData.forEach((value, key) => {
            if (key.endsWith('[]')) {
                const cleanKey = key.slice(0, -2);
                if (!data[cleanKey]) {
                    data[cleanKey] = formData.getAll(key);
                }
                delete data[key];
            }
        });

        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn?.innerHTML;

        try {
            // Show loading state
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="loading loading-spinner loading-sm"></span> Menyimpan...';
            }

            if (navigator.onLine) {
                // Try to submit online
                await this.submitOnline(form, config, data);
            } else {
                // Save for offline sync
                await this.submitOffline(form, config, data);
            }

        } catch (error) {
            console.error('[OfflineForm] Submit error:', error);

            // If network error, save offline
            if (!navigator.onLine || error.name === 'TypeError') {
                await this.submitOffline(form, config, data);
            } else {
                window.syncManager.showNotification(error.message || 'Gagal menyimpan data', 'error');
            }
        } finally {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        }
    }

    async submitOnline(form, config, data) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        const response = await fetch(config.endpoint, {
            method: config.method.toUpperCase(),
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify(data),
            credentials: 'same-origin'
        });

        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));

            // Handle validation errors
            if (response.status === 422 && errorData.errors) {
                this.showValidationErrors(form, errorData.errors);
                throw new Error('Validasi gagal');
            }

            throw new Error(errorData.message || 'Gagal menyimpan data');
        }

        const result = await response.json();

        window.syncManager.showNotification(config.successMessage, 'success');

        // Trigger success event
        form.dispatchEvent(new CustomEvent('offline-form:success', {
            detail: { data: result, online: true }
        }));

        // Redirect if specified
        if (result.redirect) {
            window.location.href = result.redirect;
        } else if (form.dataset.offlineRedirect) {
            window.location.href = form.dataset.offlineRedirect;
        }

        return result;
    }

    async submitOffline(form, config, data) {
        // Add metadata
        data._offline = true;
        data._offline_timestamp = Date.now();

        await window.syncManager.saveForSync(
            config.type,
            config.endpoint,
            config.method.toUpperCase(),
            data
        );

        window.syncManager.showNotification(config.offlineMessage, 'info');

        // Trigger offline save event
        form.dispatchEvent(new CustomEvent('offline-form:offline', {
            detail: { data, online: false }
        }));

        // Optional: Save as draft
        if (form.dataset.offlineDraft) {
            await window.offlineDB.saveDraft(form.id || config.type, data);
        }

        // Clear form or redirect
        if (form.dataset.offlineClear === 'true') {
            form.reset();
        }

        if (form.dataset.offlineRedirect) {
            window.location.href = form.dataset.offlineRedirect;
        }
    }

    showValidationErrors(form, errors) {
        // Clear previous errors
        form.querySelectorAll('.text-error').forEach(el => el.remove());
        form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));

        // Show new errors
        Object.entries(errors).forEach(([field, messages]) => {
            const input = form.querySelector(`[name="${field}"]`);
            if (input) {
                input.classList.add('input-error');

                const errorDiv = document.createElement('div');
                errorDiv.className = 'text-error text-sm mt-1';
                errorDiv.textContent = Array.isArray(messages) ? messages[0] : messages;
                input.parentNode.appendChild(errorDiv);
            }
        });
    }
}

// Export singleton
window.offlineFormHandler = new OfflineFormHandler();

// Initialize when DOM ready
document.addEventListener('DOMContentLoaded', () => {
    window.offlineFormHandler.init();
});
