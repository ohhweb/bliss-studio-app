<!-- This is just a basic unstyled form to start -->
<h1>Add New Video</h1>

<form method="POST" action="/admin/videos">
    @csrf <!-- IMPORTANT: Security token -->

    <div>
        <label for="title">Title</label>
        <input type="text" name="title" id="title" required>
    </div>

    <div>
        <label for="description">Description</label>
        <textarea name="description" id="description"></textarea>
    </div>

    <div>
        <label for="video_url">Video URL</label>
        <input type="text" name="video_url" id="video_url" required>
    </div>

    <div>
        <label for="thumbnail_url">Thumbnail URL</label>
        <input type="text" name="thumbnail_url" id="thumbnail_url" required>
    </div>

    <!-- We will make this a dynamic dropdown later -->
    <div>
        <label for="category_id">Category ID</label>
        <input type="number" name="category_id" id="category_id" value="1" required>
    </div>

    <button type="submit">Save Video</button>
</form>