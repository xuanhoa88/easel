<footer id="footer">
    Thank you for creating with <a href="http://canvas.toddaustin.io" target="_blank">Canvas</a>&nbsp;&#183;&nbsp; {{ Canvas\Models\Settings::canvasVersion() }}

    <ul class="f-menu">
        <li><a href="{{ url('admin') }}">Home</a></li>
        <li><a href="{{ url('admin/post') }}">Posts</a></li>
        <li><a href="{{ url('admin/tag') }}">Tags</a></li>
        <li><a href="{{ url('admin/upload') }}">Media</a></li>
        <li><a href="{{ url('admin/tools') }}">Tools</a></li>
        <li><a href="{{ url('admin/settings') }}">Settings</a></li>
        <li><a href="mailto:austin.todd.j@gmail.com">Support</a></li>
    </ul>
</footer>