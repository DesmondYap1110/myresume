@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush

@push('script')
<script>
    // Runs after Bootstrap is loaded: reopen the tab named in the address
    // (#theme) or the last one used.
    (function () {
        var tabs = { '#password': 'tab-password', '#template': 'tab-template', '#theme': 'tab-theme', '#ai': 'tab-ai' };
        var wanted = tabs[location.hash] || localStorage.getItem('settingTab');
        var button = wanted && document.getElementById(wanted);

        if (button && window.bootstrap) new bootstrap.Tab(button).show();

        document.querySelectorAll('#setting-tabs .nav-link').forEach(function (el) {
            el.addEventListener('shown.bs.tab', function () {
                try { localStorage.setItem('settingTab', el.id); } catch (e) {}
            });
        });
    })();

    // AI Assistant tab: show only the fields the chosen provider needs.
    (function () {
        var meta = JSON.parse(document.getElementById('ai-provider-meta').textContent);
        var radios = document.querySelectorAll('#ai-providers input[name="provider"]');
        var urlRow = document.getElementById('ai-url-row');
        var keyRow = document.getElementById('ai-key-row');
        var urlField = document.getElementById('base_url');
        var modelField = document.getElementById('ai_model');
        var modelCustom = document.getElementById('ai_model_custom');
        var modelHint = document.getElementById('ai-model-hint');
        var urlHint = document.getElementById('ai-url-hint');

        if (!radios.length) return;

        function option(value, label) {
            var el = document.createElement('option');
            el.value = value;
            el.textContent = label;
            modelField.appendChild(el);
            return el;
        }

        // The list a provider ships with, plus whatever is already saved, plus
        // a way to type a name the list doesn't have.
        function fillModels(conf, want) {
            var models = conf.models || {};
            var known = Object.keys(models);

            modelField.innerHTML = '';

            if (want && want !== '__custom' && known.indexOf(want) === -1) {
                option(want, want);
            }

            known.forEach(function (id) { option(id, models[id]); });
            option('__custom', 'Other — type a name…');

            modelField.value = want || conf.model || known[0] || '__custom';
            showCustom();

            modelHint.textContent = conf.modelHint || '';
        }

        function showCustom() {
            modelCustom.hidden = modelField.value !== '__custom';
        }

        function apply(name, changed) {
            var conf = meta[name];
            if (!conf) return;

            urlRow.hidden = !conf.needsUrl;
            keyRow.hidden = !conf.needsKey;

            urlHint.textContent = conf.hint || '';
            urlField.placeholder = conf.url || '';

            // Switching provider: start from that provider's own defaults.
            if (changed) {
                urlField.value = conf.url || '';
            }

            fillModels(conf, changed ? conf.model : modelField.dataset.current);

            document.querySelectorAll('.ai-provider-card').forEach(function (card) {
                card.classList.toggle('is-active', card.querySelector('input').value === name);
            });
        }

        radios.forEach(function (radio) {
            radio.addEventListener('change', function () { apply(radio.value, true); });
        });

        modelField.addEventListener('change', showCustom);

        apply(document.querySelector('#ai-providers input[name="provider"]:checked').value, false);
    })();
</script>
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>

    <style>
        .setting-tabs { border-bottom: 1px solid #ebedf2; margin-bottom: 24px; gap: 4px; }
        .setting-tabs .nav-link { border: 0; border-bottom: 3px solid transparent; border-radius: 0; padding: 12px 18px; font-weight: 600; color: #6c757d; background: none; }
        .setting-tabs .nav-link:hover { color: #1a2035; }
        .setting-tabs .nav-link.active { color: #1a2035; border-bottom-color: var(--brand-primary, #212529); background: none; }
        .setting-tabs .nav-link i { margin-right: 8px; }

        .ai-provider-card { display: block; border: 2px solid #ebedf2; border-radius: 12px; padding: 14px; cursor: pointer; background: #fff; transition: border-color .2s ease, box-shadow .2s ease; }
        .ai-provider-card:hover { border-color: #d6dae5; }
        .ai-provider-card.is-active { border-color: var(--brand-primary, #212529); box-shadow: 0 0 0 3px rgba(0,0,0,.06); }
        .ai-provider-card i { color: var(--brand-primary, #212529); }
        .ai-provider-card b { font-size: .92rem; line-height: 1.3; }

        .template-options { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 18px; }
        .template-option input { position: absolute; opacity: 0; pointer-events: none; }
        .template-card { display: block; height: 100%; border: 2px solid #ebedf2; border-radius: 12px; overflow: hidden; background: #fff; cursor: pointer; transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease; }
        .template-card:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,.08); }
        .template-option input:checked + .template-card { border-color: var(--brand-primary, #212529); box-shadow: 0 0 0 3px rgba(0,0,0,.08); }
        .template-option input:focus-visible + .template-card { outline: 2px solid var(--brand-primary, #212529); outline-offset: 2px; }
        .template-shot { display: block; position: relative; aspect-ratio: 16 / 10; background: #f5f7fd center top / cover no-repeat; border-bottom: 1px solid #ebedf2; }
        .template-live { position: absolute; top: 10px; left: 10px; font-size: 11px; font-weight: 700; padding: 2px 10px; border-radius: 999px; background: #1f9d55; color: #fff; }
        .template-body { display: block; padding: 14px 16px; }
        .template-body b { display: flex; align-items: center; justify-content: space-between; gap: 8px; font-size: 15px; color: #1a2035; }
        .template-body .tick { width: 22px; height: 22px; border-radius: 50%; border: 2px solid #d5d9e2; flex: 0 0 auto; position: relative; }
        .template-option input:checked + .template-card .tick { border-color: var(--brand-primary, #212529); background: var(--brand-primary, #212529); }
        .template-option input:checked + .template-card .tick::after { content: ""; position: absolute; left: 6px; top: 2px; width: 6px; height: 11px; border: solid var(--brand-button-text, #fff); border-width: 0 2px 2px 0; transform: rotate(45deg); }
        .template-body small { display: block; margin-top: 6px; color: #6c757d; line-height: 1.45; }
    </style>

    <div class="col-md-12">
        <ul class="nav setting-tabs" id="setting-tabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab-password" data-bs-toggle="tab" data-bs-target="#pane-password" type="button" role="tab" aria-controls="pane-password" aria-selected="true">
                    <i class="fas fa-key"></i>Password
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-template" data-bs-toggle="tab" data-bs-target="#pane-template" type="button" role="tab" aria-controls="pane-template" aria-selected="false">
                    <i class="fas fa-desktop"></i>Website Template
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-theme" data-bs-toggle="tab" data-bs-target="#pane-theme" type="button" role="tab" aria-controls="pane-theme" aria-selected="false">
                    <i class="fas fa-palette"></i>Theme Setting
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-ai" data-bs-toggle="tab" data-bs-target="#pane-ai" type="button" role="tab" aria-controls="pane-ai" aria-selected="false">
                    <i class="fas fa-robot"></i>AI Assistant
                </button>
            </li>
        </ul>

        <div class="tab-content">

            {{-- ============ Password ============ --}}
            <div class="tab-pane fade show active" id="pane-password" role="tabpanel" aria-labelledby="tab-password">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Edit Password</div>
                        <div class="card-category">Your login for this admin.</div>
                    </div>
                    <div class="form-group form-show-validation row">
                        <label for="email" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">E-mail <span class="required-label">*</span></label>
                        <div class="col-lg-4 col-md-9 col-sm-8">
                            <input type="email" class="form-control" id="email" placeholder="Enter Email" disabled value="{{Auth::user()->email}}">
                        </div>
                    </div>
                    <form action="{{route("setting.update")}}" method="post">
                        @csrf
                        <div class="form-group form-show-validation row">
                            <label for="password" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">Password <span class="required-label">*</span></label>
                            <div class="col-lg-4 col-md-9 col-sm-8">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                            </div>
                        </div>
                        <div class="form-group form-show-validation row">
                            <label for="confirmpassword" class="col-lg-3 col-md-3 col-sm-4 mt-sm-2 text-end">Confirm Password <span class="required-label">*</span></label>
                            <div class="col-lg-4 col-md-9 col-sm-8">
                                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Enter Password" required>
                            </div>
                        </div>
                        <div class="card-action">
                            <div class="row">
                                <div class="col-md-12">
                                    <input class="btn btn-success" type="submit" value="Submit">
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ============ Website Template ============ --}}
            <div class="tab-pane fade" id="pane-template" role="tabpanel" aria-labelledby="tab-template">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Website Template</div>
                        <div class="card-category">Choose the design visitors see on your public portfolio.</div>
                    </div>
                    <form action="{{ route('setting.template') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="template-options" role="radiogroup" aria-label="Website template">
                                @foreach($templates as $key => $template)
                                <label class="template-option mb-0">
                                    <input type="radio" name="website_template" value="{{ $key }}" @checked(old('website_template', $currentTemplate) === $key)>
                                    <span class="template-card">
                                        <span class="template-shot" style="background-image: url('{{ asset($template['preview']) }}')">
                                            @if($currentTemplate === $key)
                                            <span class="template-live">Live</span>
                                            @endif
                                        </span>
                                        <span class="template-body">
                                            <b>{{ $template['name'] }} <span class="tick"></span></b>
                                            <small>{{ $template['description'] }}</small>
                                        </span>
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Save Template</button>
                            <a href="{{ route('front.show', Auth::user()->routeKey()) }}" target="_blank" rel="noopener" class="btn btn-light">
                                <i class="fas fa-external-link-alt me-1"></i> View Website
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ============ Theme Setting ============ --}}
            <div class="tab-pane fade" id="pane-theme" role="tabpanel" aria-labelledby="tab-theme">
                <x-template1.admin.setting.theme-panel
                    :presets="$presets"
                    :active-preset="$activePreset"
                    :current="$current"
                    :editable="$editable"
                    :login="$login"
                    :login-images="$loginImages"
                    :login-uploaded="$loginUploaded"
                    :login-overlay="$loginOverlay"
                    :website-template="$websiteTemplate"
                    :website-template-name="$websiteTemplateName"
                    :website-follows-admin="$websiteFollowsAdmin"
                    :website-preset="$websitePreset"
                    :website-current="$websiteCurrent"
                />
            </div>

            {{-- ============ AI Assistant ============ --}}
            @php
                $aiCurrentProvider = old('provider', $aiSetting->resolvedProvider());
                $aiProviderMeta = [];
                foreach ($aiProviders as $aiKey => $aiConf) {
                    $aiProviderMeta[$aiKey] = [
                        'needsKey' => (bool) ($aiConf['needs_key'] ?? false),
                        'needsUrl' => (bool) ($aiConf['needs_url'] ?? false),
                        'url' => $aiConf['default_url'] ?? '',
                        'model' => $aiConf['default_model'] ?? '',
                        'models' => (array) ($aiConf['models'] ?? []),
                        'hint' => $aiConf['hint'] ?? '',
                        'modelHint' => $aiConf['model_hint'] ?? '',
                    ];
                }
            @endphp
            <div class="tab-pane fade" id="pane-ai" role="tabpanel" aria-labelledby="tab-ai">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">AI Assistant</div>
                        <div class="card-category">
                            Choose which AI does the work. It powers the AI Assistant page, where you can chat and upload a resume to fill in your details.
                        </div>
                    </div>
                    <form action="{{ route('setting.ai') }}" method="post">
                        @csrf
                        <div class="card-body">

                            <script type="application/json" id="ai-provider-meta">@json($aiProviderMeta)</script>

                            <label class="d-block mb-2">Provider</label>
                            <div class="row" id="ai-providers">
                                @foreach($aiProviders as $key => $conf)
                                <div class="col-lg-4 py-1">
                                    <label class="ai-provider-card w-100 h-100 {{ $aiCurrentProvider === $key ? 'is-active' : '' }}">
                                        <input type="radio" name="provider" value="{{ $key }}" class="d-none"
                                               @checked($aiCurrentProvider === $key)>
                                        <span class="d-flex align-items-start">
                                            <i class="fas {{ $key === 'ollama' ? 'fa-laptop-code' : ($key === 'claude' ? 'fa-cloud' : 'fa-server') }} me-2 mt-1"></i>
                                            <span>
                                                <b class="d-block">{{ $conf['label'] }}</b>
                                                <small class="text-muted d-block">{{ $conf['hint'] ?? '' }}</small>
                                                @if($conf['free'] ?? false)
                                                    <span class="badge bg-success mt-2">Free</span>
                                                @else
                                                    <span class="badge bg-secondary mt-2">Paid</span>
                                                @endif
                                            </span>
                                        </span>
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @error('provider')<span class="text-danger d-block">{{ $message }}</span>@enderror

                            <div class="row mt-3">
                                <div class="col-lg-7 py-1" id="ai-url-row">
                                    <label for="base_url">Server address</label>
                                    <input type="text" class="form-control" id="base_url" name="base_url"
                                           value="{{ old('base_url', $aiSetting->base_url) }}" maxlength="200"
                                           placeholder="http://localhost:11434">
                                    <small class="form-text text-muted" id="ai-url-hint">Where the AI is running.</small>
                                    @error('base_url')<span class="text-danger d-block">{{ $message }}</span>@enderror
                                </div>

                                <div class="col-lg-5 py-1">
                                    <label for="ai_model">Model</label>
                                    @php
                                        $aiModel = old('model', $aiSetting->resolvedModel());
                                        $aiModelList = (array) ($aiProviders[$aiCurrentProvider]['models'] ?? []);
                                    @endphp
                                    <select class="form-control form-select" id="ai_model" name="model" data-current="{{ $aiModel }}">
                                        @unless(array_key_exists($aiModel, $aiModelList))
                                        <option value="{{ $aiModel }}" selected>{{ $aiModel }}</option>
                                        @endunless
                                        @foreach($aiModelList as $id => $label)
                                        <option value="{{ $id }}" @selected($aiModel === $id)>{{ $label }}</option>
                                        @endforeach
                                        <option value="__custom">Other — type a name…</option>
                                    </select>

                                    <input type="text" class="form-control mt-2" id="ai_model_custom" name="model_custom"
                                           value="{{ old('model_custom') }}" maxlength="120" autocomplete="off"
                                           placeholder="Type the model name" hidden>

                                    <small class="form-text text-muted" id="ai-model-hint">{{ $aiProviders[$aiCurrentProvider]['model_hint'] ?? '' }}</small>
                                    @error('model')<span class="text-danger d-block">{{ $message }}</span>@enderror
                                    @error('model_custom')<span class="text-danger d-block">{{ $message }}</span>@enderror
                                </div>

                                <div class="col-lg-7 py-1" id="ai-key-row">
                                    <label for="api_key">API key</label>
                                    <input type="password" class="form-control" id="api_key" name="api_key"
                                           placeholder="{{ $aiSetting->api_key ? 'Saved — leave blank to keep it' : 'Paste your key' }}"
                                           autocomplete="off" maxlength="200">
                                    <small class="form-text text-muted">
                                        @if($aiSetting->api_key)
                                            Currently: <b>{{ $aiSetting->keyHint() }}</b>. Leave blank to keep it.
                                        @else
                                            Stored encrypted, and never shown again once saved.
                                        @endif
                                    </small>
                                    @error('api_key')<span class="text-danger d-block">{{ $message }}</span>@enderror
                                </div>

                                <div class="col-12 py-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="ai_enabled" name="enabled" value="1" @checked(old('enabled', $aiSetting->enabled ?? true))>
                                        <label class="form-check-label" for="ai_enabled">Enable the AI Assistant</label>
                                    </div>
                                    @if($aiSetting->last_used_at)
                                    <small class="form-text text-muted">Last used {{ $aiSetting->last_used_at->diffForHumans() }}.</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" name="action" value="save" class="btn btn-success">Save</button>
                            <button type="submit" name="action" value="test" class="btn btn-light">Test connection</button>
                            <a href="{{ route('ai.view') }}" class="btn btn-light"><i class="fas fa-robot me-1"></i> Open AI Assistant</a>
                            @if($aiSetting->api_key && $aiSetting->needsKey())
                            <button type="submit" name="action" value="remove" class="btn btn-danger float-end"
                                    onclick="return confirm('Remove the saved API key?')">Remove key</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</x-template1.admin.master.master-layout>
