@push('title')
{{$breadcrumbs['CurrentPage']}}
@endpush

@push('script')
<script>
(function () {
    var table = document.getElementById('skilltable');
    if (!table) return;
    var tbody = table.querySelector('tbody');

    function setEditing(id, on) {
        var row = tbody.querySelector('[data-skill-row="' + id + '"]');
        if (row) row.classList.toggle('is-editing', on);
    }

    document.addEventListener('click', function (e) {
        var edit = e.target.closest('[data-skill-edit]');
        if (edit) { setEditing(edit.getAttribute('data-skill-edit'), true); return; }

        var cancel = e.target.closest('[data-skill-cancel]');
        if (cancel) { setEditing(cancel.getAttribute('data-skill-cancel'), false); }
    });

    // ---- Drag to reorder ----
    var dragRow = null;

    function clearMarks() {
        tbody.querySelectorAll('.drop-target').forEach(function (r) { r.classList.remove('drop-target'); });
    }

    tbody.addEventListener('dragstart', function (e) {
        var handle = e.target.closest('.skill-drag');
        if (!handle) { e.preventDefault(); return; }
        dragRow = handle.closest('tr');
        dragRow.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
        // Firefox needs data set for the drag to start at all.
        e.dataTransfer.setData('text/plain', '');
    });

    tbody.addEventListener('dragover', function (e) {
        if (!dragRow) return;
        e.preventDefault();
        var over = e.target.closest('tr');
        if (!over || over === dragRow) return;
        var box = over.getBoundingClientRect();
        var below = (e.clientY - box.top) > box.height / 2;
        clearMarks();
        over.classList.add('drop-target');
        tbody.insertBefore(dragRow, below ? over.nextSibling : over);
    });

    tbody.addEventListener('drop', function (e) { e.preventDefault(); });

    tbody.addEventListener('dragend', function () {
        if (!dragRow) return;
        dragRow.classList.remove('dragging');
        dragRow = null;
        clearMarks();
        save();
    });

    function save() {
        var ids = Array.prototype.map.call(
            tbody.querySelectorAll('[data-skill-row]'),
            function (r) { return r.getAttribute('data-skill-row'); }
        );

        var token = document.querySelector('#skill-add-form input[name="_token"]');

        fetch(@json(route('skill.reorder')), {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': token ? token.value : ''
            },
            body: JSON.stringify({ ids: ids })
        }).then(function (r) {
            if (r.ok && window.jQuery && jQuery.notify) { jQuery.notify('Order saved', 'success'); }
        }).catch(function () {
            if (window.jQuery && jQuery.notify) { jQuery.notify('Could not save the new order', 'error'); }
        });
    }
})();
</script>
@endpush

@php
    // A failed save comes back here, so reopen whichever row was being edited.
    $openForm = old('_form');

    // A skill is one short word, so it gets a box per language in the row
    // rather than the tabbed block the longer forms use.
    $locales = (array) config('locales.supported', []);
    $default = (string) config('locales.default', 'en');
    $others = array_diff_key($locales, [$default => true]);
@endphp

<x-template1.admin.master.master-layout>
    <x-template1.admin.header.breadcrumbs-main :breadcrumbs="$breadcrumbs"/>

    <style>
        .skill-table td, .skill-table th { vertical-align: middle; }
        .skill-bar { height: 8px; border-radius: 4px; background: #ebedf2; overflow: hidden; min-width: 90px; }
        .skill-bar span { display: block; height: 100%; border-radius: 4px; background: var(--brand-primary, #212529); }
        .skill-table tfoot input { border-color: #b8e0c8; }

        /* A touch shorter than the stock 42px: a skill is one short word, and
           the row carries up to three boxes. The % addon follows, or the pair
           stops lining up. */
        .skill-table .form-control:not(.form-control-sm),
        .skill-table .input-group-text { padding-top: 5px; padding-bottom: 5px; }
        .skill-table .btn-icon-sm { width: 34px; height: 34px; padding: 0; display: inline-flex; align-items: center; justify-content: center; }

        .skill-drag { cursor: grab; color: #b3b8c4; width: 44px; text-align: center; }
        .skill-drag:active { cursor: grabbing; }
        .skill-table tbody tr.dragging { opacity: .45; background: #f6f7fb; }
        .skill-table tbody tr.drop-target td { border-top: 2px solid var(--brand-primary, #212529); }

        /* One box per language, each behind a tag of the same width so the
           boxes line up down the column. */
        .skill-lang { display: flex; align-items: center; gap: 8px; margin-top: 6px; }
        .skill-lang:first-child { margin-top: 0; }
        .skill-lang-tag { flex: 0 0 auto; min-width: 86px; font-size: .74rem; font-weight: 600;
            letter-spacing: .02em; color: #6c757d; }

        @media (max-width: 575px) {
            .skill-lang-tag { min-width: 60px; }
        }

        /* A row shows either its text or its inputs, never both. */
        .skill-table tbody .s-edit { display: none; }
        .skill-table tbody tr.is-editing .s-view { display: none; }
        .skill-table tbody tr.is-editing .s-edit { display: block; }
        .skill-table tbody tr.is-editing .input-group.s-edit { display: flex; }
        .skill-table tbody tr.is-editing td.text-end .s-edit { display: inline-flex; }
    </style>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{ __('admin.ui.my_skills') }}</div>
                <div class="card-category">Shown on your website and in your resume. Add one in the bottom row, and drag rows to change the order.</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover skill-table" id="skilltable">
                        <thead>
                            <tr>
                                <th style="width:44px"></th>
                                <th>Skill</th>
                                <th style="width:220px">{{ __('admin.ui.level') }}</th>
                                <th style="width:120px" class="text-end">{{ __('admin.ui.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($skill as $data)
                            @php $editing = $openForm === 'edit-'.$data->id; @endphp
                            <tr data-skill-row="{{ $data->id }}" @class(['is-editing' => $editing])>
                                <td class="skill-drag" draggable="true" title="{{ __('admin.ui.drag_to_reorder') }}">
                                    <i class="fas fa-grip-vertical"></i>
                                </td>
                                <td>
                                    <span class="s-view">
                                        <b>{{ $data->name }}</b>
                                        {{-- How many other languages this skill is written in,
                                             so a gap is visible without opening the row. --}}
                                        @php $filled = collect($others)->filter(fn ($m, $code) => filled($data->translationsFor($code)['name'] ?? null))->count(); @endphp
                                        @if($filled)<span class="badge bg-success ms-1">{{ $filled }}</span>@endif
                                    </span>

                                    <div class="s-edit">
                                        {{-- The default language is tagged like the others so all
                                             three boxes start at the same place. --}}
                                        <div class="skill-lang">
                                            <span class="skill-lang-tag">{{ $locales[$default]['native'] ?? $default }}</span>
                                            <input type="text" class="form-control form-control-sm" form="skill-edit-{{ $data->id }}" name="name"
                                                   maxlength="255" required value="{{ $editing ? old('name') : $data->name }}">
                                        </div>

                                        {{-- Leave one empty and that language shows the default. --}}
                                        @foreach($others as $code => $meta)
                                        <div class="skill-lang">
                                            <span class="skill-lang-tag">{{ $meta['native'] ?? $code }}</span>
                                            <input type="text" class="form-control form-control-sm" form="skill-edit-{{ $data->id }}"
                                                   name="translations[{{ $code }}][name]" maxlength="255"
                                                   value="{{ $editing ? old('translations.'.$code.'.name') : ($data->translationsFor($code)['name'] ?? '') }}">
                                        </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <div class="s-view d-flex align-items-center" style="gap:10px">
                                        <div class="skill-bar flex-grow-1"><span style="width: {{ $data->level }}%"></span></div>
                                        <small class="text-muted">{{ $data->level }}%</small>
                                    </div>
                                    <div class="input-group s-edit">
                                        <input type="number" class="form-control" form="skill-edit-{{ $data->id }}" name="level"
                                               min="0" max="100" required value="{{ $editing ? old('level') : $data->level }}">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-info btn-sm btn-icon-sm s-view" data-skill-edit="{{ $data->id }}" title="{{ __('admin.ui.edit') }}">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <a href="{{ route('skill.delete', $data->id) }}" class="btn btn-danger btn-sm btn-icon-sm s-view" title="{{ __('admin.ui.delete') }}"
                                       data-confirm="{{ __('admin.confirm.q_delete_skill', ['name' => $data->name]) }}"
                                       data-confirm-title="{{ __('admin.confirm.t_delete_skill') }}" data-confirm-ok="{{ __('admin.confirm.ok_delete') }}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <button type="submit" class="btn btn-success btn-sm btn-icon-sm s-edit" form="skill-edit-{{ $data->id }}" title="{{ __('admin.ui.save') }}">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-icon-sm s-edit" data-skill-cancel="{{ $data->id }}" title="{{ __('admin.confirm.cancel') }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td>
                                    <div class="skill-lang">
                                        <span class="skill-lang-tag">{{ $locales[$default]['native'] ?? $default }}</span>
                                        <input type="text" class="form-control form-control-sm" form="skill-add-form" name="name" maxlength="255"
                                               placeholder="{{ __('admin.ui.skill_name') }}" value="{{ $openForm === 'add' ? old('name') : '' }}">
                                    </div>

                                    @foreach($others as $code => $meta)
                                    <div class="skill-lang">
                                        <span class="skill-lang-tag">{{ $meta['native'] ?? $code }}</span>
                                        <input type="text" class="form-control form-control-sm" form="skill-add-form"
                                               name="translations[{{ $code }}][name]" maxlength="255"
                                               value="{{ $openForm === 'add' ? old('translations.'.$code.'.name') : '' }}">
                                    </div>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" class="form-control" form="skill-add-form" name="level" min="0" max="100"
                                               value="{{ $openForm === 'add' ? old('level') : 80 }}">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <button type="submit" class="btn btn-info btn-sm btn-icon-sm" form="skill-add-form" title="{{ __('admin.ui.add_skill') }}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <button type="reset" class="btn btn-danger btn-sm btn-icon-sm" form="skill-add-form" title="{{ __('admin.confirm.ok_clear') }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- The inputs live in the table and point here by form=, because a form
         cannot wrap a set of table cells. --}}
    <form id="skill-add-form" action="{{ route('skill.create') }}" method="post">
        @csrf
        <input type="hidden" name="_form" value="add">
    </form>
    @foreach($skill as $data)
    <form id="skill-edit-{{ $data->id }}" action="{{ route('skill.update', $data->id) }}" method="post">
        @csrf
        <input type="hidden" name="_form" value="edit-{{ $data->id }}">
    </form>
    @endforeach
</x-template1.admin.master.master-layout>