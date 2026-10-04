@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush

@push('script')
<script>
    // The address and model a provider expects, so switching provider does not
    // leave the last one's settings behind for someone to puzzle over.
    (function () {
        var meta = JSON.parse(document.getElementById('ai-meta').textContent);
        var provider = document.getElementById('provider');
        var url = document.getElementById('base_url');
        var model = document.getElementById('model');
        var urlRow = document.getElementById('url-row');

        if (!provider) return;

        provider.addEventListener('change', function () {
            var conf = meta[provider.value];
            if (!conf) return;

            urlRow.hidden = !conf.needsUrl;
            url.value = conf.url || '';
            url.placeholder = conf.url || '';
            model.value = conf.model || '';
        });
    })();
</script>
@endpush

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>

    @php
        $meta = collect($providers)->map(fn ($c) => [
            'needsUrl' => (bool) ($c['needs_url'] ?? false),
            'url' => $c['default_url'] ?? '',
            'model' => $c['default_model'] ?? '',
        ]);
        $current = old('provider', $setting->resolvedProvider());
    @endphp

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row card-tools-still-right">
                    <div class="card-title">AI Assistant for {{ $person->name }}</div>
                    <div class="card-tools">
                        <a href="{{ route('aisetting.view') }}" class="btn btn-dark btn-sm">{{ __('admin.ui.back_to_ai_setting') }}</a>
                    </div>
                </div>
                <div class="card-category">{{ $person->email }}</div>
            </div>

            <form action="{{ route('aisetting.update', $person->id) }}" method="POST">
                @csrf
                <script type="application/json" id="ai-meta">@json($meta)</script>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 py-1">
                            <label for="provider">{{ __('admin.ui.provider') }}</label>
                            <select class="form-control form-select" id="provider" name="provider">
                                @foreach($providers as $key => $conf)
                                <option value="{{ $key }}" @selected($current === $key)>{{ $conf['label'] }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">{{ $providers[$current]['hint'] ?? '' }}</small>
                            @error('provider')<span class="text-danger d-block">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-lg-6 py-1" id="url-row" @if(!($providers[$current]['needs_url'] ?? false)) hidden @endif>
                            <label for="base_url">{{ __('admin.ui.server_address') }}</label>
                            <input type="text" class="form-control" id="base_url" name="base_url"
                                   value="{{ old('base_url', $setting->resolvedUrl()) }}" maxlength="200"
                                   placeholder="https://api.openai.com/v1" spellcheck="false">
                            <small class="form-text text-muted">{{ __('admin.ui.endpoint_note') }}</small>
                            @error('base_url')<span class="text-danger d-block">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-lg-6 py-1">
                            <label for="model">{{ __('admin.ui.model') }}</label>
                            <input type="text" class="form-control" id="model" name="model"
                                   value="{{ old('model', $setting->resolvedModel()) }}" maxlength="120"
                                   placeholder="gpt-4o-mini" spellcheck="false">
                            <small class="form-text text-muted">{{ $providers[$current]['model_hint'] ?? '' }}</small>
                            @error('model')<span class="text-danger d-block">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-lg-6 py-1">
                            <label for="api_key">{{ __('admin.ui.api_key') }}</label>
                            <input type="text" class="form-control" id="api_key" name="api_key"
                                   value="{{ old('api_key', $setting->plainKey()) }}" maxlength="200"
                                   placeholder="Paste {{ $person->name }}'s key" autocomplete="off" spellcheck="false">
                            <small class="form-text text-muted">Stored encrypted against {{ $person->name }}'s account only.</small>
                            @error('api_key')<span class="text-danger d-block">{{ $message }}</span>@enderror
                        </div>

                        <div class="col-12 py-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="enabled" name="enabled" value="1"
                                       @checked(old('enabled', $setting->enabled ?? true))>
                                <label class="form-check-label" for="enabled">{{ __('admin.ui.enable_ai_member') }}</label>
                            </div>
                            @if($setting->last_used_at)
                            <small class="form-text text-muted">Last used {{ $setting->last_used_at->diffForHumans() }}.</small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" name="action" value="save" class="btn btn-success">{{ __('admin.ui.save') }}</button>
                    <button type="submit" name="action" value="test" class="btn btn-secondary">{{ __('admin.ui.test_connection') }}</button>
                    @if($setting->plainKey())
                    <button type="submit" name="action" value="remove" class="btn btn-danger float-end"
                            data-confirm="{{ __('admin.confirm.q_remove_key', ['name' => $person->name]) }}"
                            data-confirm-title="{{ __('admin.confirm.t_remove_key') }}" data-confirm-ok="{{ __('admin.confirm.ok_remove') }}">{{ __('admin.ui.remove_key') }}</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</x-template1.admin.master.master-layout>
