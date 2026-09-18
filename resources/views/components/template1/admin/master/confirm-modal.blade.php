{{-- Stands in for the browser's confirm() and alert() dialogs.

     Confirm: put data-confirm="Question?" on a link, a submit button, or a form.
     Optional: data-confirm-title, data-confirm-ok, data-confirm-class.

     Message: call adminAlert('Copied!') from anywhere. --}}

<div class="modal fade" id="adminConfirmModal" tabindex="-1" aria-labelledby="adminConfirmTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminConfirmTitle">Please confirm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="adminConfirmMessage"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal" id="adminConfirmCancel">Cancel</button>
                <button type="button" class="btn btn-danger" id="adminConfirmOk">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var modalEl = document.getElementById('adminConfirmModal');
    if (!modalEl || typeof bootstrap === 'undefined') return;

    var modal = new bootstrap.Modal(modalEl);
    var titleEl = document.getElementById('adminConfirmTitle');
    var messageEl = document.getElementById('adminConfirmMessage');
    var cancelEl = document.getElementById('adminConfirmCancel');
    var okEl = document.getElementById('adminConfirmOk');
    var proceed = null;

    function open(options) {
        titleEl.textContent = options.title;
        messageEl.textContent = options.message;
        okEl.textContent = options.ok;
        okEl.className = 'btn ' + options.okClass;
        cancelEl.classList.toggle('d-none', !options.cancel);
        proceed = options.run || null;
        modal.show();
    }

    okEl.addEventListener('click', function () {
        var run = proceed;
        proceed = null;
        modal.hide();
        if (run) run();
    });

    modalEl.addEventListener('hidden.bs.modal', function () { proceed = null; });

    function ask(el, run) {
        open({
            title: el.getAttribute('data-confirm-title') || 'Please confirm',
            message: el.getAttribute('data-confirm'),
            ok: el.getAttribute('data-confirm-ok') || 'Confirm',
            okClass: el.getAttribute('data-confirm-class') || 'btn-danger',
            cancel: true,
            run: run
        });
    }

    // Nothing to decide, so one button and no cancel.
    window.adminAlert = function (message, title) {
        open({ title: title || 'Done', message: message, ok: 'OK', okClass: 'btn-primary', cancel: false });
    };

    function submitForm(form, submitter) {
        if (form.requestSubmit) {
            form.requestSubmit(submitter || undefined);
            return;
        }
        if (submitter && submitter.name) {
            var hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = submitter.name;
            hidden.value = submitter.value;
            form.appendChild(hidden);
        }
        form.submit();
    }

    document.addEventListener('click', function (e) {
        var el = e.target.closest('[data-confirm]');
        if (!el || el.tagName === 'FORM' || el.dataset.confirmed === 'yes') return;
        e.preventDefault();
        ask(el, function () {
            el.dataset.confirmed = 'yes';
            if (el.tagName === 'A') {
                window.location.href = el.href;
            } else if (el.form) {
                submitForm(el.form, el);
            } else {
                el.click();
            }
        });
    });

    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (!form.matches || !form.matches('[data-confirm]') || form.dataset.confirmed === 'yes') return;
        e.preventDefault();
        ask(form, function () {
            form.dataset.confirmed = 'yes';
            submitForm(form, e.submitter || null);
        });
    }, true);
})();
</script>
