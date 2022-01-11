<table class="form-table">
    <tbody>
        <tr>
            <th scope="row">
                <label for="">Agent Name</label>
            </th>
            <td>
                <input type="text" name="agent_name" class="regular-text" value="<?php echo esc_attr( get_post_meta( $post->ID, 'agent_name', true ) ); ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="">Agent Title</label>
            </th>
            <td>
                <input type="text" name="agent_title" class="regular-text" value="<?php echo esc_attr( get_post_meta( $post->ID, 'agent_title', true ) ); ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="">Agent Type</label>
            </th>
            <td>
                <?php $agent_type = get_post_meta( $post->ID, 'agent_type', true ); ?>
                <?php if ( ! $agent_type ) : ?>
                    <p><input type="radio" name="agent_type" value="number" checked="checked"> WhatsApp Number</p>
                <?php else: ?>
                    <p><input type="radio" name="agent_type" value="number" <?php checked( 'number', $agent_type ); ?> > WhatsApp Number</p>
                <?php endif; ?>
                <p><input type="radio" name="agent_type" value="group" <?php checked( 'group', $agent_type ); ?> > WhatsApp Group</p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="">Agent WhatsApp Number</label>
            </th>
            <td>
                <input type="number" name="agent_number" class="regular-text" step="1" value="<?php echo esc_attr( get_post_meta( $post->ID, 'agent_number', true ) ); ?>">
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="">Agent WhatsApp Group ID</label>
            </th>
            <td>
                <input type="text" name="agent_group_id" class="regular-text" value="<?php echo esc_attr( get_post_meta( $post->ID, 'agent_group_id', true ) ); ?>">
                <p class="description">Enter WhatsApp Group ID</p>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="">Pre-defined Message</label>
            </th>
            <td>
                <textarea name="pre_defined_message" class="regular-text" style="height:120px;"><?php echo esc_textarea( get_post_meta( $post->ID, 'pre_defined_message', true ) ); ?></textarea>
                <p class="description">Use <code>{{url}}</code> for display current URL.</p>
            </td>
        </tr>
    </tbody>
</table>