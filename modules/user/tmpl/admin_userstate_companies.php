<?php if (!defined('ABSPATH')) die('Restricted Access'); ?>
<span class="js-admin-title"><?php echo __('User Stats Companies', 'js-jobs') ?></span>
<?php
if (!empty(jsjobs::$_data[0])) {
    ?>  		
    <table id="js-table">
        <thead>
            <tr>
                <th class="left-row"><?php echo __('Name', 'js-jobs'); ?></th>
                <th><?php echo __('Category', 'js-jobs'); ?></th>
                <th><?php echo __('Created', 'js-jobs'); ?></th>
                <th><?php echo __('Status', 'js-jobs'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $status = array('1' => __('Job Approved', 'js-jobs'), '-1' => __('Job Rejected', 'js-jobs'));
            $deleteimg = 'remove.png';
            $deletealt = __('Delete', 'js-jobs');
            for ($i = 0, $n = count(jsjobs::$_data[0]); $i < $n; $i++) {
                $row = jsjobs::$_data[0][$i];
                ?>
                <tr valign="top">
                    <td class="left-row"><?php echo esc_html($row->name); ?></td>
                    <td><?php echo esc_html($row->cat_title); ?></td>
                    <td><?php echo esc_html(date_i18n($this->config['date_format'], jsjobslib::jsjobs_strtotime($row->created))); ?></td>
                    <td>
                        <?php
                        if ($row->status == 1)
                            echo "<font color='green'>" . esc_html($status[$row->status]) . "</font>";
                        elseif ($row->status == -1)
                            echo "<font color='red'>" . esc_html($status[$row->status]) . "</font>";
                        else
                            echo "<font color='blue'>" . esc_html($status[$row->status]) . "</font>";
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <?php
    if (jsjobs::$_data[1]) {
        echo '<div class="tablenav"><div class="tablenav-pages">' . wp_kses_post(jsjobs::$_data[1]) . '</div></div>';
    }
} else {
    $msg = __('No record found','js-jobs');
    JSJOBSlayout::getNoRecordFound($msg);
}
?>