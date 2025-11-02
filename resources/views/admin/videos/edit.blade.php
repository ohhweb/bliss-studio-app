<!-- This is a basic page for now. We will integrate it into a proper layout later. -->

<h1>Edit Video: {{ $video->title }}</h1>

<!-- Display validation errors if they exist -->
@if ($errors->any())
    <div style="color: red;">
        <strong>Whoops! Something went wrong.</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="/admin/videos/{{ $video->id }}">
    @csrf <!-- Cross-Site Request Forgery security token -->
    @method('PUT') <!-- Tell Laravel this is an UPDATE/PUT request -->

    <div style="margin-bottom: 15px;">
        <label for="title">Title</label><br>
        <input type="text" name="title" id="title" value="{{ old('title', $video->title) }}" required style="width: 300px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="description">Description</label><br>
        <textarea name="description" id="description" rows="5" style="width: 300px;">{{ old('description', $video->description) }}</textarea>
    </div>

    <div style="margin-bottom: 15px;">
        <label for="video_url">Video URL</label><br>
        <input type="text" name="video_url" id="video_url" value="{{ old('video_url', $video->video_url) }}" required style="width: 300px;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="thumbnail_url">Thumbnail URL</label><br>
        <input type="text" name="thumbnail_url" id="thumbnail_url" value="{{ old('thumbnail_url', $video->thumbnail_url) }}" required style="width: 300px;">
    </div>

    <!-- We will make this a dynamic dropdown later -->
    <div style="margin-bottom: 15px;">
        <label for="category_id">Category ID</label><br>
        <input type="number" name="category_id" id="category_id" value="{{ old('category_id', $video->category_id) }}" required>
    </div>

    <button type="submit">Update Video</button>
    <a href="/admin/videos">Cancel</a>
</form>