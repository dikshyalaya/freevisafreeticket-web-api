@foreach ($trainings as $training)
    <option value="{{ $training->id }}">{{ $training->title }}</option>
@endforeach
