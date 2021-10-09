@foreach($railLines as $railLine)
    <li class="name-area fix-color-2"><a class="ajax-stations not-bold" id="{{ $railLine->rail_line_id }}-{{ $prefectureId }}" data-railLineId="{{ $railLine->rail_line_id }}" data-prefectureId="{{ $prefectureId }}">{{ $railLine->rail_line_name }}</a>
        <ul>

        </ul>
    </li>
@endforeach
