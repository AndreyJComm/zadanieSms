<!-- text input -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

        <?php
            $entity_model = $crud->model;
        ?>
        <select
                name="{{ $field['selectName'] }}"
                @include('crud::inc.field_attributes')
        >

            @if ($entity_model::isColumnNullable($field['name']))
                <option value="">-</option>
            @endif
             @if (isset($field['model']))
                @foreach ($field['model']::all() as $connected_entity_entry)
                    @if(old($field['selectName']) == $connected_entity_entry->getKey() || (is_null(old($field['selectName'])) && isset($field['value']) && $field['value'] == $connected_entity_entry->getKey()))
                        <option value="{{ $connected_entity_entry->{$field['prefix']} }}" selected>{{ $connected_entity_entry->{$field['prefix']} . " " . $connected_entity_entry->{$field['country']} }}</option>
                    @else
                        <option value="{{ $connected_entity_entry->{$field['prefix']} }}">{{ $connected_entity_entry->{$field['prefix']} . " " . $connected_entity_entry->{$field['country']}  }}</option>
                    @endif
                @endforeach
            @endif
        </select>


        <input
                type="text"
                name="{{ $field['name'] }}"
                value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '' )) }}"
                @include('crud::inc.field_attributes')
        >
        @if(isset($field['suffix'])) <div class="input-group-addon">{!! $field['suffix'] !!}</div> @endif
        @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>


{{-- FIELD EXTRA CSS  --}}
{{-- push things in the after_styles section --}}

{{-- @push('crud_fields_styles')
    <!-- no styles -->
@endpush --}}


{{-- FIELD EXTRA JS --}}
{{-- push things in the after_scripts section --}}

{{-- @push('crud_fields_scripts')
    <!-- no scripts -->
@endpush --}}


{{-- Note: you can use @if ($crud->checkIfFieldIsFirstOfItsType($field, $fields)) to only load some CSS/JS once, even though there are multiple instances of it --}}