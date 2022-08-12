@foreach ($skills as $skill)
    <option value="{{ $skill->id }}">{{ $skill->title }}</option>
@endforeach
