@props(['person' => null])
{{-- Shared fields for the Member add and edit forms. --}}

<div class="card-action">
    <div class="row">
        @php $isSelf = $person && $person->id === Auth::id(); @endphp
        <div class="col-6 py-1">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="status" name="status" value="1"
                       @checked(old('status', $person->status ?? 1)) @disabled($isSelf)>
                <label class="form-check-label" for="status">Active — can sign in and their website is public</label>
            </div>
        </div>
        <div class="col-6 py-1">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="is_admin" name="is_admin" value="1"
                       @checked(old('is_admin', $person->is_admin ?? false)) @disabled($isSelf)>
                <label class="form-check-label" for="is_admin">Administrator — can manage Member</label>
            </div>
        </div>

        <div class="col-md-6 py-1">
            <label for="name">Full name <span class="required-label">*</span></label>
            <input type="text" class="form-control" id="name" name="name" required maxlength="255"
                   value="{{ old('name', $person->name ?? '') }}" placeholder="e.g. Yap Jia Chun">
            @error('name')<span class="text-danger d-block">{{ $message }}</span>@enderror
        </div>

        <div class="col-md-6 py-1">
            <label for="email">Email address <span class="required-label">*</span></label>
            <input type="email" class="form-control" id="email" name="email" required maxlength="255"
                   value="{{ old('email', $person->email ?? '') }}" placeholder="name@example.com" autocomplete="off">
            @error('email')<span class="text-danger d-block">{{ $message }}</span>@enderror
        </div>

        <div class="col-md-6 py-1">
            <label for="password">Password @if(!$person)<span class="required-label">*</span>@endif</label>
            <input type="password" class="form-control" id="password" name="password" minlength="6" maxlength="255"
                   autocomplete="new-password" placeholder="{{ $person ? 'Leave blank to keep the current one' : 'At least 6 characters' }}"
                   @if(!$person) required @endif>
            @error('password')<span class="text-danger d-block">{{ $message }}</span>@enderror
        </div>

        <div class="col-md-6 py-1">
            <label for="slug">Website address <span class="required-label">*</span></label>
            <div class="input-group">
                <span class="input-group-text">{{ rtrim(url('/'), '/') }}/</span>
                <input type="text" class="form-control" id="slug" name="slug" required minlength="3" maxlength="60"
                       pattern="[a-z0-9]+(-[a-z0-9]+)*" placeholder="yap-jia-chun"
                       value="{{ old('slug', $person->slug ?? '') }}">
            </div>
            @error('slug')<span class="text-danger d-block">{{ $message }}</span>@enderror
        </div>

        <div class="col-md-6 py-1">
            <label for="website_template">Website template <span class="required-label">*</span></label>
            <select class="form-control form-select" id="website_template" name="website_template">
                @foreach((array) config('website_templates.templates', []) as $key => $template)
                <option value="{{ $key }}" @selected(old('website_template', $person->website_template ?? config('website_templates.default')) === $key)>{{ $template['name'] }}</option>
                @endforeach
            </select>
            @error('website_template')<span class="text-danger d-block">{{ $message }}</span>@enderror
        </div>

    </div>
</div>
