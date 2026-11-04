<div class="card-soft teacher-card">
    @if($teacher->photo_url)
        <img src="{{ $teacher->photo_url }}" alt="{{ $teacher->name }}" class="teacher-photo" loading="lazy">
    @else
        <div class="teacher-initials">{{ $teacher->initials }}</div>
    @endif
    <div class="teacher-card-body">
        <h6>{{ $teacher->name }}</h6>
        <div class="role">{{ $teacher->position }}</div>
        @if($teacher->subject)
            <div class="subject">{{ $teacher->subject }}</div>
        @endif
        @if($teacher->nip)
            <div class="subject small mt-1">NIP. {{ $teacher->nip }}</div>
        @endif
    </div>
</div>
