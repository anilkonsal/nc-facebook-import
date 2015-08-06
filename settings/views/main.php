<div class="wrap">
    <h2>Facebook Posts Import Settings</h2>
    <form method="post" action="options.php">
        <?php
        do_settings_sections('fi_plugin_settings');
        settings_fields('fi_plugin_settings_group');
        submit_button();
        ?>
    </form>
</div>