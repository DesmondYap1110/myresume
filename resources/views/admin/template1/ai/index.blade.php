@push('title')
AI Assistant
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>

    <style>
        .ai-shell { display: grid; grid-template-columns: minmax(0, 1fr) 320px; gap: 20px; align-items: start; }
        @media (max-width: 991px) { .ai-shell { grid-template-columns: 1fr; } }

        .ai-thread { height: 55vh; min-height: 340px; overflow-y: auto; padding: 20px; background: #f7f8fc; border-radius: 10px; }
        .ai-msg { display: flex; gap: 10px; margin-bottom: 16px; }
        .ai-msg .who { flex: 0 0 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 14px; color: #fff; background: #8a92a6; }
        .ai-msg.assistant .who { background: var(--brand-primary, #212529); color: var(--brand-button-text, #FFD700); }
        .ai-msg .bubble { background: #fff; border: 1px solid #ebedf2; border-radius: 10px; padding: 12px 14px; max-width: 80%; white-space: pre-wrap; word-wrap: break-word; line-height: 1.6; }
        .ai-msg.user { flex-direction: row-reverse; }
        .ai-msg.user .bubble { background: var(--brand-primary, #212529); color: #fff; border-color: transparent; }
        .ai-empty { color: #8a92a6; text-align: center; padding: 40px 10px; }
        .ai-typing .bubble { color: #8a92a6; font-style: italic; }

        .ai-composer { margin-top: 14px; }
        .ai-file { display: flex; align-items: center; gap: 10px; margin-top: 10px; font-size: 13px; color: #6c757d; }
        .ai-file .name { font-weight: 600; color: #1a2035; }
        .ai-draft ul { padding-left: 18px; margin-bottom: 8px; }
        .ai-draft li { font-size: 13px; }
        .ai-hint { font-size: 13px; color: #6c757d; }
        .ai-chip { display: inline-block; margin: 0 6px 6px 0; padding: 4px 10px; border: 1px solid #ebedf2; border-radius: 999px; font-size: 12px; cursor: pointer; background: #fff; }
        .ai-chip:hover { border-color: var(--brand-primary, #212529); }
    </style>

    <div class="col-md-12">
        @if(!$ready)
        <div class="alert alert-warning">
            <b>Not set up yet.</b> Choose an AI provider under
            <a href="{{ route('setting.view') }}#ai">Account Setting → AI Assistant</a> to use this page.
            The free option runs on this computer — no key, no bill.
        </div>
        @endif

        <div class="ai-shell">
            {{-- ============ Chat ============ --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Chat</div>
                        <div class="card-tools">
                            <form action="{{ route('ai.clear') }}" method="post" onsubmit="return confirm('Clear this conversation?')">
                                @csrf
                                <button class="btn btn-light btn-sm"><i class="fas fa-trash me-1"></i> Clear</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-category">
                        Using {{ $model }}
                        @unless($readsFiles)
                            · reads text PDFs (a scanned photo of a resume needs Claude)
                        @endunless
                    </div>
                </div>

                <div class="card-body">
                    <div class="ai-thread" id="ai-thread">
                        @forelse($history as $turn)
                        <div class="ai-msg {{ $turn['role'] }}">
                            <span class="who"><i class="fas {{ $turn['role'] === 'assistant' ? 'fa-robot' : 'fa-user' }}"></i></span>
                            <div class="bubble">{{ $turn['content'] }}</div>
                        </div>
                        @empty
                        <div class="ai-empty" id="ai-empty">
                            <i class="fas fa-robot fa-2x mb-3 d-block"></i>
                            Ask me to write your about text, tidy a job description, or
                            <b>attach your resume</b> and I will fill in your profile for you.
                        </div>
                        @endforelse
                    </div>

                    <form class="ai-composer" id="ai-form" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group">
                            <label class="btn btn-light mb-0" for="ai-resume" title="Attach a resume">
                                <i class="fas fa-paperclip"></i>
                                <input type="file" id="ai-resume" name="resume" hidden
                                       accept=".{{ implode(',.', $accepted) }}">
                            </label>
                            <input type="text" class="form-control" id="ai-input" name="message"
                                   placeholder="Ask something, or attach your resume..." maxlength="4000" autocomplete="off"
                                   @disabled(!$ready)>
                            <button class="btn btn-primary" type="submit" id="ai-send" @disabled(!$ready)>
                                <i class="fas fa-paper-plane"></i> Send
                            </button>
                        </div>

                        <div class="ai-file" id="ai-file" hidden>
                            <i class="fas fa-file-alt"></i><span class="name" id="ai-file-name"></span>
                            <button type="button" class="btn btn-sm btn-light" id="ai-file-clear">Remove</button>
                        </div>

                        <div class="mt-3">
                            <span class="ai-chip" data-ask="Write a short professional summary for my portfolio.">Write my about text</span>
                            <span class="ai-chip" data-ask="Suggest 3 services I could offer based on my experience.">Suggest services</span>
                            <span class="ai-chip" data-ask="Give me 5 blog post ideas based on my projects.">Blog ideas</span>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ============ Import panel ============ --}}
            <div class="card" id="ai-draft-card" @if(!$draft) hidden @endif>
                <div class="card-header">
                    <div class="card-title">Import from resume</div>
                    <div class="card-category">Review, then choose what to save.</div>
                </div>
                <form action="{{ route('ai.import') }}" method="post">
                    @csrf
                    <div class="card-body ai-draft" id="ai-draft-body">
                        @if($draft)
                        @php
                            $preview = [
                                'profile' => collect($draft['profile'] ?? [])->filter(fn ($v) => filled($v))->keys()->all(),
                                'experience' => collect($draft['experience'] ?? [])->map(fn ($j) => trim(($j['role'] ?? '').' at '.($j['company'] ?? '')))->all(),
                                'education' => collect($draft['education'] ?? [])->map(fn ($e) => trim(($e['certificate'] ?? '').' — '.($e['institution'] ?? '')))->all(),
                                'services' => collect($draft['services'] ?? [])->pluck('title')->all(),
                            ];
                        @endphp
                        @foreach($preview as $section => $items)
                            @if(count($items))
                            <div class="mb-3">
                                <label class="mb-1">
                                    <input type="checkbox" name="sections[]" value="{{ $section }}" checked>
                                    <b class="text-capitalize">{{ $section }}</b> ({{ count($items) }})
                                </label>
                                <ul>
                                    @foreach(array_slice($items, 0, 8) as $item)<li>{{ $item }}</li>@endforeach
                                </ul>
                            </div>
                            @endif
                        @endforeach
                        <p class="ai-hint mb-0">Existing entries with the same company, role or institution are updated, not duplicated. Your login email is never changed.</p>
                        @endif
                    </div>
                    <div class="card-action">
                        <button class="btn btn-success"><i class="fas fa-check me-1"></i> Import selected</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('script')
    <script>
    (function () {
        var form = document.getElementById('ai-form');
        if (!form) return;

        var thread = document.getElementById('ai-thread');
        var input = document.getElementById('ai-input');
        var fileInput = document.getElementById('ai-resume');
        var fileRow = document.getElementById('ai-file');
        var fileName = document.getElementById('ai-file-name');
        var sendBtn = document.getElementById('ai-send');
        var draftCard = document.getElementById('ai-draft-card');
        var draftBody = document.getElementById('ai-draft-body');

        function scroll() { thread.scrollTop = thread.scrollHeight; }

        function bubble(role, text, extraClass) {
            var empty = document.getElementById('ai-empty');
            if (empty) empty.remove();

            var wrap = document.createElement('div');
            wrap.className = 'ai-msg ' + role + (extraClass ? ' ' + extraClass : '');
            wrap.innerHTML = '<span class="who"><i class="fas ' + (role === 'assistant' ? 'fa-robot' : 'fa-user') + '"></i></span>';

            var body = document.createElement('div');
            body.className = 'bubble';
            body.textContent = text;          // text only: never render model output as HTML
            wrap.appendChild(body);

            thread.appendChild(wrap);
            scroll();
            return wrap;
        }

        fileInput.addEventListener('change', function () {
            var file = fileInput.files[0];
            fileRow.hidden = !file;
            fileName.textContent = file ? file.name : '';
        });

        document.getElementById('ai-file-clear').addEventListener('click', function () {
            fileInput.value = '';
            fileRow.hidden = true;
        });

        document.querySelectorAll('.ai-chip').forEach(function (chip) {
            chip.addEventListener('click', function () {
                input.value = chip.getAttribute('data-ask');
                input.focus();
            });
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            var text = input.value.trim();
            var file = fileInput.files[0];
            if (!text && !file) return;

            bubble('user', text + (file ? (text ? ' ' : '') + '[' + file.name + ']' : ''));
            input.value = '';

            var pending = bubble('assistant', file ? 'Reading your resume…' : 'Thinking…', 'ai-typing');
            sendBtn.disabled = true;

            var data = new FormData(form);
            data.set('message', text);

            fetch('{{ route('ai.message') }}', {
                method: 'POST',
                body: data,
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            })
            .then(function (r) { return r.json().then(function (j) { return { ok: r.ok, body: j }; }); })
            .then(function (res) {
                pending.remove();

                if (!res.body.ok) {
                    bubble('assistant', res.body.error || 'Something went wrong. Please try again.');
                    return;
                }

                bubble('assistant', res.body.reply);

                if (res.body.draft) {
                    renderDraft(res.body.draft);
                }
            })
            .catch(function () {
                pending.remove();
                bubble('assistant', 'The request failed. Check your connection and try again.');
            })
            .then(function () {
                sendBtn.disabled = false;
                fileInput.value = '';
                fileRow.hidden = true;
                scroll();
            });
        });

        function renderDraft(draft) {
            var html = '';
            ['profile', 'experience', 'education', 'services'].forEach(function (section) {
                var items = draft[section] || [];
                if (!items.length) return;
                html += '<div class="mb-3"><label class="mb-1">'
                     +  '<input type="checkbox" name="sections[]" value="' + section + '" checked> '
                     +  '<b class="text-capitalize">' + section + '</b> (' + items.length + ')</label><ul>';
                items.slice(0, 8).forEach(function (item) {
                    var li = document.createElement('li');
                    li.textContent = item;
                    html += li.outerHTML;
                });
                html += '</ul></div>';
            });
            html += '<p class="ai-hint mb-0">Existing entries with the same company, role or institution are updated, not duplicated. Your login email is never changed.</p>';

            draftBody.innerHTML = html;
            draftCard.hidden = false;
            draftCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        scroll();
    })();
    </script>
    @endpush
</x-template1.admin.master.master-layout>
