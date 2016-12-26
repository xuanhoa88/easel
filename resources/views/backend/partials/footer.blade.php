<footer id="footer">
    Thank you for creating with <a href="http://canvas.toddaustin.io" target="_blank">Canvas</a>&nbsp;&#183;&nbsp; {{ Canvas\Models\Settings::canvasVersion() }}

    <ul class="f-menu">
        <li><a href="{!! route('admin') !!}">Home</a></li>
        <li><a href="{!! route('admin.post.index') !!}">Posts</a></li>
        <li><a href="{!! route('admin.tag.index') !!}">Tags</a></li>
        <li><a href="{!! route('admin.upload') !!}">Media</a></li>
        <li><a href="{!! route('admin.tools') !!}">Tools</a></li>
        <li><a href="{!! route('admin.settings') !!}">Settings</a></li>
        <li><a href="mailto:austin.todd.j@gmail.com">Support</a></li>
    </ul>
</footer>