@foreach($entities as $entity)
    <option value="{{ $entity->id }}" {{ in_array($entity->id, $selectedIds) ? 'selected' : '' }}>
        {{ $entity->name ?? $entity->title }}
    </option>
@endforeach